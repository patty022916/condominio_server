<?php

use App\Http\Controllers\Api\UsuarioController;
use App\Http\Controllers\Api\ApartamentoController;
use App\Http\Controllers\Api\RolController;

Route::prefix('v1')->group(function () {
    // CRUD Usuarios
    Route::get('/usuarios', [UsuarioController::class, 'index']);
    Route::post('/usuarios', [UsuarioController::class, 'store']);
    Route::get('/usuarios/{id}', [UsuarioController::class, 'show']);
    Route::put('/usuarios/{id}', [UsuarioController::class, 'update']);
    Route::delete('/usuarios/{id}', [UsuarioController::class, 'destroy']);

    // Listar apartamentos
    Route::get('/apartamentos', [ApartamentoController::class, 'index']);


//CRUD de Rol

        Route::get('/roles', [RolController::class, 'index']);
        Route::post('/roles', [RolController::class, 'store']);
        Route::get('/roles/{id}', [RolController::class, 'show']);
        Route::put('/roles/{id}', [RolController::class, 'update']);
        Route::delete('/roles/{id}', [RolController::class, 'destroy']);

});