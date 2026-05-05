<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use PHPOpenSourceSaver\JWTAuth\Exceptions\TokenExpiredException;
use PHPOpenSourceSaver\JWTAuth\Exceptions\TokenInvalidException;
use PHPOpenSourceSaver\JWTAuth\Exceptions\JWTException;

class JwtMiddleware
{
    public function handle(Request $request, Closure $next, $permission = null)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();

            if (!$user) {
                return response()->json(['error' => 'Usuario no encontrado'], 401);
            }

            // VALIDAR PERMISO 
            if ($permission && !$user->hasPermission($permission)) {
                return response()->json([
                    'error' => 'No tienes este permiso'
                ], 403);
            }

        } catch (TokenExpiredException $e) {
            return response()->json(['error' => 'Token expirado'], 401);

        } catch (TokenInvalidException $e) {
            return response()->json(['error' => 'Token inválido'], 401);

        } catch (JWTException $e) {
            return response()->json(['error' => 'Token ausente'], 401);
        }

        return $next($request);
    }
}