<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class JwtMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        try{
            $user = JWTAuth::parseToken()->autenticate();
        }catch(Exception $e){
            if($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException){
                return response()->json(['msg'=>'Invalid Token']);
            }
            if($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException){
                return response()->json(['msg'=>'Token is expired']);
            }
            return response()->json(['msg'=>'Token not found']);
        }
        return $next($request);
    }
}
