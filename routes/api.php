<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuariosController;
use App\Http\Controllers\HorarioController;


Route::get('/test', function () {
    return response()->json([
        'message' => 'API funcionando'
    ]);
});

Route::post('/login', [UsuariosController::class, 'login']);

Route::middleware('auth:api')->group(function () {
    Route::get('/horarios', [HorarioController::class, 'Horario']);
    Route::post('/horarios', [HorarioController::class, 'store']);
    Route::put('/horarios/{id}', [HorarioController::class, 'update']);
    Route::delete('/horarios/{id}', [HorarioController::class, 'destroy']);
});