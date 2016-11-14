<?php

namespace Lmd\Guzzle\Tests\Log;

use Lmd\Guzzle\Log\ClosureLogAdapter;

/**
 * @covers \Lmd\Guzzle\Log\ClosureLogAdapter
 */
class ClosureLogAdapterTest extends \Lmd\Guzzle\Tests\GuzzleTestCase
{
    public function testClosure()
    {
        $that = $this;
        $modified = null;
        $this->adapter = new ClosureLogAdapter(function($message, $priority, $extras = null) use ($that, &$modified) {
            $modified = array($message, $priority, $extras);
        });
        $this->adapter->log('test', LOG_NOTICE, 'localhost');
        $this->assertEquals(array('test', LOG_NOTICE, 'localhost'), $modified);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testThrowsExceptionWhenNotCallable()
    {
        $this->adapter = new ClosureLogAdapter(123);
    }
}
