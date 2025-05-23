<?php

namespace App\Http\Controllers;

use App\Models\Gasto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GastoController extends Controller
{
    public function createGastos(Request $request)
    {
        try {
            $dataGasto = $request->validate([
                'descripcion' => 'required|string|max:255',
                'monto' => 'required|numeric',
                'tipo_gasto' => 'required|in:fijo,comun,extraordinario',
                'id_proveedor' => 'nullable|exists:proveedores,id',
                'recurrente' => 'sometimes|boolean',
                'fecha' => 'sometimes|date'
            ]);

            $gasto = Gasto::create($dataGasto);
            return response()->json($gasto, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function actualizarGasto(Request $request, $id)
    {
        try {
            $gasto = Gasto::findOrFail($id);
            $dataGasto = $request->validate([
                'descripcion' => 'required|string|max:255',
                'monto' => 'required|numeric',
                'tipo_gasto' => 'required|in:fijo,comun,extraordinario',
                'id_proveedor' => 'nullable|exists:proveedores,id',
                'recurrente' => 'sometimes|boolean',
                'fecha' => 'sometimes|date'
            ]);

            $gasto->update($dataGasto);
            return response()->json($gasto, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    /**
     * Lista los gastos 
     *
     * @param Request $request
     * 
     * @return array
     * 
     */
    public function listarGatos(Request $request)
    {
        try {

            $gastos  = Gasto::listarGastos();
            return response()->json($gastos, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public function eliminarGasto($id)
    {
        try {
            $gasto = Gasto::findOrFail($id);
            $gasto->delete();
            return response()->json(['message' => 'Gasto eliminado con éxito'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
