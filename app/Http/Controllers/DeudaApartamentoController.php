<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DeudaApartamento;
use App\Models\Cuota;
use App\Models\Apartamentos;

class DeudaApartamentoController extends Controller
{
    // Listar todas las deudas registradas
    public function index()
    {
        try {
            $deudas = DeudaApartamento::with(['apartamento', 'cuota'])->get();
            return response()->json($deudas);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // Mostrar una deuda específica
    public function show($id)
    {
        try {
            $deuda = DeudaApartamento::with(['apartamento', 'cuota'])->findOrFail($id);
            return response()->json($deuda);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Deuda no encontrada'], 404);
        }
    }

    // Crear una nueva deuda manualmente (opcional)
    public function store(Request $request)
    {
        $request->validate([
            'cuota_id' => 'required|exists:cuotas,id',
            'apartamento_id' => 'required|exists:apartamentos,id',
            'monto_deuda' => 'required|numeric|min:0',
            'monto_pagado' => 'nullable|numeric|min:0',
            'estado' => 'required|in:pendiente,abonado,completo',
        ]);

        try {
            $deuda = DeudaApartamento::create($request->all());
            return response()->json($deuda, 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // Actualizar deuda (ej. registrar abono o cambio de estado)
    public function update(Request $request, $id)
    {
        try {
            $deuda = DeudaApartamento::findOrFail($id);

            $request->validate([
                'monto_pagado' => 'nullable|numeric|min:0',
                'estado' => 'nullable|in:pendiente,abonado,completo',
            ]);

            $deuda->update($request->only('monto_pagado', 'estado'));

            return response()->json($deuda);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // Eliminar una deuda (si aplica)
    public function destroy($id)
    {
        try {
            $deuda = DeudaApartamento::findOrFail($id);
            $deuda->delete();
            return response()->json(['message' => 'Deuda eliminada correctamente']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
