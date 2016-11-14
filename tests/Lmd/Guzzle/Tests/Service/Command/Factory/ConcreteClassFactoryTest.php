<?php

namespace Lmd\Guzzle\Tests\Service\Command;

use Lmd\Guzzle\Tests\Service\Mock\MockClient;
use Lmd\Guzzle\Service\Command\Factory\ConcreteClassFactory;

/**
 * @covers \Lmd\Guzzle\Service\Command\Factory\ConcreteClassFactory
 */
class ConcreteClassFactoryTest extends \Lmd\Guzzle\Tests\GuzzleTestCase
{
    public function testProvider()
    {
        return array(
            array('foo', null, 'Lmd\\Guzzle\\Tests\\Service\\Mock\\Command\\'),
            array('mock_command', 'Lmd\Guzzle\Tests\Service\Mock\Command\MockCommand', 'Lmd\\Guzzle\\Tests\\Service\\Mock\\Command\\'),
            array('other_command', 'Lmd\Guzzle\Tests\Service\Mock\Command\OtherCommand', 'Lmd\\Guzzle\\Tests\\Service\\Mock\\Command\\'),
            array('sub.sub', 'Lmd\Guzzle\Tests\Service\Mock\Command\Sub\Sub', 'Lmd\\Guzzle\\Tests\\Service\\Mock\\Command\\'),
            array('sub.sub', null, 'Lmd\\Guzzle\\Foo\\'),
            array('foo', null, null),
            array('mock_command', 'Lmd\Guzzle\Tests\Service\Mock\Command\MockCommand', null),
            array('other_command', 'Lmd\Guzzle\Tests\Service\Mock\Command\OtherCommand', null),
            array('sub.sub', 'Lmd\Guzzle\Tests\Service\Mock\Command\Sub\Sub', null)
        );
    }

    /**
     * @dataProvider testProvider
     */
    public function testCreatesConcreteCommands($key, $result, $prefix)
    {
        if (!$prefix) {
            $client = new MockClient();
        } else {
            $client = new MockClient('', array(
                'command.prefix' => $prefix
            ));
        }

        $factory = new ConcreteClassFactory($client);

        if (is_null($result)) {
            $this->assertNull($factory->factory($key));
        } else {
            $this->assertInstanceof($result, $factory->factory($key));
        }
    }
}
