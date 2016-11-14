<?php

namespace Lmd\Guzzle\Tests\Mock;

use Lmd\Guzzle\Plugin\ErrorResponse\ErrorResponseExceptionInterface;
use Lmd\Guzzle\Service\Command\CommandInterface;
use Lmd\Guzzle\Http\Message\Response;

class ErrorResponseMock extends \Exception implements ErrorResponseExceptionInterface
{
    public $command;
    public $response;

    public static function fromCommand(CommandInterface $command, Response $response)
    {
        return new self($command, $response);
    }

    public function __construct($command, $response)
    {
        $this->command = $command;
        $this->response = $response;
        $this->message = 'Error from ' . $response;
    }
}
