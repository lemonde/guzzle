<?php

namespace Lmd\Guzzle\Tests\Batch;

use Lmd\Guzzle\Batch\HistoryBatch;
use Lmd\Guzzle\Batch\Batch;

/**
 * @covers \Lmd\Guzzle\Batch\HistoryBatch
 */
class HistoryBatchTest extends \Lmd\Guzzle\Tests\GuzzleTestCase
{
    public function testMaintainsHistoryOfItemsAddedToBatch()
    {
        $batch = new Batch(
            $this->getMock('Lmd\Guzzle\Batch\BatchTransferInterface'),
            $this->getMock('Lmd\Guzzle\Batch\BatchDivisorInterface')
        );

        $history = new HistoryBatch($batch);
        $history->add('foo')->add('baz');
        $this->assertEquals(array('foo', 'baz'), $history->getHistory());
        $history->clearHistory();
        $this->assertEquals(array(), $history->getHistory());
    }
}
