<?php

use App\Http\Controllers\TareaController;
use Illuminate\Http\Request;
use App\Models\Tarea;
use App\Http\Middleware\CheckSession;


Route::get('/', [TareaController::class, 'index']);

Route::post('/login', [TareaController::class, 'login']);

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

Route::get('/lista', [TareaController::class, 'lista']);

Route::post('/create', [TareaController::class, 'create']);

Route::get('/inputtt', [TareaController::class, 'inputtt']);

Route::get('/create', function () {
    return view('Usuarios.create');
});

Route::get('/buscar', function () {
    $busqueda = request('q'); // obtiene el valor del parámetro de búsqueda "q" de la URL
    $tareas = Tarea::where('usuario', 'LIKE', "%$busqueda%")->get(); // busca en la tabla "registro" los registros donde el campo "usuario" contenga el valor de búsqueda
    return view('Usuarios.lista', compact('tareas')); // devuelve la vista "lista" con los resultados de la búsqueda
});

Route::middleware(['check.session'])->group(function () {
    Route::get('/lista', [TareaController::class, 'lista']);
    Route::get('/inputtt', [TareaController::class, 'inputtt']);
});