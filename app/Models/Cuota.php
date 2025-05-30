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
        'fecha'
    ];

    public $timestamps = false;

    public function deudas()
    {
        return $this->hasMany(DeudaApartamento::class);
    }
}


