<?php

use App\Http\Controllers\TareaController;

Route::get('/', [TareaController::class, 'index']);

Route::post('/tareas', [TareaController::class, 'store']);