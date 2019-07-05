<?php

namespace App\Exceptions;

use Exception;
use App\Enums\Error;
use Symfony\Component\HttpFoundation\Response as Response;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Exceptions\TokenBlacklistedException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        if ($exception instanceof UnauthorizedHttpException) {
            // detect previous instance
            if ($exception->getPrevious() instanceof TokenExpiredException) {
                return response()->json(
                    ['error' =>
                                [
                                    'code' => Error::AUTH0008,
                                    'message' => Error::getDescription(Error::AUTH0008)
                                ]
                    ], $exception->getStatusCode()
                );
            } else if ($exception->getPrevious() instanceof TokenInvalidException) {
                return response()->json(
                    ['error' =>
                                [
                                    'code' => Error::AUTH0007,
                                    'message' => Error::getDescription(Error::AUTH0007)
                                ]
                    ], $exception->getStatusCode()
                );
            } else if ($exception->getPrevious() instanceof TokenBlacklistedException) {
                return response()->json(
                    ['error' =>
                                [
                                    'code' => Error::AUTH0009,
                                    'message' => Error::getDescription(Error::AUTH0009)
                                ]
                    ], $exception->getStatusCode()
                );
                return response()->json(['error' => "TOKEN_BLACKLISTED"], $exception->getStatusCode());
            } else {
                return response()->json(
                    ['error' =>
                                [
                                    'code' => Error::AUTH0010,
                                    'message' => Error::getDescription(Error::AUTH0010)
                                ]
                    ], Response::HTTP_UNAUTHORIZED
                );
            }
        }

        return parent::render($request, $exception);
    }

    /**

     * Convert an authentication exception into an unauthenticated response.

     *

     * @param  \Illuminate\Http\Request  $request

     * @param  \Illuminate\Auth\AuthenticationException  $exception

     * @return \Illuminate\Http\Response

     */

    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson()) {
            return response()->json(
                ['error' =>
                            [
                                'code' => Error::AUTH0007,
                                'message' => Error::getDescription(Error::AUTH0007)
                            ]
                ], Response::HTTP_UNAUTHORIZED
            );
        }

        return redirect()->guest('login');
    }
}
