<?php

namespace Lmd\Guzzle\Service\Command\LocationVisitor\Request;

use Lmd\Guzzle\Http\Message\RequestInterface;
use Lmd\Guzzle\Service\Command\CommandInterface;
use Lmd\Guzzle\Service\Description\Parameter;

/**
 * Visitor used to apply a parameter to a POST field
 */
class PostFieldVisitor extends AbstractRequestVisitor
{
    public function visit(CommandInterface $command, RequestInterface $request, Parameter $param, $value)
    {
        $request->setPostField($param->getWireName(), $this->prepareValue($value, $param));
    }
}
