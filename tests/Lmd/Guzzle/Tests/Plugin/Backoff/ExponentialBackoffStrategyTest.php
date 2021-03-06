<?php

namespace Lmd\Guzzle\Tests\Plugin\Backoff;

use Lmd\Guzzle\Plugin\Backoff\ExponentialBackoffStrategy;

/**
 * @covers \Lmd\Guzzle\Plugin\Backoff\ExponentialBackoffStrategy
 */
class ExponentialBackoffStrategyTest extends \Lmd\Guzzle\Tests\GuzzleTestCase
{
    public function testRetriesWithExponentialDelay()
    {
        $strategy = new ExponentialBackoffStrategy();
        $this->assertFalse($strategy->makesDecision());
        $request = $this->getMock('Lmd\Guzzle\Http\Message\Request', array(), array(), '', false);
        $this->assertEquals(1, $strategy->getBackoffPeriod(0, $request));
        $this->assertEquals(2, $strategy->getBackoffPeriod(1, $request));
        $this->assertEquals(4, $strategy->getBackoffPeriod(2, $request));
        $this->assertEquals(8, $strategy->getBackoffPeriod(3, $request));
        $this->assertEquals(16, $strategy->getBackoffPeriod(4, $request));
    }
}
