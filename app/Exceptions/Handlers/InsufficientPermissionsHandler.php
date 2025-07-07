<?php

namespace App\Exceptions\Handlers;

use hamidreza2005\LaravelApiErrorHandler\Handlers\ExceptionHandler;

class InsufficientPermissionsHandler extends ExceptionHandler
{
    public function setStatusCode(): void
    {
        $this->statusCode = 403;
    }

    public function setMessage(): void
    {
        $this->message = $this->exception->getMessage() ?: 'Insufficient permissions for this operation';
    }
}
