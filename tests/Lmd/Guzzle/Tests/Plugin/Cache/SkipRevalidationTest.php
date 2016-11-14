<?php

namespace Lmd\Guzzle\Tests\Plugin\Cache;

use Lmd\Guzzle\Http\Message\Request;
use Lmd\Guzzle\Http\Message\Response;
use Lmd\Guzzle\Plugin\Cache\SkipRevalidation;

/**
 * @covers \Lmd\Guzzle\Plugin\Cache\SkipRevalidation
 */
class SkipRevalidationTest extends \Lmd\Guzzle\Tests\GuzzleTestCase
{
    public function testSkipsRequestRevalidation()
    {
        $skip = new SkipRevalidation();
        $this->assertTrue($skip->revalidate(new Request('GET', 'http://foo.com'), new Response(200)));
    }
}
