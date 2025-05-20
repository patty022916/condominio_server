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
        'recurrente',
        'user_id'
    ];

    // Relaciones (opcional pero recomendado)
    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class, 'id_proveedor');
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'user_id');
    }
}