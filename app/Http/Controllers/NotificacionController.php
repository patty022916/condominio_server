<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notificacion;

class NotificacionController extends Controller
{
    /**
     * Crear una nueva notificación
     */
    public function store(Request $request)
    {
        try {
            // Validación de campos
            $request->validate([
                'titulo' => 'required|string|max:255',
                'mensaje' => 'nullable|string',
                'tipo' => 'required|in:cobro,reunion,alerta,general',
                'id_usuario' => 'required|exists:usuarios,id',
                'leida_at' => 'nullable|date'
            ]);

            $notificacion = Notificacion::crearNotificacion($request->all());
            
            return response()->json([
                'success' => true,
                'data' => $notificacion,
                'message' => 'Notificación creada correctamente'
            ], 201);

        } catch (\Exception $e) {
             return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}