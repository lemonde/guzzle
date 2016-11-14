<?php

namespace Lmd\Guzzle\Tests\Service\Command\LocationVisitor\Request;

use Lmd\Guzzle\Service\Command\LocationVisitor\Request\ResponseBodyVisitor as Visitor;

/**
 * @covers \Lmd\Guzzle\Service\Command\LocationVisitor\Request\ResponseBodyVisitor
 */
class ResponseBodyVisitorTest extends AbstractVisitorTestCase
{
    public function testVisitsLocation()
    {
        $visitor = new Visitor();
        $param = $this->getNestedCommand('response_body')->getParam('foo');
        $visitor->visit($this->command, $this->request, $param, sys_get_temp_dir() . '/foo.txt');
        $body = $this->readAttribute($this->request, 'responseBody');
        $this->assertContains('/foo.txt', $body->getUri());
    }
}
