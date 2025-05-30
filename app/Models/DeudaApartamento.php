<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeudaApartamento extends Model
{
    protected $table = 'deudas_apartamentos';

    protected $fillable = [
        'cuota_id',
        'apartamento_id',
        'monto_deuda',
        'monto_pagado',
        'estado'
    ];

    public $timestamps = false;

public function apartamento()
{
    return $this->belongsTo(Apartamentos::class, 'apartamento_id');
}

public function cuota()
{
    return $this->belongsTo(Cuota::class, 'cuota_id');
}


}
