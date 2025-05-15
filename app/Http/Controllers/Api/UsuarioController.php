<?php

namespace App\Http\Controllers\Api;

use App\Models\Usuario;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UsuarioController extends Controller
{
    public function index()
    {
        return Usuario::all();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'email' => 'required|email|unique:usuarios',
            'telefono' => 'nullable|string',
            'password' => 'required|string|min:6',
            'id_rol' => 'required|integer'
        ]);

        $validated['password'] = bcrypt($validated['password']);

        return Usuario::create($validated);
    }

    public function show($id)
    {
        return Usuario::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $usuario = Usuario::findOrFail($id);

        $usuario->update($request->only(['nombre', 'email', 'telefono', 'id_rol']));

        return $usuario;
    }

    public function destroy($id)
    {
        return Usuario::destroy($id);
    }
}
