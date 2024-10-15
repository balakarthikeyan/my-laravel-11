<?php

use Illuminate\Http\Request;
use App\Exceptions\CustomException;
use Illuminate\Foundation\Application;
use App\Exceptions\InvalidNoteException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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

        $exceptions->render(function (Request $request, NotFoundHttpException $exception) {
            if ($exception instanceof NotFoundHttpException && $request->is('api/*') && $request->expectsJson()) {
                return response()->json([
                    'status' => 'false',
                    'message' => 'Route Not found',
                ], 404);
            }
        });

        $exceptions->render(function (Request $request, Exception $exception) {
            // This will replace our 404 response with a JSON response.
            if ($exception instanceof ModelNotFoundException && $request->wantsJson()) {
                return response()->json([
                    'status' => 'false',
                    'message' => 'Resource/Model Not found',
                ], 404);
            }
            return parent::render($request, $exception);
        });

        $exceptions->render(function (Request $request, AuthenticationException $exception) {
            if ($request->is('api/*') && $request->expectsJson()) {
                return response()->json([
                    'status' => 'false',
                    'message' => $exception->getMessage(),
                ], 401);
            } else {
                return redirect()->guest(route('login'));
            }
        });

        $exceptions->render(function (Request $request, Exception $exception) {
            if ($exception instanceof CustomException) {
                return response()->json([
                    'status' => 'false',
                    'message' => $exception->getMessage(),
                ], 500);
            }
            return parent::render($request, $exception);
        });

    })->create();
