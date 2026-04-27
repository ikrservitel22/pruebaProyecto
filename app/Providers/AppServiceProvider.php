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
            $items = [
                ['nombre' => 'Inicio', 'url' => '/'],
            ];
            if (session('permiso_id') == 1) { // si el permiso es admin
                    $items[] = ['nombre' => 'Input List', 'url' => '/inputtt'];
                    $items[] = ['nombre' => 'youtube', 'url' => 'https://www.youtube.com/watch?v=LbwZCALNfb8&list=RDLbwZCALNfb8&start_radio=1'];
                    $items[] = ['nombre' => 'Crear Nuevo Usuario', 'url' => '/CreateUP'];
            }
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
            ];
            if (session('permiso_id') == 1 || session('permiso_id') == 4 || session('permiso_id') == 2 || session('permiso_id') == 3) {
                $menu[] = [
                    'titulo' => 'Utilidades',
                    'items' => [
                        ['nombre' => 'Horario', 'url' => '/Horario'],
                        ['nombre' => 'Lista De Usuarios', 'url' => '/lista'],
                        ['nombre' => 'Lista De Festivos/Eventos', 'url' => '/Festivos'],
                    ]
                ];

            }
            $listas = [
                ['nombre' => '#'],
                ['nombre' => 'Name'],
                ['nombre' => 'Username'],
            ];

            if (session('permiso_id') == 1 || session('permiso_id') == 4){
                $listas[] = ['nombre' => 'Password'];
                $listas[] = ['nombre' => 'Cedula'];
            }

            $listas[] = ['nombre' => 'Rol'];
            
            if (session('permiso_id') == 1 || session('permiso_id') == 4 || session('permiso_id') == 3){
                $listas[] = ['nombre' => 'Options'];
            }


            $Datos = DB::table('registro') 
                ->join('per_usu', 'registro.usuario_id', '=', 'per_usu.usuario_id')
                ->join('permisos', 'per_usu.permiso_id', '=', 'permisos.permiso_id')
                ->select(
                    'registro.usuario_id',
                    'registro.usuario',
                    'registro.nombre',
                    'registro.clave',
                    'registro.cedula',
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
