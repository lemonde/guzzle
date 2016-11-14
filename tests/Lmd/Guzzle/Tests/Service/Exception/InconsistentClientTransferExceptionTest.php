<?php

namespace Lmd\Guzzle\Tests\Service\Exception;

use Lmd\Guzzle\Service\Exception\InconsistentClientTransferException;

class InconsistentClientTransferExceptionTest extends \Lmd\Guzzle\Tests\GuzzleTestCase
{
    public function testStoresCommands()
    {
        $items = array('foo', 'bar');
        $e = new InconsistentClientTransferException($items);
        $this->assertEquals($items, $e->getCommands());
    }
}
