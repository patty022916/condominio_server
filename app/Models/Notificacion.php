<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notificacion extends Model
{
    protected $fillable = ['titulo', 'mensaje', 'tipo', 'id_usuario'];

    //Crear una nueva notificación
   
    public static function crearNotificacion(array $datos)
    {
        return self::create([
            'titulo' => $datos['titulo'],
            'mensaje' => $datos['mensaje'] ?? null,
            'tipo' => $datos['tipo'],
            'id_usuario' => $datos['id_usuario']
        ]);
    }
}