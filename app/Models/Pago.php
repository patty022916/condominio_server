<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    protected $fillable = [
        'id_apartamento', 'id_usuario', 'monto', 'fecha_pago', 'url', 'estatus', 'forma_pago', 'id_cuota'
    ];

    public function usuario() {
        return $this->belongsTo(Usuario::class, 'id_usuario');
    }

    public function apartamento() {
        return $this->belongsTo(Apartamento::class, 'id_apartamento');
    }

    public function cuota() {
        return $this->belongsTo(Cuota::class, 'id_cuota');
    }
}
