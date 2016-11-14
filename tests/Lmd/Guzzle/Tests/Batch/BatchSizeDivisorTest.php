<?php

namespace Lmd\Guzzle\Tests\Batch;

use Lmd\Guzzle\Batch\BatchSizeDivisor;

/**
 * @covers \Lmd\Guzzle\Batch\BatchSizeDivisor
 */
class BatchSizeDivisorTest extends \Lmd\Guzzle\Tests\GuzzleTestCase
{
    public function testDividesBatch()
    {
        $queue = new \SplQueue();
        $queue[] = 'foo';
        $queue[] = 'baz';
        $queue[] = 'bar';
        $d = new BatchSizeDivisor(3);
        $this->assertEquals(3, $d->getSize());
        $d->setSize(2);
        $batches = $d->createBatches($queue);
        $this->assertEquals(array(array('foo', 'baz'), array('bar')), $batches);
    }
}
