<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Notificacion;
use Exception;

class NotificacionController extends Controller
{
    /**
     * Crear una nueva notificación
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'titulo' => 'required|string|max:255',
                'mensaje' => 'nullable|string',
                'tipo' => 'required|in:cobro,reunion,alerta,general',
                'id_usuario' => 'required|exists:usuarios,id',
                'leida_at' => 'nullable|date'
            ]);

            $notificacion = Notificacion::crearNotificacion($request->all());

            return response()->json($notificacion, 200);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Mostrar notificación por ID
     */
    public function show($id)
    {
        try {
            $notificacion = DB::table('notificaciones')->where('id', $id)->first();

            if (!$notificacion) {
                return response()->json(['error' => 'Notificación no encontrada'], 404);
            }

            return response()->json(['success' => true, 'data' => $notificacion]);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Listar notificaciones por ID de usuario
     */
    public function listarNotificaciones()
    {
        try {
            $notificaciones = Notificacion::listarNotificaciones();

            return response()->json($notificaciones, 200);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Actualizar una notificación
     */
    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'titulo' => 'required|string|max:255',
                'mensaje' => 'nullable|string',
                'tipo' => 'required|in:cobro,reunion,alerta,general'
            ]);

            $notificacion = Notificacion::actualizarNotificacion($id, $request->all());

            return response()->json([
                'success' => true,
                'data' => $notificacion,
                'message' => 'Notificación actualizada correctamente'
            ]);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Marcar notificación como leída
     */
    public function marcarComoLeida($id)
    {
        try {
            $notificacion = Notificacion::marcarComoLeida($id);

            return response()->json([
                'success' => true,
                'data' => $notificacion,
                'message' => 'Notificación marcada como leída'
            ]);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Eliminar una notificación
     */
    public function destroy($id)
    {
        try {
            $deleted = DB::table('notificaciones')->where('id', $id)->delete();

            if (!$deleted) {
                return response()->json(['error' => 'No se pudo eliminar'], 404);
            }

            return response()->json(['success' => true, 'message' => 'Notificación eliminada']);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
