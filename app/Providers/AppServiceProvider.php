<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Http\Middleware\ApiKeyAuth;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Register middleware alias
        $this->app['router']->aliasMiddleware('api.auth', ApiKeyAuth::class);
    }
}
