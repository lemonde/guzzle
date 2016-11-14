<?php

namespace Lmd\Guzzle\Tests\Service\Resource;

use Lmd\Guzzle\Service\Resource\MapResourceIteratorFactory;
use Lmd\Guzzle\Tests\Service\Mock\Command\MockCommand;

/**
 * @covers \Lmd\Guzzle\Service\Resource\MapResourceIteratorFactory
 */
class MapResourceIteratorFactoryTest extends \Lmd\Guzzle\Tests\GuzzleTestCase
{
    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Iterator was not found for mock_command
     */
    public function testEnsuresIteratorClassExists()
    {
        $factory = new MapResourceIteratorFactory(array('Foo', 'Bar'));
        $factory->build(new MockCommand());
    }

    public function testBuildsResourceIterators()
    {
        $factory = new MapResourceIteratorFactory(array(
            'mock_command' => 'Lmd\Guzzle\Tests\Service\Mock\Model\MockCommandIterator'
        ));
        $iterator = $factory->build(new MockCommand());
        $this->assertInstanceOf('Lmd\Guzzle\Tests\Service\Mock\Model\MockCommandIterator', $iterator);
    }

    public function testUsesWildcardMappings()
    {
        $factory = new MapResourceIteratorFactory(array(
            '*' => 'Lmd\Guzzle\Tests\Service\Mock\Model\MockCommandIterator'
        ));
        $iterator = $factory->build(new MockCommand());
        $this->assertInstanceOf('Lmd\Guzzle\Tests\Service\Mock\Model\MockCommandIterator', $iterator);
    }
}
