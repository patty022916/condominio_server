<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Exception;

class Proveedor extends Model
{
    protected $table = 'proveedores';
    protected $fillable = [
        'nombre',
        'servicio',
        'telefono'
    ];

    /**
     * Crea un nuevo proveedor con validación.
     */
    public static function crearProveedor(array $data)
    {

        // Insertar en BD
        $proveedorId = DB::table('proveedores')->insertGetId([
            'nombre' => trim($data['nombre']),
            'servicio' => trim($data['servicio']), // Añadido
            'telefono' => trim($data['telefono']),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return DB::table('proveedores')->where('id', $proveedorId)->first();
    }
}
