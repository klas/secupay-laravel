<?php

namespace App\Exceptions;

use Exception;

class InsufficientPermissionsException extends Exception
{
    protected $message = 'Insufficient permissions for this operation';
    protected $code = 403;
}
