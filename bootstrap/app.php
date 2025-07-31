<?php

use App\Http\Middleware\HandleAppearance;
use App\Http\Middleware\HandleInertiaRequests;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Middleware\AddLinkHeadersForPreloadedAssets;
use Illuminate\Http\Middleware\SetCacheHeaders;
use Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Cookie encryption
        $middleware->encryptCookies(except: ['appearance', 'sidebar_state']);

        // Global middleware
        $middleware->trustProxies(at: [
            '127.0.0.1',
            'localhost'
        ]);

        // Web middleware group
        $middleware->web(append: [
            HandleAppearance::class,
            HandleInertiaRequests::class,
            AddLinkHeadersForPreloadedAssets::class,
        ]);

        // API middleware group
        $middleware->api(prepend: [
            EnsureFrontendRequestsAreStateful::class,
        ], append: [
            'throttle:api',
            SetCacheHeaders::class,
        ]);

        // CORS headers - crucial for your 401 errors
        $middleware->validateCsrfTokens(except: [
            'sanctum/csrf-cookie',
            'api/*'
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // Custom exception handling can go here
    })
    ->withProviders([
        \App\Providers\RouteServiceProvider::class,
    ])
    ->create();
