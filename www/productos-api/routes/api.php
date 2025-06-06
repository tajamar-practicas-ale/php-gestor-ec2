<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\AuthController;

// Rutas públicas para login
Route::post('/login', [AuthController::class, 'login']);

// Rutas protegidas por JWT
Route::middleware('jwt.auth')->group(function () {
    // apiResource crea index, store, show, update, destroy
    Route::apiResource('productos', ProductoController::class);
    // Para PATCH, Laravel mapea update si recibe PATCH. 
    // Si quisieras un método separado 'patch', puedes:
    // Route::patch('productos/{producto}', [ProductoController::class, 'patch']);
});

Route::get('/test', function() {
    return response()->json(['message' => 'Test OK']);
});
