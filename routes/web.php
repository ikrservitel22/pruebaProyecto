<?php

use App\Http\Controllers\UsuariosController;
use Illuminate\Http\Request;
use App\Models\Usuarios;
use App\Http\Middleware\CheckSession;
use App\Http\Controllers\CreateUPController;
use App\Http\Controllers\DeleteController;
use App\Http\Controllers\UpdateController;
use App\Http\Controllers\PermisosController;
use App\Http\Controllers\PerusuController;
use App\Http\Controllers\InactivateController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HorarioController;

Route::view('/test', 'Usuarios.dashboard');

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

Route::get('/lista', [UsuariosController::class, 'lista'])->name('Usuarios.lista');

Route::post('/create', [UsuariosController::class, 'create']);

Route::get('/inputtt', [UsuariosController::class, 'inputtt']);

Route::get('/create', function () {
    return view('Usuarios.create');
});

Route::get('/buscar', function () {
    $busqueda = request('q'); // obtiene el valor del parámetro de búsqueda "q" de la URL
    $Usuarios = Usuarios::where('usuario', 'LIKE', "%$busqueda%")->get(); // busca en la tabla "registro" los registros donde el campo "usuario" contenga el valor de búsqueda
    return view('Usuarios.lista', compact('Usuarios')); // devuelve la vista "lista" con los resultados de la búsqueda
});

Route::middleware(['check.session'])->group(function () {
    Route::get('/lista', [UsuariosController::class, 'lista']);
    Route::get('/inputtt', [UsuariosController::class, 'inputtt']);
    Route::get('/CreateUP', [UsuariosController::class, 'CreateUP']);
    Route::get('/Horario', [HorarioController::class, 'Horario']);
    Route::post('/Horario', [HorarioController::class, 'Horario']);
    Route::post('/Evento', [HorarioController::class, 'store'])->name('Usuarios.eventoN');
    Route::get('/Evento', [HorarioController::class, 'create']);
    Route::put('/Evento /{id}', [HorarioController::class, 'update'])->name('evento.update');
    Route::get('/Evento/{id}/Edit', [HorarioController::class, 'edit'])->name('Usuarios.editE');
});

Route::get('/CreateUP', function () {
    return view('CRUD.CreateUP');
});

Route::post('/CreateUP', [CreateUPController::class, 'CreateUP']);

Route::delete('/usuarios/{id}', [DeleteController::class, 'destroy'])
    ->name('Usuarios.destroy');

Route::get('/Edit/{id}', [UpdateController::class, 'Edit'])->name('Usuarios.Edit');

Route::put('/Update/{id}', [UpdateController::class, 'update'])->name('Usuarios.Update');

Route::delete('/usuarios/{id}', [InactivateController::class, 'Softdelete'])
    ->name('Usuarios.Softdelete');

Route::get('/Horario', [HorarioController::class, 'Horario'])->name('Usuarios.horario');

Route::post('/Horario', [HorarioController::class, 'Horario']);

Route::post('/Evento', [HorarioController::class, 'store'])->name('Usuarios.eventoN');

Route::get('/Evento', [HorarioController::class, 'create']);

Route::put('/Evento /{id}', [HorarioController::class, 'update'])->name('evento.update');

Route::get('/Evento/{id}/Edit', [HorarioController::class, 'edit'])
    ->name('Usuarios.editE');
