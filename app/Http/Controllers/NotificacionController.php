<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notificacion;

class NotificacionController extends Controller
{
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'titulo' => 'required|string|max:255',
                'mensaje' => 'nullable|string',
                'tipo' => 'required|in:cobro,reunion,alerta,general',
                'id_usuario' => 'required|integer|exists:usuarios,id',
            ]);

            $notificacion = Notificacion::crearNotificacion($validatedData);

            return response()->json([
                'id' => $notificacion->id,
                'titulo' => $notificacion->titulo,
                'mensaje' => $notificacion->mensaje,
                'tipo' => $notificacion->tipo,
                'id_usuario' => $notificacion->id_usuario,
                'created_at' => $notificacion->created_at
            ], 201);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}