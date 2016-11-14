<?php

namespace Lmd\Guzzle\Tests\Log;

use Lmd\Guzzle\Log\ArrayLogAdapter;

class ArrayLogAdapterTest extends \Lmd\Guzzle\Tests\GuzzleTestCase
{
    public function testLog()
    {
        $adapter = new ArrayLogAdapter();
        $adapter->log('test', \LOG_NOTICE, 'localhost');
        $this->assertEquals(array(array('message' => 'test', 'priority' => \LOG_NOTICE, 'extras' => 'localhost')), $adapter->getLogs());
    }

    public function testClearLog()
    {
        $adapter = new ArrayLogAdapter();
        $adapter->log('test', \LOG_NOTICE, 'localhost');
        $adapter->clearLogs();
        $this->assertEquals(array(), $adapter->getLogs());
    }
}
