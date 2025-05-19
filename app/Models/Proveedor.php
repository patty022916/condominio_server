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
        try {
            // Validación manual (campos requeridos y tipos)
            $requiredFields = [
                'nombre' => 'string|max:100',
                'servicio' => 'string|max:100', // Validación para el nuevo campo
                'telefono' => 'string|max:20',
            ];

            foreach ($requiredFields as $field => $rules) {
                if (empty($data[$field])) {
                    throw new Exception("El campo $field es requerido", 400);
                }
            }

            // Insertar en BD
            $proveedorId = DB::table('proveedores')->insertGetId([
                'nombre' => trim($data['nombre']),
                'servicio' => trim($data['servicio']), // Añadido
                'telefono' => trim($data['telefono']),
                'created_at' => now(),
                'updated_at' => now()
            ]);

            return DB::table('proveedores')->where('id', $proveedorId)->first();

        } catch (Exception $e) {
            throw $e; // Re-lanzamos para manejar en el controlador
        }
    }
}