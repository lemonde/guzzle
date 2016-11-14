<?php

namespace Lmd\Guzzle\Tests\Plugin\Cookie;

use Lmd\Guzzle\Common\Event;
use Lmd\Guzzle\Plugin\Cookie\Cookie;
use Lmd\Guzzle\Plugin\Cookie\CookieJar\ArrayCookieJar;
use Lmd\Guzzle\Http\Client;
use Lmd\Guzzle\Http\Message\Response;
use Lmd\Guzzle\Plugin\Cookie\CookiePlugin;

/**
 * @group server
 * @covers \Lmd\Guzzle\Plugin\Cookie\CookiePlugin
 */
class CookiePluginTest extends \Lmd\Guzzle\Tests\GuzzleTestCase
{
    public function testExtractsAndStoresCookies()
    {
        $response = new Response(200);
        $mock = $this->getMockBuilder('Lmd\Guzzle\Plugin\Cookie\CookieJar\ArrayCookieJar')
            ->setMethods(array('addCookiesFromResponse'))
            ->getMock();

        $mock->expects($this->exactly(1))
            ->method('addCookiesFromResponse')
            ->with($response);

        $plugin = new CookiePlugin($mock);
        $plugin->onRequestSent(new Event(array(
            'response' => $response
        )));
    }

    public function testAddsCookiesToRequests()
    {
        $cookie = new Cookie(array(
            'name'  => 'foo',
            'value' => 'bar'
        ));

        $mock = $this->getMockBuilder('Lmd\Guzzle\Plugin\Cookie\CookieJar\ArrayCookieJar')
            ->setMethods(array('getMatchingCookies'))
            ->getMock();

        $mock->expects($this->once())
            ->method('getMatchingCookies')
            ->will($this->returnValue(array($cookie)));

        $plugin = new CookiePlugin($mock);

        $client = new Client();
        $client->getEventDispatcher()->addSubscriber($plugin);

        $request = $client->get('http://www.example.com');
        $plugin->onRequestBeforeSend(new Event(array(
            'request' => $request
        )));

        $this->assertEquals('bar', $request->getCookie('foo'));
    }

    public function testCookiesAreExtractedFromRedirectResponses()
    {
        $plugin = new CookiePlugin(new ArrayCookieJar());
        $this->getServer()->flush();
        $this->getServer()->enqueue(array(
            "HTTP/1.1 302 Moved Temporarily\r\n" .
            "Set-Cookie: test=583551; expires=Wednesday, 23-Mar-2050 19:49:45 GMT; path=/\r\n" .
            "Location: /redirect\r\n\r\n",
            "HTTP/1.1 200 OK\r\n" .
            "Content-Length: 0\r\n\r\n",
            "HTTP/1.1 200 OK\r\n" .
            "Content-Length: 0\r\n\r\n"
        ));

        $client = new Client($this->getServer()->getUrl());
        $client->getEventDispatcher()->addSubscriber($plugin);

        $client->get()->send();
        $request = $client->get();
        $request->send();
        $this->assertEquals('test=583551', $request->getHeader('Cookie'));

        $requests = $this->getServer()->getReceivedRequests(true);
        // Confirm subsequent requests have the cookie.
        $this->assertEquals('test=583551', $requests[2]->getHeader('Cookie'));
        // Confirm the redirected request has the cookie.
        $this->assertEquals('test=583551', $requests[1]->getHeader('Cookie'));
    }

    public function testCookiesAreNotAddedWhenParamIsSet()
    {
        $jar = new ArrayCookieJar();
        $plugin = new CookiePlugin($jar);

        $jar->add(new Cookie(array(
            'domain'  => 'example.com',
            'path'    => '/',
            'name'    => 'test',
            'value'   => 'hi',
            'expires' => time() + 3600
        )));

        $client = new Client('http://example.com');
        $client->getEventDispatcher()->addSubscriber($plugin);

        // Ensure that it is normally added
        $request = $client->get();
        $request->setResponse(new Response(200), true);
        $request->send();
        $this->assertEquals('hi', $request->getCookie('test'));

        // Now ensure that it is not added
        $request = $client->get();
        $request->getParams()->set('cookies.disable', true);
        $request->setResponse(new Response(200), true);
        $request->send();
        $this->assertNull($request->getCookie('test'));
    }

    public function testProvidesCookieJar()
    {
        $jar = new ArrayCookieJar();
        $plugin = new CookiePlugin($jar);
        $this->assertSame($jar, $plugin->getCookieJar());
    }

    public function testEscapesCookieDomains()
    {
        $cookie = new Cookie(array('domain' => '/foo/^$[A-Z]+/'));
        $this->assertFalse($cookie->matchesDomain('foo'));
    }
}
