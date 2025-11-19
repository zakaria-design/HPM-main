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
        'auth' => \App\Http\Middleware\Authenticate::class,
        'isDirektur' => \App\Http\Middleware\VerifyIsDirektur::class,
        'isAdmin' => \App\Http\Middleware\VerifyIsAdmin::class,
        'isManager' =>\App\Http\Middleware\VerifyIsManager::class,
        'isKaryawan' =>\App\Http\Middleware\VerifyIsKaryawan::class,
    ]);
})
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
