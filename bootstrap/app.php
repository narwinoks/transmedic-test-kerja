<?php

use App\Middleware\HandleAppearance;
use App\Middleware\HandleInertiaRequests;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Middleware\AddLinkHeadersForPreloadedAssets;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use App\ServerResponse;
use function App\error;
return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../modules/Client/routes.php',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->encryptCookies(except: ['appearance', 'sidebar_state']);
        $middleware->redirectGuestsTo('/server/auth/login');
        $middleware->web(append: [
            HandleAppearance::class,
            HandleInertiaRequests::class,
            AddLinkHeadersForPreloadedAssets::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (Throwable $e, \Illuminate\Http\Request $request) {
            if ($e instanceof ModelNotFoundException) {
                $modelClass = explode('\\', $e->getModel());
                if (config('app.debug')) {
                    $message = array_merge(ServerResponse::INTERNAL_SERVER_ERROR,
                        ['stack' => $e->getMessage(), 'file' => $e->getFile(), 'line' => $e->getLine()]);
                } else {
                    $message = ServerResponse::INTERNAL_SERVER_ERROR;
                }
                Log::error('Model Not Found : ' . json_encode(end($modelClass) . ' not found', JSON_PRETTY_PRINT));

                return error($message, 404);
            }
            if ($e instanceof NotFoundHttpException) {
                Log::error('Not Found : ' . json_encode($e->getMessage(), JSON_PRETTY_PRINT));

                return error(ServerResponse::PATH_NOT_FOUND, 404);
            }
            if ($e instanceof AuthenticationException) {
                Log::error('Unauthenticated : ' . json_encode($e->getMessage(), JSON_PRETTY_PRINT));

                return error(ServerResponse::UNAUTHORIZED, 401);
            }

            if ($e instanceof AuthorizationException) {
                Log::error('Forbidden : ' . json_encode($e->getMessage(), JSON_PRETTY_PRINT));

                return error(ServerResponse::FORBIDDEN, 403);
            }
            if ($e instanceof ValidationException) {
                Log::error('Validation Error : ' . json_encode($e->errors(), JSON_PRETTY_PRINT));

                return error(ServerResponse::VALIDATION, 400, ['errors' => $e->errors()]);
            }
            if ($e instanceof QueryException) {
                if (config('app.debug')) {
                    $message = Str::between($e->getMessage(), '[7] ', ' (0x');
                    $newMessage = array_merge(ServerResponse::INTERNAL_SERVER_ERROR,
                        ['stack' => $message, 'file' => $e->getFile(), 'line' => $e->getLine()]);
                } else {
                    $newMessage = ServerResponse::INTERNAL_SERVER_ERROR;
                }
                Log::error('Query Error : ' . json_encode($newMessage, JSON_PRETTY_PRINT));

                return error($newMessage, 500);
            }
            if ($e instanceof MethodNotAllowedHttpException) {
                if (config('app.debug')) {
                    $message = array_merge(ServerResponse::METHOD_NOT_ALLOWED,
                        ['stack' => $e->getMessage(), 'file' => $e->getFile(), 'line' => $e->getLine()]);
                } else {
                    $message = ServerResponse::METHOD_NOT_ALLOWED;
                }
                Log::error('Method not allowed : ' . json_encode($e->getMessage(), JSON_PRETTY_PRINT));

                return error($message, 405);
            }
            if ($e instanceof HttpException) {
                if (config('app.debug')) {
                    $message = array_merge(ServerResponse::INTERNAL_SERVER_ERROR,
                        ['stack' => $e->getMessage(), 'file' => $e->getFile(), 'line' => $e->getLine()]);
                } else {
                    $message = ServerResponse::INTERNAL_SERVER_ERROR;
                }
                Log::error('Http error : ' . json_encode($e->getMessage(), JSON_PRETTY_PRINT));

                return error($message, 500);
            }
            if ($e instanceof Error) {
                $modelClass = explode('\\', $e->getMessage());
                if (config('app.debug')) {
                    $msg = array_merge(ServerResponse::INTERNAL_SERVER_ERROR,
                        ['stack' => $e->getMessage(), 'file' => $e->getFile(), 'line' => $e->getLine()]);
                    $message = array_merge($msg, $modelClass);
                } else {
                    $message = ServerResponse::INTERNAL_SERVER_ERROR;
                }
                Log::error('Error : ' . json_encode(end($modelClass), JSON_PRETTY_PRINT));

                return error($message, 500);
            }
            if ($e instanceof Exception) {
                if (config('app.debug')) {
                    $message = array_merge(ServerResponse::INTERNAL_SERVER_ERROR,
                        ['stack' => $e->getMessage(), 'file' => $e->getFile(), 'line' => $e->getLine()]);
                } else {
                    $message = ServerResponse::INTERNAL_SERVER_ERROR;
                }
                Log::error('Exception : ' . json_encode($e->getMessage(), JSON_PRETTY_PRINT));

                return error($message, 500);
            }

            return parent::render($request, $e);
        });
    })->create();
