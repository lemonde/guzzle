<?php

namespace Lmd\Guzzle\Tests\Batch;

use Lmd\Guzzle\Batch\Batch;

/**
 * @covers \Lmd\Guzzle\Batch\AbstractBatchDecorator
 */
class AbstractBatchDecoratorTest extends \Lmd\Guzzle\Tests\GuzzleTestCase
{
    public function testProxiesToWrappedObject()
    {
        $batch = new Batch(
            $this->getMock('Lmd\Guzzle\Batch\BatchTransferInterface'),
            $this->getMock('Lmd\Guzzle\Batch\BatchDivisorInterface')
        );

        $decoratorA = $this->getMockBuilder('Lmd\Guzzle\Batch\AbstractBatchDecorator')
            ->setConstructorArgs(array($batch))
            ->getMockForAbstractClass();

        $decoratorB = $this->getMockBuilder('Lmd\Guzzle\Batch\AbstractBatchDecorator')
            ->setConstructorArgs(array($decoratorA))
            ->getMockForAbstractClass();

        $decoratorA->add('foo');
        $this->assertFalse($decoratorB->isEmpty());
        $this->assertFalse($batch->isEmpty());
        $this->assertEquals(array($decoratorB, $decoratorA), $decoratorB->getDecorators());
        $this->assertEquals(array(), $decoratorB->flush());
    }
}
