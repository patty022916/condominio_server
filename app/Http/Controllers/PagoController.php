<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pago;

class PagoController extends Controller
{
    public function SaleOfUser(Request $request)
    {
        try {

            //formateamos el json
            $pagoUsuario = json_decode($request->input('pago_usuario'), true);
            $request->merge(['pago_usuario' => $pagoUsuario]);

            //validaciones
            $sale_of_user =  $request->validate([
                'image' => 'required|image|mimes:jpeg,png,jpg,jfif|max:2048', // 2MB máx
                //*validaciones para pago
                'pago_usuario.id_apartamento' => 'required|integer|exists:apartamentos,id',
                'pago_usuario.id_cuota' => 'required|integer|exists:cuotas,id',
                'pago_usuario.id_usuario' => 'required|integer|exists:usuarios,id',
                'pago_usuario.monto' => 'required|numeric|min:0.01',
                'pago_usuario.referencia' => 'required',
                'pago_usuario.status' => 'required|in:pendiente,pagado,rechazado',
                'pago_usuario.forma_pago' => 'required|in:completo,parcial',
                'pago_usuario.url' => 'required',
            ]);


            $path = $request->file('image')->store('sale_user', 'public');

            $sale_of_user['pago_usuario']['url'] = $path;
            Pago::savePaymentUsers($sale_of_user['pago_usuario']);


            return response()->json($sale_of_user, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function listarPagosUsuarios($id_usuario = null)
    {
        try {
            $pagos = Pago::listarPagosUsuarios($id_usuario);
            return response()->json($pagos, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Valida el pago dinamicamnente
     *Envía la notificación al usuario que realizo el pago
     * @param Request $request
     * 
     * @return [type]
     * 
     */
    public function validatePaymentProcess(Request $request)
    {
        try {
            $pago = $request->validate([
                'pago_id' => 'required|exists:pagos,id',
                'status' => 'required|in:pendiente,pagado,rechazado',
            ]);

            $pago = Pago::validatePaymentProcess($pago['pago_id'], $pago['status']);

            return response()->json($pago, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
