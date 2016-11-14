<?php

namespace Lmd\Guzzle\Tests\Plugin\Backoff;

use Lmd\Guzzle\Http\Message\Response;
use Lmd\Guzzle\Plugin\Backoff\CurlBackoffStrategy;
use Lmd\Guzzle\Http\Exception\CurlException;

/**
 * @covers \Lmd\Guzzle\Plugin\Backoff\CurlBackoffStrategy
 * @covers \Lmd\Guzzle\Plugin\Backoff\AbstractErrorCodeBackoffStrategy
 */
class CurlBackoffStrategyTest extends \Lmd\Guzzle\Tests\GuzzleTestCase
{
    public function testRetriesWithExponentialDelay()
    {
        $this->assertNotEmpty(CurlBackoffStrategy::getDefaultFailureCodes());
        $strategy = new CurlBackoffStrategy();
        $this->assertTrue($strategy->makesDecision());
        $request = $this->getMock('Lmd\Guzzle\Http\Message\Request', array(), array(), '', false);
        $e = new CurlException();
        $e->setError('foo', CURLE_BAD_CALLING_ORDER);
        $this->assertEquals(false, $strategy->getBackoffPeriod(0, $request, null, $e));

        foreach (CurlBackoffStrategy::getDefaultFailureCodes() as $code) {
            $this->assertEquals(0, $strategy->getBackoffPeriod(0, $request, null, $e->setError('foo', $code)));
        }
    }

    public function testIgnoresNonErrors()
    {
        $strategy = new CurlBackoffStrategy();
        $request = $this->getMock('Lmd\Guzzle\Http\Message\Request', array(), array(), '', false);
        $this->assertEquals(false, $strategy->getBackoffPeriod(0, $request, new Response(200)));
    }
}
