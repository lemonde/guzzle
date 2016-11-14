<?php

namespace Lmd\Guzzle\Tests\Mock;

class MockMulti extends \Lmd\Guzzle\Http\Curl\CurlMulti
{
    public function getHandle()
    {
        return $this->multiHandle;
    }
}
