<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Http\Middleware\ApiKeyAuth;
use Illuminate\Contracts\Debug\ExceptionHandler;
use App\Exceptions\Handler;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(
            ExceptionHandler::class,
            Handler::class
        );
    }

    public function boot(): void
    {
        // Register middleware alias
        $this->app['router']->aliasMiddleware('api.auth', ApiKeyAuth::class);
    }
}
