<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Http\Request;
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
        /*RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });*/

        // Register middleware alias
        $this->app['router']->aliasMiddleware('api.auth', ApiKeyAuth::class);
    }
}
