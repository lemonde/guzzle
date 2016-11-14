<?php

namespace Lmd\Guzzle\Tests\Parser;

use Lmd\Guzzle\Parser\ParserRegistry;

/**
 * @covers \Lmd\Guzzle\Parser\ParserRegistry
 */
class ParserRegistryTest extends \Lmd\Guzzle\Tests\GuzzleTestCase
{
    public function testStoresObjects()
    {
        $r = new ParserRegistry();
        $c = new \stdClass();
        $r->registerParser('foo', $c);
        $this->assertSame($c, $r->getParser('foo'));
    }

    public function testReturnsNullWhenNotFound()
    {
        $r = new ParserRegistry();
        $this->assertNull($r->getParser('FOO'));
    }

    public function testReturnsLazyLoadedDefault()
    {
        $r = new ParserRegistry();
        $c = $r->getParser('cookie');
        $this->assertInstanceOf('Lmd\Guzzle\Parser\Cookie\CookieParser', $c);
        $this->assertSame($c, $r->getParser('cookie'));
    }
}
