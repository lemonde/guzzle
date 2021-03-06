<?php

namespace Lmd\Guzzle\Service\Command\LocationVisitor\Request;

use Lmd\Guzzle\Http\Message\RequestInterface;
use Lmd\Guzzle\Service\Command\CommandInterface;
use Lmd\Guzzle\Service\Description\Parameter;

/**
 * Visitor used to change the location in which a response body is saved
 */
class ResponseBodyVisitor extends AbstractRequestVisitor
{
    public function visit(CommandInterface $command, RequestInterface $request, Parameter $param, $value)
    {
        $request->setResponseBody($value);
    }
}
