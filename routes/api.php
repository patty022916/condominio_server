<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\ApartamentosController;

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
