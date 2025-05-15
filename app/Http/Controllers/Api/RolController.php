<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Rol;
use Illuminate\Http\Request;

class RolController extends Controller
{
    public function index()
    {
        return response()->json(Rol::all(), 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string',
            'permisos' => 'required|array',
        ]);

        $rol = Rol::create([
            'nombre' => $request->nombre,
            'permisos' => $request->permisos,
        ]);

        return response()->json($rol, 201);
    }

    public function show($id)
    {
        $rol = Rol::find($id);

        if (!$rol) {
            return response()->json(['mensaje' => 'Rol no encontrado'], 404);
        }

        return response()->json($rol);
    }

    public function update(Request $request, $id)
    {
        $rol = Rol::find($id);

        if (!$rol) {
            return response()->json(['mensaje' => 'Rol no encontrado'], 404);
        }

        $rol->update($request->only(['nombre', 'permisos']));

        return response()->json($rol);
    }

    public function destroy($id)
    {
        $rol = Rol::find($id);

        if (!$rol) {
            return response()->json(['mensaje' => 'Rol no encontrado'], 404);
        }

        $rol->delete();

        return response()->json(['mensaje' => 'Rol eliminado correctamente']);
    }
}
