<?php

namespace Lmd\Guzzle\Tests\Http\Exception;

use Lmd\Guzzle\Http\Exception\CurlException;
use Lmd\Guzzle\Http\Curl\CurlHandle;

/**
 * @covers \Lmd\Guzzle\Http\Exception\CurlException
 */
class CurlExceptionTest extends \Lmd\Guzzle\Tests\GuzzleTestCase
{
    public function testStoresCurlError()
    {
        $e = new CurlException();
        $this->assertNull($e->getError());
        $this->assertNull($e->getErrorNo());
        $this->assertSame($e, $e->setError('test', 12));
        $this->assertEquals('test', $e->getError());
        $this->assertEquals(12, $e->getErrorNo());

        $handle = new CurlHandle(curl_init(), array());
        $e->setCurlHandle($handle);
        $this->assertSame($handle, $e->getCurlHandle());
        $handle->close();
    }
}
