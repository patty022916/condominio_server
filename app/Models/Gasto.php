<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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

    /**
     *Listado de gastos con el nombre del proveedor 
     *
     * @return array
     * 
     */
    public static function listarGastos()
    {
        return DB::table('gastos')
            ->leftJoin('proveedores', 'proveedores.id', '=', 'gastos.id_proveedor')
            ->select('gastos.*', 'proveedores.nombre as  proveedor')
            ->orderBy('gastos.id', 'asc')
            ->get();
    }
}
