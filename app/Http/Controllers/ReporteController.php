<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Apartamentos;
use App\Models\Gasto;
use App\Models\Reporte;
use Carbon\Carbon;


class ReporteController extends Controller
{
    public function apartamentos(Request $request)
    {
        try {
            $apartamentos = Apartamentos::getApartamentos();
            $pdf = Pdf::loadView('apartamentos', compact('apartamentos'));
            //  return $pdf->stream('apartamentos.pdf');
            return $pdf->download('apartamentos.pdf');
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function nominaProveedores(Request $request)
    {
        try {
            $gastos = Gasto::listarGastos();

            $gastosDeNomina = [];
            foreach ($gastos as  $value) {
                if ($value->id_proveedor != null) {
                    $gastosDeNomina[] = $value;
                }
            }

            $pdf = Pdf::loadView('NominaProvedores', compact('gastosDeNomina'));
            //return $pdf->stream('apartamentos.pdf');
            return $pdf->download('nomina_provedores.pdf');
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public  function morosos(Request $request)
    {
        try {
            $morosos_generales =  Reporte::listarMorosos();
            $pdf = Pdf::loadView('morosos', compact('morosos_generales'));
            //  return $pdf->stream('apartamentos.pdf');
            return $pdf->download('morosos.pdf');
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public  function morososPersonal(Request $request)
    {
        try {
            $morosos_generales =  Reporte::listarMorososPersonal();
            $pdf = Pdf::loadView('MorosoPersonal', compact('morosos_generales'));
            //  return $pdf->stream('apartamentos.pdf');
            return $pdf->download('MorosoPersonal.pdf');
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function GastosGenerales(Request $request)
    {
        try {

            $configuration = $request->json()->all();

            // Convertimos ISO 8601 a fechas normalizadas (ej: "2025-06-20")
            $start = Carbon::parse($configuration['date_start'])->startOfDay()->toDateString();
            $end = Carbon::parse($configuration['date_end'])->endOfDay()->toDateString();

            // Obtener gastos como colección
            /** @var \Illuminate\Support\Collection|\stdClass[] */
            $gastos = Gasto::listarGastos();

            $gastosFiltrados = $gastos->filter(function (\stdClass $gasto) use ($start, $end) {
                $fecha = Carbon::parse($gasto->fecha)->toDateString();
                return $fecha >= Carbon::parse($start)->toDateString() &&
                    $fecha <= Carbon::parse($end)->toDateString();
            });

            $pdf = Pdf::loadView('gastos', compact('gastosFiltrados'));
            // $pdf->stream('apartamentos.pdf');
            return $pdf->download('gastos.pdf');
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public function constanciaSolvencia(Request $request)
    {
        try {

            $pdf = Pdf::loadView('ConstanciaSolvencia');
            //return $pdf->stream('constancia_solvencia.pdf');
            return $pdf->download('constancia_solvencia.pdf');
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public function constanciaResidencia(Request $request)
    {
        try {

            $pdf = Pdf::loadView('ConstanciaRecidencia');
            //return $pdf->stream('constancia_residencia.pdf');
            return $pdf->download('constancia_solvencia.pdf');
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
