<?php

namespace Lmd\Guzzle\Tests\Plugin\Backoff;

use Lmd\Guzzle\Plugin\Backoff\ConstantBackoffStrategy;

/**
 * @covers \Lmd\Guzzle\Plugin\Backoff\ConstantBackoffStrategy
 */
class ConstantBackoffStrategyTest extends \Lmd\Guzzle\Tests\GuzzleTestCase
{
    public function testRetriesWithConstantDelay()
    {
        $strategy = new ConstantBackoffStrategy(3.5);
        $this->assertFalse($strategy->makesDecision());
        $request = $this->getMock('Lmd\Guzzle\Http\Message\Request', array(), array(), '', false);
        $this->assertEquals(3.5, $strategy->getBackoffPeriod(0, $request));
        $this->assertEquals(3.5, $strategy->getBackoffPeriod(1, $request));
    }
}
