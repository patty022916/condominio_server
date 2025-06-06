<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FondosCondominio extends Model
{
    protected $fillable = [
        'tipo_movimiento', 'monto', 'fondo_activo_bs', 'fondo_pasivo_usd', 'descripcion', 'fecha', 'id_gasto'
    ];
}
