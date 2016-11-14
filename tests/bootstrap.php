<?php

error_reporting(E_ALL | E_STRICT);

require_once 'PHPUnit/TextUI/TestRunner.php';
require dirname(__DIR__) . '/vendor/autoload.php';

// Add the services file to the default service builder
$servicesFile = __DIR__ . '/Lmd/Guzzle/Tests/TestData/services/services.json';
Lmd\Guzzle\Tests\GuzzleTestCase::setServiceBuilder(Lmd\Guzzle\Service\Builder\ServiceBuilder::factory($servicesFile));
