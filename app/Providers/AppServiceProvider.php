<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Usuarios;

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
                ['nombre' => 'Lista De Inputs', 'url' => '/inputtt'],
                ['nombre' => 'Lista', 'url' => '/lista'],
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
                ]
            ];

            $view->with('menu', $menu);
        });
    }
}
