<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\ApartamentosController;
use App\Http\Controllers\GastoController;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\NotificacionController;
use App\Http\Controllers\CuotaController;
use App\Http\Controllers\DeudaApartamentoController;


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
Route::put('/gasto/{id}', [GastoController::class, 'actualizarGasto']);
Route::get('/gasto', [GastoController::class, 'listarGatos']);
Route::delete('gasto/{id}', [GastoController::class, 'eliminarGasto']);


// PROVEEDORES
Route::prefix('proveedores')->group(function () {
    Route::get('/', [ProveedorController::class, 'index']); // GET /api/proveedores
    Route::post('/', [ProveedorController::class, 'store']); // POST /api/proveedores
    Route::put('/{id}', [ProveedorController::class, 'update']); // PUT /api/proveedores/1
    Route::delete('/{id}', [ProveedorController::class, 'destroy']); // DELETE /api/proveedores/1
});


// NOTIFICACIONES
Route::prefix('notificaciones')->group(function () {
    Route::post('/', [NotificacionController::class, 'store']); // Crear
    Route::get('/', [NotificacionController::class, 'listarNotificaciones']);
    Route::get('/user/{id}', [NotificacionController::class, 'listNotificationForUser']);
    Route::put('/{id}', [NotificacionController::class, 'update']); // Actualizar
    Route::post('/marcar-leidas', [NotificacionController::class, 'marcarComoLeida']); // Marcar como leída
    Route::delete('/{id}', [NotificacionController::class, 'destroy']); // Eliminar
});


// Cuotas

Route::post('/cuotas/generar', [CuotaController::class, 'generarCuotaApi']); //Calcula la cuota  
Route::post('/cuotas/guardar', [CuotaController::class, 'guardarCuota']); // Guarda cuota calculada
Route::get('/cuotas', [CuotaController::class, 'listarCuotas']); // Lista todas las cuotas
Route::get('/cuotaS/{id}', [CuotaController::class, 'cuotasPorApartamento']); // Cuotas y deudas por apartamento
 
// Deudas 

Route::apiResource('deudas', DeudaApartamentoController::class);
