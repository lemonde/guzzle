<?php

namespace Lmd\Guzzle\Tests\Service\Command;

use Lmd\Guzzle\Service\Description\ServiceDescription;
use Lmd\Guzzle\Service\Command\Factory\ServiceDescriptionFactory;
use Lmd\Guzzle\Inflection\Inflector;

/**
 * @covers \Lmd\Guzzle\Service\Command\Factory\ServiceDescriptionFactory
 */
class ServiceDescriptionFactoryTest extends \Lmd\Guzzle\Tests\GuzzleTestCase
{
    public function testProvider()
    {
        return array(
            array('foo', null),
            array('jar_jar', 'Lmd\Guzzle\Tests\Service\Mock\Command\MockCommand'),
            array('binks', 'Lmd\Guzzle\Tests\Service\Mock\Command\OtherCommand')
        );
    }

    /**
     * @dataProvider testProvider
     */
    public function testCreatesCommandsUsingServiceDescriptions($key, $result)
    {
        $d = $this->getDescription();

        $factory = new ServiceDescriptionFactory($d);
        $this->assertSame($d, $factory->getServiceDescription());

        if (is_null($result)) {
            $this->assertNull($factory->factory($key));
        } else {
            $this->assertInstanceof($result, $factory->factory($key));
        }
    }

    public function testUsesUcFirstIfNoExactMatch()
    {
        $d = $this->getDescription();
        $factory = new ServiceDescriptionFactory($d, new Inflector());
        $this->assertInstanceof('Lmd\Guzzle\Tests\Service\Mock\Command\OtherCommand', $factory->factory('Test'));
        $this->assertInstanceof('Lmd\Guzzle\Tests\Service\Mock\Command\OtherCommand', $factory->factory('test'));
    }

    public function testUsesInflectionIfNoExactMatch()
    {
        $d = $this->getDescription();
        $factory = new ServiceDescriptionFactory($d, new Inflector());
        $this->assertInstanceof('Lmd\Guzzle\Tests\Service\Mock\Command\OtherCommand', $factory->factory('Binks'));
        $this->assertInstanceof('Lmd\Guzzle\Tests\Service\Mock\Command\OtherCommand', $factory->factory('binks'));
        $this->assertInstanceof('Lmd\Guzzle\Tests\Service\Mock\Command\MockCommand', $factory->factory('JarJar'));
        $this->assertInstanceof('Lmd\Guzzle\Tests\Service\Mock\Command\MockCommand', $factory->factory('jar_jar'));
    }

    protected function getDescription()
    {
        return ServiceDescription::factory(array(
            'operations' => array(
                'jar_jar' => array('class' => 'Lmd\Guzzle\Tests\Service\Mock\Command\MockCommand'),
                'binks' => array('class' => 'Lmd\Guzzle\Tests\Service\Mock\Command\OtherCommand'),
                'Test' => array('class' => 'Lmd\Guzzle\Tests\Service\Mock\Command\OtherCommand')
            )
        ));
    }
}
