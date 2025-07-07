<?php

namespace App\Exceptions;

use hamidreza2005\LaravelApiErrorHandler\Traits\ApiErrorHandler;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    use ApiErrorHandler;

    protected $dontReport = [
        //
    ];

    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    public function register()
    {
        //
    }

    public function render($request, Throwable $e)
    {
        if ($request->is('api/*')) {
            return $this->handle($this->prepareException($e));
        }

        return parent::render($request, $e);
    }
}
