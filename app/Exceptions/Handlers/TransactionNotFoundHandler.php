<?php

namespace App\Exceptions\Handlers;

use hamidreza2005\LaravelApiErrorHandler\Handlers\ExceptionHandler;

class TransactionNotFoundHandler extends ExceptionHandler
{
    public function setStatusCode(): void
    {
        $this->statusCode = 404;
    }

    public function setMessage(): void
    {
        $this->message = $this->exception->getMessage() ?: 'Transaction not found or access denied';
    }
}
