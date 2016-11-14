<?php

namespace Lmd\Guzzle\Tests\Plugin\Cache;

use Lmd\Guzzle\Http\Message\Request;
use Lmd\Guzzle\Http\Message\Response;
use Lmd\Guzzle\Plugin\Cache\DenyRevalidation;

/**
 * @covers \Lmd\Guzzle\Plugin\Cache\DenyRevalidation
 */
class DenyRevalidationTest extends \Lmd\Guzzle\Tests\GuzzleTestCase
{
    public function testDeniesRequestRevalidation()
    {
        $deny = new DenyRevalidation();
        $this->assertFalse($deny->revalidate(new Request('GET', 'http://foo.com'), new Response(200)));
    }
}
