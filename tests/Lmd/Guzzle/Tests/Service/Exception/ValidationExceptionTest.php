<?php

namespace Lmd\Guzzle\Tests\Service\Exception;

use Lmd\Guzzle\Service\Exception\ValidationException;

class ValidationExceptionTest extends \Lmd\Guzzle\Tests\GuzzleTestCase
{
    public function testCanSetAndRetrieveErrors()
    {
        $errors = array('foo', 'bar');

        $e = new ValidationException('Foo');
        $e->setErrors($errors);
        $this->assertEquals($errors, $e->getErrors());
    }
}
