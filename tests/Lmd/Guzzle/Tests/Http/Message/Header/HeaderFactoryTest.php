<?php

namespace Lmd\Guzzle\Tests\Http\Message\Header;

use Lmd\Guzzle\Http\Message\Header\HeaderFactory;

/**
 * @covers \Lmd\Guzzle\Http\Message\Header\HeaderFactory
 */
class HeaderFactoryTest extends \Lmd\Guzzle\Tests\GuzzleTestCase
{
    public function testCreatesBasicHeaders()
    {
        $f = new HeaderFactory();
        $h = $f->createHeader('Foo', 'Bar');
        $this->assertInstanceOf('Lmd\Guzzle\Http\Message\Header', $h);
        $this->assertEquals('Foo', $h->getName());
        $this->assertEquals('Bar', (string) $h);
    }

    public function testCreatesSpecificHeaders()
    {
        $f = new HeaderFactory();
        $h = $f->createHeader('Link', '<http>; rel="test"');
        $this->assertInstanceOf('Lmd\Guzzle\Http\Message\Header\Link', $h);
        $this->assertEquals('Link', $h->getName());
        $this->assertEquals('<http>; rel="test"', (string) $h);
    }
}
