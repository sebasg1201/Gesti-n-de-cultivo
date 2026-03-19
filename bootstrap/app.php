<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'check.license' => \App\Http\Middleware\CheckLicenseExpiration::class,
        ]);
        $middleware->redirectGuestsTo(fn (\Illuminate\Http\Request $request) => $request->is('super-admin*') || $request->is('SuperAdmin*') ? route('superadmin.login') : route('usuario.login'));
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
