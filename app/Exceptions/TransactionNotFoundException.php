<?php

namespace App\Exceptions;

use Exception;

class TransactionNotFoundException extends Exception
{
    protected $message = 'Transaction not found or access denied';
    protected $code = 404;
}
