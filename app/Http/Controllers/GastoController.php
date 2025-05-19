<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class GastoController extends Controller
{
   
     // Registra un nuevo gasto con validación completa
    
     public function createGastos(Request $request)
     {
         $result = Gasto::registrarGasto($request);
         
         // Retorna respuesta JSON
         return response()->json($result, $result['success'] ? 201 : ($result['code'] ?? 500));
     }
 }