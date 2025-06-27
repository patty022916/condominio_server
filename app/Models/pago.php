<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use  App\Models\Notificacion;

class Pago extends Model
{


    public static function savePaymentUsers($pago_usuario)
    {
        $pago_usuario['created_at'] = now();
        $pago_usuario['updated_at'] = now();
        $pago_usuario['id'] = DB::table('pagos')->insertGetId($pago_usuario);
        return $pago_usuario;
    }

    public static function listarPagosUsuarios($id_usuario = null, $id_pago = null)
    {
        $query = DB::table('pagos')
            ->select(
                'pagos.*',
                'usuarios.nombre',
                DB::raw("CONCAT(apt.letra, apt.piso) as apartamento")
            )
            ->join('usuarios', 'usuarios.id', '=', 'pagos.id_usuario')
            ->join('apartamentos as apt', 'apt.id', '=', 'pagos.id_apartamento');


        if ($id_usuario != null) {
            $query->where('pagos.id_usuario', $id_usuario);
        }

        if ($id_pago != null) {
            $query->where('pagos.id', $id_pago);
        }

        return $query->orderByRaw('pagos.status = "pendiente" DESC, pagos.created_at DESC')->get();
    }


    /**
     * Método para validar el pago de los usuarios, 
     * este es un método dinámico el cual setea rechazado o pagado según su status
     * Envía la notificación al usuario que realizo el pago
     *
     * @param mixed $id_pago
     * @param mixed $status
     * 
     * @return Pago
     * 
     */
    public static function validatePaymentProcess($id_pago, $status)
    {
        DB::table('pagos')->where('id', $id_pago)->update(['status' => $status]);
        $pago = Pago::listarPagosUsuarios(null, $id_pago)->first();

        //enviamos notificacion
        Notificacion::crearNotificacion([
            'id_usuario' => $pago->id_usuario,
            'titulo' => 'Pago  ' . $status,
            'mensaje' => 'El pago de  ' . $pago->apartamento . ' por  ' . $pago->monto . '  bs  ha sido ' . $status,
            'tipo' => 'alerta'
        ]);

        return $pago;
    }
}
