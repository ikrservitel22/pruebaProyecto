<?php

use App\Http\Controllers\UsuariosController;
use Illuminate\Http\Request;
use App\Models\Usuarios;
use App\Http\Middleware\CheckSession;
use App\Http\Controllers\CreateUPController;
use App\Http\Controllers\DeleteController;
use App\Http\Controllers\UpdateController;
use App\Http\Controllers\PermisosController;
use App\Http\Controllers\InactivateController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HorarioController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FestivosController;
use App\Http\Controllers\RolesController;


/*
|--------------------------------------------------------------------------
| Rutas Web
|--------------------------------------------------------------------------
|
| Aquí se definen todas las rutas web de la aplicación Laravel.
| Incluye rutas públicas y protegidas por middleware de sesión.
|
*/

// Ruta de prueba para festivos
Route::get('/test', [FestivosController::class, 'festivo']);

// Rutas públicas - no requieren autenticación
Route::get('/', [UsuariosController::class, 'index']);

Route::post('/login', [UsuariosController::class, 'login']);

Route::get('/login', function () {
    return view('Usuarios.login');
});

Route::get('/actList', function () {
    session(['List' => true]);
    return redirect('/');
});

Route::get('/desList', function () {
    session(['List' => false]);
    return redirect('/');
});

Route::get('/logout', function () {
    session()->flush(); //  borra todo
    return view('Usuarios.principal');
});

Route::post('/create', [UsuariosController::class, 'create']);

Route::get('/create', function () {
    return view('Usuarios.create');
});

Route::get('/buscar', function () {
    $busqueda = request('q'); // obtiene el valor del parámetro de búsqueda "q" de la URL
    if (empty($busqueda)) {
        return redirect('/lista'); // si no hay búsqueda, redirige a la lista completa
    }
    $usuarios = Usuarios::with('roles')
                        ->where('usuario', 'LIKE', "%$busqueda%")
                        ->orWhere('nombre', 'LIKE', "%$busqueda%")
                        ->orWhere('cedula', 'LIKE', "%$busqueda%")
                        ->paginate(5)
                        ->appends(request()->except('page'))
                        ->through(function($usuario) {
                            $usuario->rol_nombre = $usuario->roles->first()->rol ?? 'Sin rol';
                            return $usuario;
                        }); // busca en múltiples campos y pagina
    return view('Usuarios.lista', compact('usuarios')); // devuelve la vista "lista" con los resultados de la búsqueda
})->middleware(['check.session']); // protege la ruta con middleware de sesión

// Rutas protegidas - requieren sesión activa
Route::middleware(['check.session'])->group(function () {
    Route::get('/lista', [UsuariosController::class, 'lista'])->middleware('check.permission:read,create,delete');
    Route::get('/inputtt', [UsuariosController::class, 'inputtt'])->middleware('check.permission:create');
    
    // Rutas para gestión de horarios
    Route::get('/Horario', [HorarioController::class, 'Horario'])->name('Usuarios.horario')->middleware('check.permission:read,create,delete,write');
    Route::post('/Horario', [HorarioController::class, 'Horario'])->middleware('check.permission:create');
    
    // Rutas para gestión de eventos (horarios)
    Route::post('/Evento', [HorarioController::class, 'store'])->name('Usuarios.eventoN');
    Route::get('/Evento', [HorarioController::class, 'create']);
    Route::put('/Evento/{id}', [HorarioController::class, 'update'])->name('evento.update');
    Route::delete('/Evento/{id}', [HorarioController::class, 'destroy'])->name('evento.destroy');
    Route::get('/Evento/{id}/Edit', [HorarioController::class, 'edit'])->name('Usuarios.editE');
});

Route::get('/CreateUP', function () {
    return view('CRUD.CreateUP');
})->middleware(['check.session', 'check.permission:create']);

Route::post('/CreateUP', [CreateUPController::class, 'CreateUP'])->middleware(['check.session', 'check.permission:create']);

Route::delete('/usuarios/{id}', [DeleteController::class, 'destroy'])
    ->name('Usuarios.destroy');

Route::get('/Edit/{id}', [UpdateController::class, 'Edit'])->name('Usuarios.Edit');

Route::put('/Update/{id}', [UpdateController::class, 'update'])->name('Usuarios.Update');

Route::delete('/usuarios/{id}', [InactivateController::class, 'Softdelete'])
    ->name('Usuarios.Softdelete');

Route::post('/Festivos/update', [FestivosController::class, 'update']);

Route::get('/Festivos', [FestivosController::class, 'festivo'])->middleware(['check.session', 'check.permission:read']);

Route::get('/exportar-horarios', [HorarioController::class, 'exportarCSV']);

Route::post('/importar-horarios', [HorarioController::class, 'importarCSV'])->name('horarios.importar');

Route::post('/Festivos/store', [FestivosController::class, 'store']);

Route::get('/Festivos/delete/{id}', [FestivosController::class, 'delete']);

Route::get('/roles', [RolesController::class, 'index'])->name('roles.index');

Route::post('/crear-rol', [RolesController::class, 'createRol'])->name('roles.store');

Route::put('/editar-rol/{id}', [RolesController::class, 'update'])->name('roles.update');