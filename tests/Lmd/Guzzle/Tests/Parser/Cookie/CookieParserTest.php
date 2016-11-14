<?php

namespace Lmd\Guzzle\Tests\Parser\Cookie;

use Lmd\Guzzle\Parser\Cookie\CookieParser;

/**
 * @covers \Lmd\Guzzle\Parser\Cookie\CookieParser
 */
class CookieParserTest extends CookieParserProvider
{
    protected $cookieParserClass = 'Lmd\Guzzle\Parser\Cookie\CookieParser';

    public function testUrlDecodesCookies()
    {
        $parser = new CookieParser();
        $result = $parser->parseCookie('foo=baz+bar', null, null, true);
        $this->assertEquals(array(
            'foo' => 'baz bar'
        ), $result['cookies']);
    }
}
