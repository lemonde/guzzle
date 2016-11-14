<?php

namespace Lmd\Guzzle\Tests\Batch;

use Lmd\Guzzle\Batch\BatchBuilder;

/**
 * @covers \Lmd\Guzzle\Batch\BatchBuilder
 */
class BatchBuilderTest extends \Lmd\Guzzle\Tests\GuzzleTestCase
{
    private function getMockTransfer()
    {
        return $this->getMock('Lmd\Guzzle\Batch\BatchTransferInterface');
    }

    private function getMockDivisor()
    {
        return $this->getMock('Lmd\Guzzle\Batch\BatchDivisorInterface');
    }

    private function getMockBatchBuilder()
    {
        return BatchBuilder::factory()
            ->transferWith($this->getMockTransfer())
            ->createBatchesWith($this->getMockDivisor());
    }

    public function testFactoryCreatesInstance()
    {
        $builder = BatchBuilder::factory();
        $this->assertInstanceOf('Lmd\Guzzle\Batch\BatchBuilder', $builder);
    }

    public function testAddsAutoFlush()
    {
        $batch = $this->getMockBatchBuilder()->autoFlushAt(10)->build();
        $this->assertInstanceOf('Lmd\Guzzle\Batch\FlushingBatch', $batch);
    }

    public function testAddsExceptionBuffering()
    {
        $batch = $this->getMockBatchBuilder()->bufferExceptions()->build();
        $this->assertInstanceOf('Lmd\Guzzle\Batch\ExceptionBufferingBatch', $batch);
    }

    public function testAddHistory()
    {
        $batch = $this->getMockBatchBuilder()->keepHistory()->build();
        $this->assertInstanceOf('Lmd\Guzzle\Batch\HistoryBatch', $batch);
    }

    public function testAddsNotify()
    {
        $batch = $this->getMockBatchBuilder()->notify(function() {})->build();
        $this->assertInstanceOf('Lmd\Guzzle\Batch\NotifyingBatch', $batch);
    }

    /**
     * @expectedException \Lmd\Guzzle\Common\Exception\RuntimeException
     */
    public function testTransferStrategyMustBeSet()
    {
        $batch = BatchBuilder::factory()->createBatchesWith($this->getMockDivisor())->build();
    }

    /**
     * @expectedException \Lmd\Guzzle\Common\Exception\RuntimeException
     */
    public function testDivisorStrategyMustBeSet()
    {
        $batch = BatchBuilder::factory()->transferWith($this->getMockTransfer())->build();
    }

    public function testTransfersRequests()
    {
        $batch = BatchBuilder::factory()->transferRequests(10)->build();
        $this->assertInstanceOf('Lmd\Guzzle\Batch\BatchRequestTransfer', $this->readAttribute($batch, 'transferStrategy'));
    }

    public function testTransfersCommands()
    {
        $batch = BatchBuilder::factory()->transferCommands(10)->build();
        $this->assertInstanceOf('Lmd\Guzzle\Batch\BatchCommandTransfer', $this->readAttribute($batch, 'transferStrategy'));
    }
}
