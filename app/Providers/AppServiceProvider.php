<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

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
        View::share('menu', [
            [
                'titulo' => 'Usuarios',
                'items' => [
                    ['nombre' => 'Lista', 'url' => '/lista'],
                    ['nombre' => 'Crear', 'url' => '/create'],
                ]
            ]
        ]);
    }
}
