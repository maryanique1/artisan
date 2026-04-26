<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        channels: __DIR__.'/../routes/channels.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->redirectGuestsTo(function (\Illuminate\Http\Request $request) {
            if ($request->is('api/*') || $request->expectsJson()) {
                return null;
            }
            return route('admin.login');
        });

        $middleware->alias([
            'admin' => \App\Http\Middleware\EnsureIsAdmin::class,
            'artisan.role' => \App\Http\Middleware\EnsureIsArtisan::class,
            'artisan.verified' => \App\Http\Middleware\EnsureArtisanIsVerified::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
