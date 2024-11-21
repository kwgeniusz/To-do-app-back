<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Illuminate\Http\Request;

class JwtMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
        } catch (TokenInvalidException $e) {
            return response()->json(['status' => 'Token is invalid'], 401);
        } catch (TokenExpiredException $e) {
            return response()->json(['status' => 'Token is expired'], 401);
        } catch (Exception $e) {
            return response()->json(['status' => 'Authorization token not found'], 401);
        }

        return $next($request);
    }
}
