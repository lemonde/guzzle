<?php

namespace Lmd\Guzzle\Tests\Service\Command\LocationVisitor\Response;

use Lmd\Guzzle\Service\Description\Parameter;
use Lmd\Guzzle\Http\Message\Response;
use Lmd\Guzzle\Service\Command\LocationVisitor\Response\BodyVisitor as Visitor;

/**
 * @covers \Lmd\Guzzle\Service\Command\LocationVisitor\Response\BodyVisitor
 */
class BodyVisitorTest extends AbstractResponseVisitorTest
{
    public function testVisitsLocation()
    {
        $visitor = new Visitor();
        $param = new Parameter(array('location' => 'body', 'name' => 'foo'));
        $visitor->visit($this->command, $this->response, $param, $this->value);
        $this->assertEquals('Foo', (string) $this->value['foo']);
    }
}
