<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    use HasFactory;

    protected $fillable = [
        'apartamento_id',
        'monto_bs',
        'estado',
        'descripcion',
    ];

    public function apartamento()
    {
        return $this->belongsTo(Apartamento::class);
    }
}
