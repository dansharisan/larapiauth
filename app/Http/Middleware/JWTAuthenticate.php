<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use JWTAuth;
use Tymon\JWTAuth\Token;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Illuminate\Session\TokenMismatchException;
use App\Http\AppResponse;

class JWTAuthenticate
{
    /**
    * Handle an incoming request.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  \Closure  $next
    * @param  string|null  $guard
    * @return mixed
    */
    public function handle($request, Closure $next, $guard = null)
    {
        $rawToken = $request->cookie('token');
        $token = new Token($rawToken);
        $payload = JWTAuth::decode($token);
        Auth::loginUsingId($payload['sub']);

        return $next($request);
    }
}
