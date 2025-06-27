<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Pago extends Model
{


    public static function savePaymentUsers($pago_usuario)
    {
        $pago_usuario['created_at'] = now();
        $pago_usuario['updated_at'] = now();
        $pago_usuario['id'] = DB::table('pagos')->insertGetId($pago_usuario);
        return $pago_usuario;
    }

    public static function listarPagosUsuarios($id_usuario = null)
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

        return $query->where('pagos.status', 'pendiente')->orderBy('pagos.created_at', 'desc')->get();
    }
}
