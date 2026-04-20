<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Usuarios;
use Illuminate\Support\Facades\DB;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('*', function ($view) {
            $items = [
                ['nombre' => 'Crear Nuevo Usuario', 'url' => '/CreateUP'],
                ['nombre' => 'Lista De Usuarios', 'url' => '/lista'],
            ];
    /*        if (session()->has('id')) {
                $usuario = \App\Models\Usuarios::find(session('id'));

                if ($usuario && $usuario->permisos->contains('permiso_id', 1)) {
                    $items[] = ['nombre' => 'Lista', 'url' => '/Usuarios'];
                }
            }*/
            $menu = [
                [
                    'titulo' => 'Usuarios',
                    'items' => $items
                ],
                // [
                //     'titulo' => 'Otros', // ejemplo de otra sección
                //     'items' => [  // ejemplo de otros items
                //         ['nombre' => 'Home', 'url' => '/home'], // ejemplo de item
                //         ['nombre' => 'Profile', 'url' => '/profile'],
                //     ]
                // ]
            ];
            $listas = [
                ['nombre' => '#'],
                ['nombre' => 'Name'],
                ['nombre' => 'Username'],
                ['nombre' => 'Password'],
                ['nombre' => 'Rol'],
                ['nombre' => 'Options'],
            ];
            $Datos = DB::table('registro') 
                ->join('per_usu', 'registro.usuario_id', '=', 'per_usu.usuario_id')
                ->join('permisos', 'per_usu.permiso_id', '=', 'permisos.permiso_id')
                ->select(
                    'registro.usuario_id',
                    'registro.usuario',
                    'registro.nombre',
                    'registro.clave',
                    'permisos.permisos as permiso_nombre' 
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
