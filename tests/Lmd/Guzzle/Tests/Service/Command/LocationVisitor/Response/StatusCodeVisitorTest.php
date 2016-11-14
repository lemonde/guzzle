<?php

namespace Lmd\Guzzle\Tests\Service\Command\LocationVisitor\Response;

use Lmd\Guzzle\Service\Description\Parameter;
use Lmd\Guzzle\Http\Message\Response;
use Lmd\Guzzle\Service\Command\LocationVisitor\Response\StatusCodeVisitor as Visitor;

/**
 * @covers \Lmd\Guzzle\Service\Command\LocationVisitor\Response\StatusCodeVisitor
 */
class StatusCodeVisitorTest extends AbstractResponseVisitorTest
{
    public function testVisitsLocation()
    {
        $visitor = new Visitor();
        $param = new Parameter(array('location' => 'statusCode', 'name' => 'code'));
        $visitor->visit($this->command, $this->response, $param, $this->value);
        $this->assertEquals(200, $this->value['code']);
    }
}
