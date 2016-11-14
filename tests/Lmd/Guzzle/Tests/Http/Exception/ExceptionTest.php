<?php

namespace Lmd\Guzzle\Tests\Http\Exception;

use Lmd\Guzzle\Http\Message\Response;
use Lmd\Guzzle\Http\Message\Request;
use Lmd\Guzzle\Http\Exception\RequestException;
use Lmd\Guzzle\Http\Exception\BadResponseException;

class ExceptionTest extends \Lmd\Guzzle\Tests\GuzzleTestCase
{
    /**
     * @covers \Lmd\Guzzle\Http\Exception\RequestException
     */
    public function testRequestException()
    {
        $e = new RequestException('Message');
        $request = new Request('GET', 'http://www.guzzle-project.com/');
        $e->setRequest($request);
        $this->assertEquals($request, $e->getRequest());
    }

    /**
     * @covers \Lmd\Guzzle\Http\Exception\BadResponseException
     */
    public function testBadResponseException()
    {
        $e = new BadResponseException('Message');
        $response = new Response(200);
        $e->setResponse($response);
        $this->assertEquals($response, $e->getResponse());
    }

    /**
     * @covers \Lmd\Guzzle\Http\Exception\BadResponseException::factory
     */
    public function testCreatesGenericErrorExceptionOnError()
    {
        $request = new Request('GET', 'http://www.example.com');
        $response = new Response(307);
        $e = BadResponseException::factory($request, $response);
        $this->assertInstanceOf('Lmd\Guzzle\Http\Exception\BadResponseException', $e);
    }

    /**
     * @covers \Lmd\Guzzle\Http\Exception\BadResponseException::factory
     */
    public function testCreatesClientErrorExceptionOnClientError()
    {
        $request = new Request('GET', 'http://www.example.com');
        $response = new Response(404);
        $e = BadResponseException::factory($request, $response);
        $this->assertInstanceOf('Lmd\Guzzle\Http\Exception\ClientErrorResponseException', $e);
    }

    /**
     * @covers \Lmd\Guzzle\Http\Exception\BadResponseException::factory
     */
    public function testCreatesServerErrorExceptionOnServerError()
    {
        $request = new Request('GET', 'http://www.example.com');
        $response = new Response(503);
        $e = BadResponseException::factory($request, $response);
        $this->assertInstanceOf('Lmd\Guzzle\Http\Exception\ServerErrorResponseException', $e);
    }
}
