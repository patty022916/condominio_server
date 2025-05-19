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

            // Actualizar solo campos permitidos
            $data = $request->only(['nombre', 'servicio', 'telefono']);
            DB::table('proveedores')->where('id', $id)->update([
                ...$data,
                'updated_at' => now()
            ]);

            return response()->json([
                'success' => true,
                'data' => DB::table('proveedores')->where('id', $id)->first(),
                'message' => 'Proveedor actualizado'
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], $e->getCode() ?: 500);
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