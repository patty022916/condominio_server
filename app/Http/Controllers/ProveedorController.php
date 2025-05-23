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
            return response()->json($proveedores, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Crear un nuevo proveedor.
     */
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'nombre' => 'required|string|max:255',
                'servicio' => 'required|string|max:255',
                'telefono' => 'required|string|max:13|min:11',

            ]);

            $proveedor = Proveedor::crearProveedor($validatedData);

            return response()->json($proveedor, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Actualizar un proveedor existente.
     */
    public function update(Request $request, $id)
    {
        try {
            $validatedData = $request->validate([
                'nombre' => 'required|string|max:255',
                'servicio' => 'required|string|max:255',
                'telefono' => 'required|string|max:13|min:11',
            ]);

            $proveedor = Proveedor::findOrFail($id);
            $proveedor->update($validatedData);

            return response()->json($proveedor, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
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
            return response()->json([], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
