<?php

namespace Lmd\Guzzle\Tests\Plugin\Backoff;

use Lmd\Guzzle\Plugin\Backoff\LinearBackoffStrategy;

/**
 * @covers \Lmd\Guzzle\Plugin\Backoff\LinearBackoffStrategy
 */
class LinearBackoffStrategyTest extends \Lmd\Guzzle\Tests\GuzzleTestCase
{
    public function testRetriesWithLinearDelay()
    {
        $strategy = new LinearBackoffStrategy(5);
        $this->assertFalse($strategy->makesDecision());
        $request = $this->getMock('Lmd\Guzzle\Http\Message\Request', array(), array(), '', false);
        $this->assertEquals(0, $strategy->getBackoffPeriod(0, $request));
        $this->assertEquals(5, $strategy->getBackoffPeriod(1, $request));
        $this->assertEquals(10, $strategy->getBackoffPeriod(2, $request));
    }
}
