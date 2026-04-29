<?php

namespace App\Http\Middleware;

use App\Models\Usuarios;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Middleware para validar permisos por nombre.
 */
class CheckPermission
{
    /**
     * Maneja una solicitud entrante.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  $permission
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next, string $permission = null, string ...$permissions): Response
    {
        if (!session()->has('id')) {
            return redirect('/login');
        }

        $usuario = Usuarios::with('roles.permisos')->find(session('id'));

        if (! $usuario) {
            return redirect('/login');
        }

        $requestedPermissions = array_filter(array_merge([$permission], $permissions));
        $requestedPermissions = collect($requestedPermissions)
            ->flatMap(function ($item) {
                return array_map('trim', explode(',', $item));
            })
            ->filter()
            ->map(function ($item) {
                return strtolower($item);
            })
            ->unique()
            ->values()
            ->all();

        if ($usuario->hasRole('admin')) {
            return $next($request);
        }

        foreach ($requestedPermissions as $requestedPermission) {
            if ($usuario->hasPermission($requestedPermission)) {
                return $next($request);
            }
        }

        abort(403, 'No autorizado');
    }
}
