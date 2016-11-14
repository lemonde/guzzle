<?php

namespace Lmd\Guzzle\Tests\Service\Command\LocationVisitor\Response;

use Lmd\Guzzle\Service\Description\Parameter;
use Lmd\Guzzle\Http\Message\Response;
use Lmd\Guzzle\Service\Command\LocationVisitor\Response\ReasonPhraseVisitor as Visitor;

/**
 * @covers \Lmd\Guzzle\Service\Command\LocationVisitor\Response\ReasonPhraseVisitor
 */
class ReasonPhraseVisitorTest extends AbstractResponseVisitorTest
{
    public function testVisitsLocation()
    {
        $visitor = new Visitor();
        $param = new Parameter(array('location' => 'reasonPhrase', 'name' => 'phrase'));
        $visitor->visit($this->command, $this->response, $param, $this->value);
        $this->assertEquals('OK', $this->value['phrase']);
    }
}
