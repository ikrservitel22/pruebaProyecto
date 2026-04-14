<?php

use App\Http\Controllers\TareaController;


Route::get('/', [TareaController::class, 'index']);

Route::post('/login', [TareaController::class, 'login']);

Route::get('/lista', [TareaController::class, 'lista']);

Route::post('/create', [TareaController::class, 'create']);

Route::get('/inputtt', [TareaController::class, 'inputtt']);

Route::get('/create', function () {
    return view('Usuarios.create');
});