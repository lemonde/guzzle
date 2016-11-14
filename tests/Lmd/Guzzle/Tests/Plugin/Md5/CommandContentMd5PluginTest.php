<?php

namespace Lmd\Guzzle\Tests\Plugin\Md5;

use Lmd\Guzzle\Common\Event;
use Lmd\Guzzle\Plugin\Md5\CommandContentMd5Plugin;
use Lmd\Guzzle\Service\Description\ServiceDescription;
use Lmd\Guzzle\Service\Client;

/**
 * @covers \Lmd\Guzzle\Plugin\Md5\CommandContentMd5Plugin
 */
class CommandContentMd5PluginTest extends \Lmd\Guzzle\Tests\GuzzleTestCase
{
    protected function getClient()
    {
        $description = new ServiceDescription(array(
            'operations' => array(
                'test' => array(
                    'httpMethod' => 'PUT',
                    'parameters' => array(
                        'ContentMD5' => array(),
                        'Body'       => array(
                            'location' => 'body'
                        )
                    )
                )
            )
        ));

        $client = new Client();
        $client->setDescription($description);

        return $client;
    }

    public function testHasEvents()
    {
        $this->assertNotEmpty(CommandContentMd5Plugin::getSubscribedEvents());
    }

    public function testValidatesMd5WhenParamExists()
    {
        $client = $this->getClient();
        $command = $client->getCommand('test', array(
            'Body'       => 'Foo',
            'ContentMD5' => true
        ));
        $event = new Event(array('command' => $command));
        $request = $command->prepare();
        $plugin = new CommandContentMd5Plugin();
        $plugin->onCommandBeforeSend($event);
        $this->assertEquals('E1bGfXrRY42Ba/uCLdLCXQ==', (string) $request->getHeader('Content-MD5'));
    }

    public function testDoesNothingWhenNoPayloadExists()
    {
        $client = $this->getClient();
        $client->getDescription()->getOperation('test')->setHttpMethod('GET');
        $command = $client->getCommand('test');
        $event = new Event(array('command' => $command));
        $request = $command->prepare();
        $plugin = new CommandContentMd5Plugin();
        $plugin->onCommandBeforeSend($event);
        $this->assertNull($request->getHeader('Content-MD5'));
    }

    public function testAddsValidationToResponsesOfContentMd5()
    {
        $client = $this->getClient();
        $client->getDescription()->getOperation('test')->setHttpMethod('GET');
        $command = $client->getCommand('test', array(
            'ValidateMD5' => true
        ));
        $event = new Event(array('command' => $command));
        $request = $command->prepare();
        $plugin = new CommandContentMd5Plugin();
        $plugin->onCommandBeforeSend($event);
        $listeners = $request->getEventDispatcher()->getListeners('request.complete');
        $this->assertNotEmpty($listeners);
    }

    public function testIgnoresValidationWhenDisabled()
    {
        $client = $this->getClient();
        $client->getDescription()->getOperation('test')->setHttpMethod('GET');
        $command = $client->getCommand('test', array(
            'ValidateMD5' => false
        ));
        $event = new Event(array('command' => $command));
        $request = $command->prepare();
        $plugin = new CommandContentMd5Plugin();
        $plugin->onCommandBeforeSend($event);
        $listeners = $request->getEventDispatcher()->getListeners('request.complete');
        $this->assertEmpty($listeners);
    }
}
