<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\ApartamentosController;
use App\Http\Controllers\GastoController;
use App\Http\Controllers\ProveedorController;

//USUARIOS
Route::get('/users', [UsuarioController::class, 'getUsers']);
Route::post('/users', [UsuarioController::class, 'createUser']);
Route::post('/users/auth', [UsuarioController::class, 'authenticationUser']);
Route::delete('/users/{id}', [UsuarioController::class, 'deleteUser']);

//ROLES
Route::get('/roles', [RolesController::class, 'getRoles']);


//APARTAMENTOS
Route::get('/apartamentos', [ApartamentosController::class, 'listarApartamentos']);
Route::post('/apartamentos/asignar-inquilino', [ApartamentosController::class, 'asignarInquilino']);

//GASTOS
Route::post('/gasto', [GastoController::class, 'createGastos']);

// PROVEEDORES
Route::prefix('proveedores')->group(function () {
    Route::get('/', [ProveedorController::class, 'index']); // GET /api/proveedores
    Route::post('/', [ProveedorController::class, 'store']); // POST /api/proveedores
    Route::put('/{id}', [ProveedorController::class, 'update']); // PUT /api/proveedores/1
    Route::delete('/{id}', [ProveedorController::class, 'destroy']); // DELETE /api/proveedores/1
});