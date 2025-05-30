<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cuota extends Model
{
    protected $fillable = ['mes', 'anio', 'total_gastos'];

    public $timestamps = false;

    public function deudas()
    {
        return $this->hasMany(DeudaApartamento::class);
    }
}
