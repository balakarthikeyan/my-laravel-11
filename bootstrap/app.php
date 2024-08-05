<?php

use Illuminate\Http\Client\Request;
use Illuminate\Foundation\Application;
use App\Exceptions\InvalidNoteException;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        
        $middleware->append(\App\Http\Middleware\Localization::class);
        $middleware->alias([
            'logRequests' => \App\Http\Middleware\LogRequests::class,
            'authUser' => \App\Http\Middleware\AuthUser::class,
        ]);

        // Or removing multiple default middleware
        // $middleware->remove([
        //     \Illuminate\Http\Middleware\ValidatePostSize::class,
        //     \Illuminate\Http\Middleware\TrustProxies::class,
        //     \Illuminate\Http\Middleware\HandleCors::class,
        // ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {

        // $exceptions->renderable(function (InvalidNoteException $e) {
        //     info('Note Exception: ' . $e->getMessage());
        // });

        // $exceptions->dontReport(InvalidNoteException::class);

    })->create();
