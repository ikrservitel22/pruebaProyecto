<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuariosController;
use App\Http\Controllers\HorarioController;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\IaController;



Route::post('/login', [ApiController::class, 'login']);

Route::get('/test', function () {
    return response()->json([
        'message' => 'API funcionando'
    ]);
});

Route::middleware('Jwt')->group(function () {

});


Route::middleware('Jwt:delete')->group(function () {
    Route::get('/usuarios', [ApiController::class, 'usuariou']); // todos
    Route::get('/usuarios/{id}', [ApiController::class, 'usuarios']); // uno
});

Route::middleware('Jwt:create')->group(function () {
    Route::get('/horarios', [ApiController::class, 'horariou']); // todos
    Route::get('/horarios/{id}', [ApiController::class, 'horarios']); // uno
});



Route::get('/ia', [IaController::class, 'index']);

Route::post('/ia/chat', [IaController::class, 'chat']);

