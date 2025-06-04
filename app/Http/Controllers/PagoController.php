<?php

namespace App\Http\Controllers;

use App\Models\Pago;
use App\Models\FondoCondominio;
use App\Models\Apartamento;
use App\Models\User;
use Illuminate\Http\Request;
use App\Notifications\PagoValidadoNotification;
use App\Notifications\PagoRechazadoNotification;

class PagoController extends Controller
{
    // 1. Crear pago
    public function store(Request $request)
    {
        $request->validate([
            'apartamento_id' => 'required|exists:apartamentos,id',
            'monto_bs' => 'required|numeric|min:0',
            'descripcion' => 'nullable|string',
        ]);

        $pago = Pago::create([
            'apartamento_id' => $request->apartamento_id,
            'monto_bs' => $request->monto_bs,
            'descripcion' => $request->descripcion,
            'estado' => 'pendiente',
        ]);

        return response()->json(['mensaje' => 'Pago registrado correctamente', 'pago' => $pago], 201);
    }

    // 2. Listar todos los pagos
    public function index()
    {
        $pagos = Pago::with('apartamento')->get();
        return response()->json($pagos);
    }

    // 3. Listar pagos por apartamento
    public function pagosPorApartamento($id)
    {
        $pagos = Pago::where('apartamento_id', $id)->get();
        return response()->json($pagos);
    }

    // 4. Validar pago (cambiar estado a pagado + actualizar fondo + notificar)
    public function validarPago($id)
    {
        $pago = Pago::findOrFail($id);

        if ($pago->estado !== 'pendiente') {
            return response()->json(['error' => 'El pago ya ha sido procesado.'], 400);
        }

        // Actualizar estado
        $pago->estado = 'pagado';
        $pago->save();

        // Actualizar fondo activo
        $fondo = FondoCondominio::first(); // Asegúrate que esta tabla tenga un solo registro
        $fondo->fondo_activo_bs += $pago->monto_bs;
        $fondo->save();

        // Notificar al propietario del apartamento
        $apartamento = $pago->apartamento;
        $user = $apartamento->usuario; // Asegúrate que la relación esté definida en el modelo Apartamento
        if ($user) {
            $user->notify(new PagoValidadoNotification($pago));
        }

        return response()->json(['mensaje' => 'Pago validado correctamente', 'nuevo_fondo_activo' => $fondo->fondo_activo_bs]);
    }

    // 5. Rechazar pago
    public function rechazarPago($id)
    {
        $pago = Pago::findOrFail($id);

        if ($pago->estado !== 'pendiente') {
            return response()->json(['error' => 'El pago ya ha sido procesado.'], 400);
        }

        $pago->estado = 'rechazado';
        $pago->save();

        // Notificar al usuario
        $apartamento = $pago->apartamento;
        $user = $apartamento->usuario;
        if ($user) {
            $user->notify(new PagoRechazadoNotification($pago));
        }

        return response()->json(['mensaje' => 'Pago rechazado y usuario notificado.']);
    }
// 6. Filtrar pagos por fecha (rango opcional)
public function filtrarPorFecha(Request $request)
{
    $request->validate([
        'desde' => 'nullable|date',
        'hasta' => 'nullable|date|after_or_equal:desde',
    ]);

    $query = Pago::query();

    if ($request->filled('desde')) {
        $query->whereDate('created_at', '>=', $request->desde);
    }

    if ($request->filled('hasta')) {
        $query->whereDate('created_at', '<=', $request->hasta);
    }

    $pagos = $query->with('apartamento')->get();

    return response()->json($pagos);
}

// 7. Filtrar pagos por estado
public function filtrarPorEstado($estado)
{
    $estado = strtolower($estado);

    if (!in_array($estado, ['pendiente', 'pagado', 'rechazado'])) {
        return response()->json(['error' => 'Estado no válido.'], 400);
    }

    $pagos = Pago::where('estado', $estado)->with('apartamento')->get();

    return response()->json($pagos);
}


}


