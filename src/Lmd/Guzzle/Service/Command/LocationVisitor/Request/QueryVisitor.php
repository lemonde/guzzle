<?php

namespace Lmd\Guzzle\Service\Command\LocationVisitor\Request;

use Lmd\Guzzle\Http\Message\RequestInterface;
use Lmd\Guzzle\Service\Command\CommandInterface;
use Lmd\Guzzle\Service\Description\Parameter;

/**
 * Visitor used to apply a parameter to a request's query string
 */
class QueryVisitor extends AbstractRequestVisitor
{
    public function visit(CommandInterface $command, RequestInterface $request, Parameter $param, $value)
    {
        $request->getQuery()->set($param->getWireName(), $this->prepareValue($value, $param));
    }
}
