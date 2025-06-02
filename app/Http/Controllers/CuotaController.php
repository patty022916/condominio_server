<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cuota;
use App\Models\Gasto;
use App\Models\Apartamentos;
use App\Models\DeudaApartamento;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use PHPUnit\Framework\Constraint\Count;

class CuotaController extends Controller
{

    public function obtenerTasaBcv()
    {
        try {
            $response = Http::get('https://pydolarve.org/api/v2/tipo-cambio');

            return $response['monitors']['usd'];
        } catch (\Throwable $e) {
            // Retorna arreglo por defecto
            return [
                "price" => 97.31,
                "title" => "Dólar estadounidense",
            ];
        }
    }


    /**
     * Genera una cuota para todos los apartamentos en base a la fecha enviada
     *
     * @param Request $request
     * 
     * @return array
     * 
     */
    public function generarCuota(Request $request)
    {
        try {

            //* Obtenemos tass bcv
            $tasas_bcv = CuotaController::obtenerTasaBcv();

            $fecha = Carbon::parse($request->input('fecha')); // ej: 2025-05-01   
            $mes = $fecha->month;
            $anio = $fecha->year;

            // *MONTO EN DOLARES
            $total_gastos = Gasto::whereMonth('fecha', $mes)
                ->whereYear('fecha', $anio)
                ->sum('monto');

            if ($total_gastos == 0) {
                return response()->json(['error' => 'No hay gastos para la fecha indicada'], 400);
            }

            $apartamentos = Apartamentos::all();
            $cuotas = [];

            foreach ($apartamentos as $apto) {
                $coef = ($apto->habitaciones == 2) ? 0.40415 : 0.5958;
                $monto = round((float)$total_gastos * (float)$coef, 2);
                $cuotas[] = [
                    'apartamento_id' => $apto->id,
                    'coef_alicuota' => $coef,
                    'monto_bs' => $monto * $tasas_bcv['price'],
                    'monto_usd' => $monto
                ];
            }

            $response = [
                'fecha' => $fecha->toDateString(),
                'total_gastos' => $total_gastos,
                'cuotas' => $cuotas
            ];

            return response()->json($response, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Guarda cuota y crea deudas asociadas por apartamento
     */
    public function guardarCuota(Request $request)
    {
        try {
            $fecha = Carbon::parse($request->input('fecha'));
            $periodo = $request->input('periodo');

            // Verificamos si ya existe una cuota para la misma fecha
            if (Cuota::whereDate('fecha', $fecha)->exists()) {
                return response()->json(['error' => 'Ya existe una cuota para esa fecha'], 400);
            }

            $total_gastos = Gasto::whereMonth('fecha', $fecha->month)
                ->whereYear('fecha', $fecha->year)
                ->sum('monto');

            if ($total_gastos == 0) {
                return response()->json(['error' => 'No hay gastos registrados para esa fecha'], 400);
            }

            $cuota = Cuota::create([
                'descripcion' => $request->input('descripcion') ?? 'Cuota generada automáticamente',
                'monto' => $total_gastos,
                'periodo' => $periodo,
                'fecha' => $fecha->toDateString()
            ]);

            $apartamentos = Apartamentos::all();

            foreach ($apartamentos as $apto) {
                $coef = ($apto->habitaciones == 2) ? 0.40415 : 0.5958;
                $monto = round($total_gastos * $coef, 2);

                DeudaApartamento::create([
                    'cuota_id' => $cuota->id,
                    'apartamento_id' => $apto->id,
                    'monto' => $monto,
                    'monto_pagado' => 0,
                    'estado' => 'pendiente'
                ]);
            }
            return response()->json(['message' => 'Cuota y deudas creadas correctamente'], 201);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Lista todas las cuotas con cantidad de deudas asociadas
     */
    public function listarCuotas()
    {
        try {
            $cuotas = Cuota::withCount('deudas')->orderByDesc('fecha')->get();
            return response()->json($cuotas);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Muestra cuotas (deudas) por apartamento
     */
    public function cuotasPorApartamento($id)
    {
        try {
            $deudas = DeudaApartamento::with('cuota')
                ->where('apartamento_id', $id)
                ->orderByDesc(DB::raw("cuota_id"))
                ->get()
                ->map(function ($deuda) {
                    return [
                        'fecha' => $deuda->cuota->fecha,
                        'descripcion' => $deuda->cuota->descripcion,
                        'monto_total' => $deuda->monto,
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
