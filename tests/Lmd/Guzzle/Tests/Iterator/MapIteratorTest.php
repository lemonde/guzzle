<?php

namespace Lmd\Guzzle\Tests\Iterator;

use Lmd\Guzzle\Iterator\MapIterator;

/**
 * @covers \Lmd\Guzzle\Iterator\MapIterator
 */
class MapIteratorTest extends \PHPUnit_Framework_TestCase
{
    public function testFiltersValues()
    {
        $i = new MapIterator(new \ArrayIterator(range(0, 100)), function ($value) {
            return $value * 10;
        });

        $this->assertEquals(range(0, 1000, 10), iterator_to_array($i, false));
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testValidatesCallable()
    {
        $i = new MapIterator(new \ArrayIterator(), new \stdClass());
    }
}
