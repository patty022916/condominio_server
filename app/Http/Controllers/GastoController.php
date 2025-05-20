<?php

namespace App\Http\Controllers;

use App\Models\Gasto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GastoController extends Controller
{
    public function createGastos(Request $request)
    {
        DB::beginTransaction();
        try {
            $validated = $request->validate([
                'descripcion' => 'required|string|max:255',
                'monto' => 'required|numeric|min:0.01',
                'tipo_gasto' => 'required|in:fijo,comun,extraordinario',
                'id_proveedor' => 'nullable|exists:proveedores,id',
                'recurrente' => 'sometimes|boolean',
                'fecha' => 'sometimes|date|date_format:Y-m-d'
            ]);
    
            $gasto = Gasto::create([
                'descripcion' => $validated['descripcion'],
                'monto' => $validated['monto'],
                'tipo_gasto' => $validated['tipo_gasto'],
                'fecha' => $validated['fecha'] ?? now()->format('Y-m-d'),
                'id_proveedor' => $validated['id_proveedor'] ?? null,
                'recurrente' => $validated['recurrente'] ?? false,
                
            ]);
    
            DB::commit();
    
            return response()->json([
                'success' => true,
                'data' => $gasto,
                'message' => 'Gasto creado exitosamente'
            ], 201);
    
        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'errors' => $e->errors(),
                'code' => 422
            ], 422);
            
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'error' => 'Error interno del servidor',
                'details' => env('APP_DEBUG') ? $e->getMessage() : null,
                'code' => 500
            ], 500);
        }
    }
    }