<?php

namespace Lmd\Guzzle\Tests\Service\Resource;

use Lmd\Guzzle\Service\Resource\CompositeResourceIteratorFactory;
use Lmd\Guzzle\Service\Resource\ResourceIteratorClassFactory;
use Lmd\Guzzle\Tests\Service\Mock\Command\MockCommand;

/**
 * @covers \Lmd\Guzzle\Service\Resource\CompositeResourceIteratorFactory
 */
class CompositeResourceIteratorFactoryTest extends \Lmd\Guzzle\Tests\GuzzleTestCase
{
    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Iterator was not found for mock_command
     */
    public function testEnsuresIteratorClassExists()
    {
        $factory = new CompositeResourceIteratorFactory(array(
            new ResourceIteratorClassFactory(array('Foo', 'Bar'))
        ));
        $cmd = new MockCommand();
        $this->assertFalse($factory->canBuild($cmd));
        $factory->build($cmd);
    }

    public function testBuildsResourceIterators()
    {
        $f1 = new ResourceIteratorClassFactory('Lmd\Guzzle\Tests\Service\Mock\Model');
        $factory = new CompositeResourceIteratorFactory(array());
        $factory->addFactory($f1);
        $command = new MockCommand();
        $iterator = $factory->build($command, array('client.namespace' => 'Lmd\Guzzle\Tests\Service\Mock'));
        $this->assertInstanceOf('Lmd\Guzzle\Tests\Service\Mock\Model\MockCommandIterator', $iterator);
    }
}
