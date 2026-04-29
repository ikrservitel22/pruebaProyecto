<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Usuarios;
use Illuminate\Support\Facades\DB;

/**
 * Proveedor de servicios de la aplicación.
 *
 * Registra servicios y configura el composer de vistas para el menú dinámico.
 */
class AppServiceProvider extends ServiceProvider
{
    /**
     * Registra cualquier servicio de la aplicación.
     *
     * @return void
     */
    public function register(): void
    {
        //
    }

    /**
     * Inicializa cualquier servicio de la aplicación.
     *
     * Configura el composer de vistas para compartir datos del menú y listas con todas las vistas.
     *
     * @return void
     */
    public function boot(): void
    {
        View::composer('*', function ($view) {
            $currentUser = session()->has('id') ? Usuarios::with('roles.permisos')->find(session('id')) : null;
            $roleName = null;

            if ($currentUser) {
                $roleName = strtolower(trim($currentUser->roles->first()->rol ?? ''));
                session(['rol_nombre' => $roleName]);
            }

            $items = [
                ['nombre' => 'Inicio', 'url' => '/'],
            ];

            $utilities = [];

            if ($currentUser && $currentUser->canAccess('read', 'create', 'delete', 'write')) {
                $items[] = ['nombre' => 'Input List', 'url' => '/inputtt'];
                $items[] = ['nombre' => 'youtube', 'url' => 'https://www.youtube.com/watch?v=LbwZCALNfb8&list=RDLbwZCALNfb8&start_radio=1'];
                $items[] = ['nombre' => 'Crear Nuevo Usuario', 'url' => '/CreateUP'];
            }

            if ($currentUser && $currentUser->canAccess('read', 'create', 'delete', 'write')) {
                $utilities[] = ['nombre' => 'Horario', 'url' => '/Horario'];
                $utilities[] = ['nombre' => 'Lista De Usuarios', 'url' => '/lista'];
                $utilities[] = ['nombre' => 'Lista De Festivos/Eventos', 'url' => '/Festivos'];
            }
            if ($currentUser && $currentUser->canAccess('create')) {
                $utilities[] = ['nombre' => 'Lista De Roles', 'url' => '/roles'];
            }

            $menu = [
                [
                    'titulo' => 'Usuarios',
                    'items' => $items
                ],
            ];

            if (!empty($utilities)) {
                $menu[] = [
                    'titulo' => 'Utilidades',
                    'items' => $utilities,
                ];
            }
            $listas = [
                ['nombre' => '#'],
                ['nombre' => 'Name'],
                ['nombre' => 'Username'],
            ];

            if (in_array($roleName, ['admin'], true)){
                $listas[] = ['nombre' => 'Password'];
            }

            if (in_array($roleName, ['admin', 'supervizor'], true)){
                $listas[] = ['nombre' => 'Cedula'];
            }

            $listas[] = ['nombre' => 'Rol'];
            
            if (in_array($roleName, ['admin', 'supervizor', 'administrativo'], true)){
                $listas[] = ['nombre' => 'Options'];
            }


            $Datos = DB::table('registro') 
                ->join('rol_usu', 'registro.usuario_id', '=', 'rol_usu.usuario_id')
                ->join('roles', 'rol_usu.rol_id', '=', 'roles.rol_id')
                ->select(
                    'registro.usuario_id',
                    'registro.usuario',
                    'registro.nombre',
                    'registro.clave',
                    'registro.cedula',
                    'roles.rol as rol_nombre'
                )
                ->where('registro.state', 1) // SOLO ACTIVOS
                ->orderBy('registro.usuario_id', 'asc')  //ordenar por id
                ->get();

            $view->with('menu', $menu);
            $view->with('listas', $listas);
            $view->with('Datos', $Datos);  
        });
    }
}
