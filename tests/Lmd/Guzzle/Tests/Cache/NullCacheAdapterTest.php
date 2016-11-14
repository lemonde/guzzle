<?php

namespace Lmd\Guzzle\Tests\Common\Cache;

use Lmd\Guzzle\Cache\NullCacheAdapter;

/**
 * @covers \Lmd\Guzzle\Cache\NullCacheAdapter
 */
class NullCacheAdapterTest extends \Lmd\Guzzle\Tests\GuzzleTestCase
{
    public function testNullCacheAdapter()
    {
        $c = new NullCacheAdapter();
        $this->assertEquals(false, $c->contains('foo'));
        $this->assertEquals(true, $c->delete('foo'));
        $this->assertEquals(false, $c->fetch('foo'));
        $this->assertEquals(true, $c->save('foo', 'bar'));
    }
}
