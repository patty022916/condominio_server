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

class CuotaController extends Controller
{

    /**
     * api para obtener la tasa del bcv
     *
     * @return [type]
     * 
     */
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
     *  llama al metodo generarCuotaPorApartamento para retornar la cuota en la api
     *
     * @param Request $request
     * 
     * @return array
     * 
     */
    public function generarCuotaApi(Request $request)
    {
        try {

            $fecha = Carbon::parse($request->input('fecha')); // ej: 2025-05-01   
            $response = CuotaController::generarCuotaPorApartamento($fecha);

            if (isset($response['error'])) {
                throw new \Exception($response['error'], 422);
            }


            return response()->json($response, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Se encaraga de generar la cuota por apartamento en base a la fecha dada
     *
     * @param mixed $fecha_gastos
     * 
     * @return [type]
     * 
     */
    public function generarCuotaPorApartamento($fecha_gastos)
    {
        try {
            $id_cuota = null;
            //* Obtenemos tass bcv
            $tasas_bcv = CuotaController::obtenerTasaBcv();

            //* Listado de gastos
            $gastos = Gasto::whereMonth('fecha', $fecha_gastos->month)
                ->whereYear('fecha', $fecha_gastos->year)->get();

            //*Lista de cuotas para obtener el id si existe
            $coutas = Cuota::whereMonth('fecha', $fecha_gastos->month)
                ->whereYear('fecha', $fecha_gastos->year)->get();

            if (count($coutas) != 0) {
                $id_cuota = $coutas->first()->id;
            }

            if (count($gastos) == 0) {
                return ['error' => 'No hay gastos para la fecha indicada'];
            }

            //* Desglose de gastos | asignamos id de la cuota
            $desglose_gastos = new \stdClass();
            $desglose_gastos->id = $id_cuota;
            $tipos = ['gasto_fijo', 'gasto_comun', 'gasto_extraordinario', 'gasto_total'];

            //* Inicializar propiedades en 0
            foreach ($tipos as $tipo) {
                $desglose_gastos->$tipo = 0;
            }

            // Sumar montos según tipo_gasto
            foreach ($gastos as $gasto) {
                $key = 'gasto_' . $gasto->tipo_gasto;

                if (in_array($key, $tipos)) {
                    $desglose_gastos->$key +=   $gasto->monto;
                    $desglose_gastos->gasto_total += $gasto->monto;
                }
            }

            //* Redondear total de gastos
            $desglose_gastos->gasto_total = round($desglose_gastos->gasto_total, 2);


            //* Sacar total de gastos
            $apartamentos = Apartamentos::all();
            $cuotas = [];

            foreach ($apartamentos as $apto) {

                //* Cuota por apartamento segun las habitaciones
                $coef = ($apto->habitaciones == 2) ? 0.40415 : 0.5958;

                $cuota_fija_individual = round((float)$desglose_gastos->gasto_fijo * (float)$coef, 2);
                $cuota_extraordinaria_individual =  round($desglose_gastos->gasto_extraordinario / count($apartamentos), 2);
                $total_bs = ($cuota_fija_individual + $cuota_extraordinaria_individual) * $tasas_bcv['price'];

                $cuotas[] = [
                    'apartamento_id' => $apto->id,
                    'coef_alicuota' => $coef,
                    'cuota_fija_usd' => $cuota_fija_individual,
                    'cuota_extraordinaria_usd' => $cuota_extraordinaria_individual,
                    'total_bs' => round($total_bs, 2)
                ];
            }

            //respuesta
            $response = array_merge(
                ['fecha' => $fecha_gastos->toDateString()],
                get_object_vars($desglose_gastos),
                ['cuotas' => $cuotas]
            );

            return $response;
        } catch (\Exception $e) {
            return $e;
        }
    }


    /**
     *Guarda una cuota en base a una fecha dada
     *
     * @param Request $request
     * 
     * @return [type]
     * 
     */
    public function guardarCuota(Request $request)
    {
        try {
            $fecha = Carbon::parse($request->input('fecha')); // ej: 2025-05-01   
            $cuotas = CuotaController::generarCuotaPorApartamento($fecha);

            $data = [
                'fecha' => $cuotas['fecha'],
                'descripcion' => 'Cuota ' . $cuotas['fecha'],
                'periodo' => 1,
                'monto' => $cuotas['gasto_total'],
                'created_at' => now(),
                'updated_at' => now()
            ];

            $cuota = Cuota::whereMonth('fecha', $fecha->month)
                ->whereYear('fecha', $fecha->year)
                ->first();

            if (count((array) $cuota)  > 0) throw new \Exception('Ya existe una cuota para la fecha indicada');

            $data  = Cuota::create($data);


            return response()->json($data, 200);
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
            $cuotas = Cuota::all();
            return response()->json($cuotas);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


    /**
     * muestra las cuotas por apartamento segun el usuario  
     *
     * @param mixed $id_usuario
     * 
     * @return [type]
     * 
     */
    public function cuotasPorApartamento($id_usuario)
    {
        try {
            $fecha = now();
            $apartamentos_usuario = Apartamentos::getApartmentsForUser($id_usuario);
            $cuotas = CuotaController::generarCuotaPorApartamento($fecha);


            $cuotas_filtradas = [];

            foreach ($apartamentos_usuario as $apartamento) {
                $cuotas_por_apartamento = array_filter($cuotas['cuotas'], function ($cuota) use ($apartamento) {
                    return $cuota['apartamento_id'] === $apartamento['id'];
                });

                $cuotas_filtradas = array_merge($cuotas_filtradas, $cuotas_por_apartamento);
            }

            $cuotas['cuotas'] = $cuotas_filtradas;

            return response()->json($cuotas, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


    /**
     * Elimina una cuota por su id
     *
     * @param mixed $id_cuota
     * 
     * @return [type]
     * 
     */
    public function eliminarCuota($id_cuota)
    {
        try {
            $cuota = Cuota::findOrFail($id_cuota);
            $cuota->delete();

            return response()->json(['mensaje' => 'Cuota eliminada correctamente'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
