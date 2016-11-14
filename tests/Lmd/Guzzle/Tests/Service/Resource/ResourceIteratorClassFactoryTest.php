<?php

namespace Lmd\Guzzle\Tests\Service\Resource;

use Lmd\Guzzle\Service\Resource\ResourceIteratorClassFactory;
use Lmd\Guzzle\Tests\Service\Mock\Command\MockCommand;

/**
 * @covers \Lmd\Guzzle\Service\Resource\ResourceIteratorClassFactory
 * @covers \Lmd\Guzzle\Service\Resource\AbstractResourceIteratorFactory
 */
class ResourceIteratorClassFactoryTest extends \Lmd\Guzzle\Tests\GuzzleTestCase
{
    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Iterator was not found for mock_command
     */
    public function testEnsuresIteratorClassExists()
    {
        $factory = new ResourceIteratorClassFactory(array('Foo', 'Bar'));
        $factory->registerNamespace('Baz');
        $command = new MockCommand();
        $factory->build($command);
    }

    public function testBuildsResourceIterators()
    {
        $factory = new ResourceIteratorClassFactory('Lmd\Guzzle\Tests\Service\Mock\Model');
        $command = new MockCommand();
        $iterator = $factory->build($command, array('client.namespace' => 'Lmd\Guzzle\Tests\Service\Mock'));
        $this->assertInstanceOf('Lmd\Guzzle\Tests\Service\Mock\Model\MockCommandIterator', $iterator);
    }

    public function testChecksIfCanBuild()
    {
        $factory = new ResourceIteratorClassFactory('Lmd\Guzzle\Tests\Service');
        $this->assertFalse($factory->canBuild(new MockCommand()));
        $factory = new ResourceIteratorClassFactory('Lmd\Guzzle\Tests\Service\Mock\Model');
        $this->assertTrue($factory->canBuild(new MockCommand()));
    }
}
