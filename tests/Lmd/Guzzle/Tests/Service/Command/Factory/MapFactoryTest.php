<?php

namespace Lmd\Guzzle\Tests\Service\Command;

use Lmd\Guzzle\Service\Command\Factory\MapFactory;

/**
 * @covers \Lmd\Guzzle\Service\Command\Factory\MapFactory
 */
class MapFactoryTest extends \Lmd\Guzzle\Tests\GuzzleTestCase
{
    public function mapProvider()
    {
        return array(
            array('foo', null),
            array('test', 'Lmd\Guzzle\Tests\Service\Mock\Command\MockCommand'),
            array('test1', 'Lmd\Guzzle\Tests\Service\Mock\Command\OtherCommand')
        );
    }

    /**
     * @dataProvider mapProvider
     */
    public function testCreatesCommandsUsingMappings($key, $result)
    {
        $factory = new MapFactory(array(
            'test'  => 'Lmd\Guzzle\Tests\Service\Mock\Command\MockCommand',
            'test1' => 'Lmd\Guzzle\Tests\Service\Mock\Command\OtherCommand'
        ));

        if (is_null($result)) {
            $this->assertNull($factory->factory($key));
        } else {
            $this->assertInstanceof($result, $factory->factory($key));
        }
    }
}
