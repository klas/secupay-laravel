<?php

namespace App\Exceptions;

use Exception;

class InvalidFlagbitOperationException extends Exception
{
    protected $message = 'Invalid flagbit operation';
    protected $code = 400;
}
