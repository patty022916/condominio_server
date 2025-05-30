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

    // Crear nueva notificación
    public static function crearNotificacion(array $data)
    {
        try {
            $id = DB::table('notificaciones')->insertGetId([
                'titulo' => trim($data['titulo']),
                'mensaje' => $data['mensaje'] ?? null,
                'tipo' => $data['tipo'],
                'id_usuario' => $data['id_usuario'],
                'leida_at' => null,
                'created_at' => now(),
                'updated_at' => now()
            ]);
            return DB::table('notificaciones')->where('id', $id)->first();
        } catch (Exception $e) {
            throw $e;
        }
    }

    // Obtener por usuario
    public static function listarNotificaciones($id_notificacion = null, $id_usuario = null)
    {
        $query = DB::table('notificaciones')
            ->join('usuarios', 'usuarios.id', '=', 'notificaciones.id_usuario')
            ->leftJoin('apartamentos as ap', function ($join) {
                $join->on('ap.propietario_id', '=', 'usuarios.id')
                    ->orOn('ap.inquilino_id', '=', 'usuarios.id');
            })
            ->select(
                'notificaciones.*',
                'usuarios.nombre',
                'ap.piso',
                'ap.letra'
            );

        // Solo aplica un filtro si uno de los dos viene
        if ($id_notificacion) {
            $query->where('notificaciones.id', $id_notificacion);
        } elseif ($id_usuario) {
            $query->where('notificaciones.id_usuario', $id_usuario);
        }

        return $query->orderBy('notificaciones.created_at', 'desc')->get();
    }

    // Actualizar notificación
    public static function actualizarNotificacion($id, array $data)
    {
        DB::table('notificaciones')->where('id', $id)->update([
            'titulo' => $data['titulo'],
            'mensaje' => $data['mensaje'] ?? null,
            'tipo' => $data['tipo'],
            'id_usuario' => $data['id_usuario'],
            'updated_at' => now()
        ]);
        return DB::table('notificaciones')->where('id', $id)->first();
    }

    // Marcar como leída
    public static function marcarComoLeida($id)
    {
        DB::table('notificaciones')->where('id', $id)->update([
            'leida_at' => now(),
            'updated_at' => now()
        ]);
        return DB::table('notificaciones')->where('id', $id)->first();
    }
}
