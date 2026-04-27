<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Middleware para verificar la sesión del usuario.
 *
 * Verifica si el usuario tiene una sesión activa antes de permitir el acceso a rutas protegidas.
 */
class CheckSession
{
    /**
     * Maneja una solicitud entrante.
     *
     * Verifica si existe la variable de sesión 'usuario'.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!session()->has('usuario')) {
            return redirect('/'); // no logueado
        }

        return $next($request); // deja pasar
    }
}
