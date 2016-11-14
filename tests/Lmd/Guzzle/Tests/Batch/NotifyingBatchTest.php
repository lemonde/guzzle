<?php

namespace Lmd\Guzzle\Tests\Batch;

use Lmd\Guzzle\Batch\NotifyingBatch;
use Lmd\Guzzle\Batch\Batch;

/**
 * @covers \Lmd\Guzzle\Batch\NotifyingBatch
 */
class NotifyingBatchTest extends \Lmd\Guzzle\Tests\GuzzleTestCase
{
    public function testNotifiesAfterFlush()
    {
        $batch = $this->getMock('Lmd\Guzzle\Batch\Batch', array('flush'), array(
            $this->getMock('Lmd\Guzzle\Batch\BatchTransferInterface'),
            $this->getMock('Lmd\Guzzle\Batch\BatchDivisorInterface')
        ));

        $batch->expects($this->once())
            ->method('flush')
            ->will($this->returnValue(array('foo', 'baz')));

        $data = array();
        $decorator = new NotifyingBatch($batch, function ($batch) use (&$data) {
            $data[] = $batch;
        });

        $decorator->add('foo')->add('baz');
        $decorator->flush();
        $this->assertEquals(array(array('foo', 'baz')), $data);
    }

    /**
     * @expectedException \Lmd\Guzzle\Common\Exception\InvalidArgumentException
     */
    public function testEnsuresCallableIsValid()
    {
        $batch = new Batch(
            $this->getMock('Lmd\Guzzle\Batch\BatchTransferInterface'),
            $this->getMock('Lmd\Guzzle\Batch\BatchDivisorInterface')
        );
        $decorator = new NotifyingBatch($batch, 'foo');
    }
}
