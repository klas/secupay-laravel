<?php

use hamidreza2005\LaravelApiErrorHandler\Handlers\{
    ServerInternalExceptionHandler,
    NotFoundExceptionHandler,
    AccessDeniedExceptionHandler,
    ValidationExceptionHandler
};
use App\Exceptions\Handlers\{
    TransactionNotFoundHandler,
    FlagbitOperationHandler,
    InsufficientPermissionsHandler
};

return [
    "handlers" => [
        NotFoundExceptionHandler::class => [
            "Symfony\Component\HttpKernel\Exception\NotFoundHttpException",
            "Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException"
        ],
        ServerInternalExceptionHandler::class => [
            "ErrorException",
            "Illuminate\Database\QueryException"
        ],
        AccessDeniedExceptionHandler::class => [
            "Illuminate\Auth\AuthenticationException",
            "Symfony\Component\HttpKernel\Exception\HttpException"
        ],
        ValidationExceptionHandler::class => [
            "Illuminate\Validation\ValidationException"
        ],
        // Add your custom handlers
        TransactionNotFoundHandler::class => [
            "App\Exceptions\TransactionNotFoundException"
        ],
        FlagbitOperationHandler::class => [
            "App\Exceptions\InvalidFlagbitOperationException"
        ],
        InsufficientPermissionsHandler::class => [
            "App\Exceptions\InsufficientPermissionsException"
        ],
    ],

    "internal_error_handler" => ServerInternalExceptionHandler::class,
];
