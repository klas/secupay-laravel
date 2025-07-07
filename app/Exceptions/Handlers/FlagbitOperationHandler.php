<?php

namespace App\Exceptions\Handlers;

use hamidreza2005\LaravelApiErrorHandler\Handlers\ExceptionHandler;

class FlagbitOperationHandler extends ExceptionHandler
{
    public function setStatusCode(): void
    {
        $this->statusCode = 400;
    }

    public function setMessage(): void
    {
        $this->message = $this->exception->getMessage() ?: 'Invalid flagbit operation';
    }
}
