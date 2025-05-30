<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cuota;
use App\Models\Gasto;
use App\Models\Apartamentos;
use App\Models\DeudaApartamento;
use Illuminate\Support\Facades\DB;

class CuotaController extends Controller
{
    /**
     * Calcula la cuota por apartamento sin guardar aún
     */
    public function generarCuota(Request $request)
    {
        try {
            $mes = $request->input('mes');
            $anio = $request->input('anio');

            // 1. Total de gastos del mes/año
            $total_gastos = Gasto::whereMonth('fecha', $mes)
                                 ->whereYear('fecha', $anio)
                                 ->sum('monto');

            if ($total_gastos == 0) {
                return response()->json(['error' => 'No hay gastos para el mes y año indicado'], 400);
            }

            // 2. Calculamos las cuotas por apartamento
            $apartamentos = Apartamentos::all();
            $cuotas = [];

            foreach ($apartamentos as $apto) {
                $coef = ($apto->habitaciones == 2) ? 0.40415 : 0.5958;
                $monto = round($total_gastos * $coef, 2);
                $cuotas[] = [
                    'apartamento_id' => $apto->id,
                    'coef_alicuota' => $coef,
                    'monto_calculado' => $monto,
                ];
            }

            return response()->json([
                'mes' => $mes,
                'anio' => $anio,
                'total_gastos' => $total_gastos,
                'cuotas' => $cuotas
            ]);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Guarda la cuota mensual y crea deudas por apartamento
     */
    public function guardarCuota(Request $request)
    {
        DB::beginTransaction();

        try {
            $mes = $request->input('mes');
            $anio = $request->input('anio');

            // Verificamos si ya existe la cuota
            if (Cuota::where('mes', $mes)->where('anio', $anio)->exists()) {
                return response()->json(['error' => 'La cuota ya fue generada para ese mes y año'], 400);
            }

            $total_gastos = Gasto::whereMonth('fecha', $mes)
                                 ->whereYear('fecha', $anio)
                                 ->sum('monto');

            if ($total_gastos == 0) {
                return response()->json(['error' => 'No hay gastos registrados para ese mes/año'], 400);
            }

            // Guardamos cuota general
            $cuota = Cuota::create([
                'mes' => $mes,
                'anio' => $anio,
                'total_gastos' => $total_gastos
            ]);

            // Creamos deudas por apartamento
            $apartamentos = Apartamentos::all();

            foreach ($apartamentos as $apto) {
                $coef = ($apto->habitaciones == 2) ? 0.40415 : 0.5958;
                $monto = round($total_gastos * $coef, 2);

                DeudaApartamento::create([
                    'cuota_id' => $cuota->id,
                    'apartamento_id' => $apto->id,
                    'monto_deuda' => $monto,
                    'monto_pagado' => 0,
                    'estado' => 'pendiente'
                ]);
            }

            DB::commit();
            return response()->json(['message' => 'Cuota y deudas generadas correctamente'], 201);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

//  muestra todas las cuotas registradas

public function listarCuotas()
{
    try {
        $cuotas = Cuota::withCount('deudas')->orderByDesc('anio')->orderByDesc('mes')->get();

        return response()->json($cuotas);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
}
//muestra cuotas asociadas a un apartamento (por su ID)


public function cuotasPorApartamento($id)
{
    try {
        $deudas = DeudaApartamento::with('cuota')
                    ->where('apartamento_id', $id)
                    ->orderByDesc(DB::raw("CONCAT(cuota_id, '', apartamento_id)"))
                    ->get()
                    ->map(function ($deuda) {
                        return [
                            'mes' => $deuda->cuota->mes,
                            'anio' => $deuda->cuota->anio,
                            'monto_total' => $deuda->monto_deuda,
                            'pagado' => $deuda->monto_pagado,
                            'estado' => $deuda->estado,
                        ];
                    });

        return response()->json($deudas);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
}




}
