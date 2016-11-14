<?php

namespace Lmd\Guzzle\Tests\Service\Command;

use Lmd\Guzzle\Service\Client;
use Lmd\Guzzle\Service\Description\ServiceDescription;

abstract class AbstractCommandTest extends \Lmd\Guzzle\Tests\GuzzleTestCase
{
    protected function getClient()
    {
        $client = new Client('http://www.google.com/');

        return $client->setDescription(ServiceDescription::factory(__DIR__ . '/../../TestData/test_service.json'));
    }
}
