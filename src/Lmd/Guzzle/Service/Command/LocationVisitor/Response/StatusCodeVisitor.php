<?php

namespace Lmd\Guzzle\Service\Command\LocationVisitor\Response;

use Lmd\Guzzle\Http\Message\Response;
use Lmd\Guzzle\Service\Description\Parameter;
use Lmd\Guzzle\Service\Command\CommandInterface;

/**
 * Location visitor used to add the status code of a response to a key in the result
 */
class StatusCodeVisitor extends AbstractResponseVisitor
{
    public function visit(
        CommandInterface $command,
        Response $response,
        Parameter $param,
        &$value,
        $context =  null
    ) {
        $value[$param->getName()] = $response->getStatusCode();
    }
}
