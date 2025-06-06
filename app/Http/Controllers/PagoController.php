<?php

namespace App\Http\Controllers;

use App\Models\Pago;
use App\Models\FondosCondominio;
use App\Models\Notificacion;
use Illuminate\Http\Request;

class PagoController extends Controller
{
    // Listar todos los pagos
    public function index() {
        return response()->json(Pago::with('usuario', 'apartamento', 'cuota')->get());
    }

    // Listar pagos por apartamento
    public function pagosPorApartamento($id) {
        return response()->json(Pago::where('id_apartamento', $id)->get());
    }

    // Crear un nuevo pago (validación previa)
    public function store(Request $request) {
        $request->validate([
            'id_apartamento' => 'required|exists:apartamentos,id',
            'id_usuario' => 'required|exists:usuarios,id',
            'monto' => 'required|numeric|min:0',
            'fecha_pago' => 'required|date',
            'forma_pago' => 'required|in:parcial,completo',
            'id_cuota' => 'nullable|exists:cuotas,id',
        ]);

        // Aquí podrías validar la deuda del apartamento
        $deuda = \App\Models\DeudasApartamento::where('id_apartamento', $request->id_apartamento)
                    ->where('id_usuario', $request->id_usuario)
                    ->sum('monto_deuda');

        if ($request->monto > $deuda) {
            return response()->json(['error' => 'El monto excede la deuda del apartamento.'], 400);
        }

        $pago = Pago::create($request->all());
        return response()->json(['mensaje' => 'Pago registrado correctamente', 'data' => $pago], 201);
    }

    // Validar y aprobar el pago
    public function validarPago($id) {
        $pago = Pago::findOrFail($id);

        if ($pago->estatus === 'pagado') {
            return response()->json(['mensaje' => 'El pago ya está validado.'], 400);
        }

        $pago->estatus = 'pagado';
        $pago->save();

        // Registrar en fondos del condominio
        FondosCondominio::create([
            'tipo_movimiento' => 'ingreso',
            'monto' => $pago->monto,
            'fondo_activo_bs' => $pago->monto, // Se asume que se suma
            'fondo_pasivo_usd' => 0,
            'descripcion' => 'Ingreso por validación de pago',
            'fecha' => now(),
        ]);

        // Notificar al usuario
        Notificacion::create([
            'titulo' => 'Pago Validado',
            'mensaje' => 'Tu pago ha sido validado correctamente.',
            'tipo' => 'cobro',
            'id_usuario' => $pago->id_usuario,
        ]);

        return response()->json(['mensaje' => 'Pago validado y fondos actualizados.']);
    }

    // Rechazar un pago
    public function rechazarPago($id) {
        $pago = Pago::findOrFail($id);

        if ($pago->estatus === 'pagado') {
            return response()->json(['mensaje' => 'No se puede rechazar un pago ya validado.'], 400);
        }

        $pago->estatus = 'pendiente'; // Opcional: podrías usar otro estado como 'rechazado'
        $pago->save();

        Notificacion::create([
            'titulo' => 'Pago Rechazado',
            'mensaje' => 'Tu pago fue rechazado. Verifica el comprobante y vuelve a intentarlo.',
            'tipo' => 'cobro',
            'id_usuario' => $pago->id_usuario,
        ]);

        return response()->json(['mensaje' => 'Pago rechazado y notificación enviada.']);
    }
}
