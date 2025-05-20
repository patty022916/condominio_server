<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gasto extends Model
{
    protected $table = 'gastos';

    protected $fillable = [
        'descripcion',
        'monto',
        'tipo_gasto',
        'fecha',
        'id_proveedor',
        'recurrente'
       
    ];

    // Relacion
    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class, 'id_proveedor');
    }

   
}