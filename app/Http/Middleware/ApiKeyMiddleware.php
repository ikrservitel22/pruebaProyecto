<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiKeyMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        try {
            // 1. Verificar que venga token
            $user = JWTAuth::parseToken()->authenticate();

        } catch (Exception $e) {
            return response()->json([
                'message' => 'Token inválido o no enviado'
            ], 401);
        }

        return $next($request);
    }
}
