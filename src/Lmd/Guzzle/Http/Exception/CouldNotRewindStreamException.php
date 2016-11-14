<?php

namespace Lmd\Guzzle\Http\Exception;

use Lmd\Guzzle\Common\Exception\RuntimeException;

class CouldNotRewindStreamException extends RuntimeException implements HttpException {}
