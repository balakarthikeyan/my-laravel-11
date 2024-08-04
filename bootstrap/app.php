<?php

use Illuminate\Foundation\Application;
use App\Exceptions\InvalidNoteException;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'logRequests' => \App\Http\Middleware\LogRequests::class,
            'authUser' => \App\Http\Middleware\AuthUser::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // $exceptions->renderable(function (NotFoundHttpException $e) {
        //     return response()->json([
        //         'message' => 'Record not found.'
        //     ], 404);
        // });

        // $exceptions->renderable(function (InvalidNoteException $e) {
        //     info('Note Exception: ' . $e->getMessage());
        // });

        // $exceptions->dontReport(InvalidNoteException::class);

    })->create();
