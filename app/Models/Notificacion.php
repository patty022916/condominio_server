<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Exception;

class Notificacion extends Model
{
    protected $fillable = [
        'titulo',
        'mensaje',
        'tipo',
        'id_usuario',
        'leida_at'
    ];

    /**
     * Crea una nueva notificación
     */
    public static function crearNotificacion(array $data)
    {
        try {
             
            // Insertar en BD
            $notificacionId = DB::table('notificaciones')->insertGetId([
                'titulo' => trim($data['titulo']),
                'mensaje' => $data['mensaje'] ?? null,
                'tipo' => $data['tipo'],
                'id_usuario' => $data['id_usuario'],
                'leida_at' => null,
                'created_at' => now(),
                'updated_at' => now()
            ]);

            return DB::table('notificaciones')->where('id', $notificacionId)->first();

        } catch (Exception $e) {
            throw $e;
        }
    }
}