<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Proveedor;
use Illuminate\Support\Facades\DB;

class ProveedorController extends Controller
{
    /**
     * Obtener todos los proveedores.
     */
    public function index()
    {
        try {
            $proveedores = DB::table('proveedores')->get();
            return response()->json([
                'success' => true,
                'data' => $proveedores
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Crear un nuevo proveedor.
     */
    public function store(Request $request)
    {
        try {
            $proveedor = Proveedor::crearProveedor($request->only(['nombre', 'servicio', 'telefono']));
            return response()->json([
                'success' => true,
                'data' => $proveedor,
                'message' => 'Proveedor creado correctamente'
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
                'code' => $e->getCode() ?: 500
            ], $e->getCode() ?: 500);
        }
    }

    /**
     * Actualizar un proveedor existente.
     */
    public function update(Request $request, $id)
    {
        try {
            // Validar existencia
            $proveedor = DB::table('proveedores')->where('id', $id)->first();
            if (!$proveedor) {
                throw new \Exception("Proveedor no encontrado", 404);
            }
    
            // Validar datos de entrada
            $request->validate([
                'nombre' => 'sometimes|string|max:255',
                'servicio' => 'sometimes|string|max:255',
                'telefono' => 'sometimes|string|max:20'
            ]);
    
            // Preparar datos para actualizar
            $updateData = [];
            if ($request->has('nombre')) $updateData['nombre'] = $request->nombre;
            if ($request->has('servicio')) $updateData['servicio'] = $request->servicio;
            if ($request->has('telefono')) $updateData['telefono'] = $request->telefono;
            
            // Verificar si hay datos para actualizar
            if (empty($updateData)) {
                throw new \Exception("No se proporcionaron datos para actualizar", 400);
            }
    
            // Agregar fecha de actualización
            $updateData['updated_at'] = now();
    
            // Ejecutar actualización
            $affected = DB::table('proveedores')
                ->where('id', $id)
                ->update($updateData);
    
            if ($affected === 0) {
                throw new \Exception("No se realizaron cambios", 200);
            }
    
            return response()->json([
                'success' => true,
                'data' => DB::table('proveedores')->where('id', $id)->first(),
                'message' => 'Proveedor actualizado correctamente'
            ], 200);
    
        } catch (\Exception $e) {
            $statusCode = $e->getCode() ?: 500;
            if ($statusCode < 100 || $statusCode > 599) {
                $statusCode = 500;
            }
            
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], $statusCode);
        }
    }
    /**
     * Eliminar un proveedor.
     */
    public function destroy($id)
    {
        try {
            $deleted = DB::table('proveedores')->where('id', $id)->delete();
            if (!$deleted) {
                throw new \Exception("Proveedor no encontrado", 404);
            }

            return response()->json([
                'success' => true,
                'message' => 'Proveedor eliminado'
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], $e->getCode() ?: 500);
        }
    }
}
