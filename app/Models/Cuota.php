<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

  
class Cuota extends Model
{
    protected $table = 'cuotas';

    protected $fillable = [
        'descripcion',
        'monto',
        'periodo',
        'fecha',
        'created_at',
        'updated_at'
    ];

    public $timestamps = false;

    public function deudas()
    {
        return $this->hasMany(DeudaApartamento::class);
    }
}


