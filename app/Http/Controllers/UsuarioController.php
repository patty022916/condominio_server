<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Usuario;

class UsuarioController extends Controller
{

    public function getUsers(Request $request)
    {
        try {

            return response()->json(Usuario::getUserDataComplete(), 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function createUser(Request $request)
    {

        try {

            $validatedData = $request->validate([
                'id' => 'nullable|integer',
                'nombre' => 'required|string|max:255',
                'apellido' => 'required|string|max:255',
                'email' => 'required|string',
                'password' => 'required',
                'telefono' => 'nullable|string|max:20',
                'id_rol' => 'required|integer',
            ]);


            //!quitamos los espacios
            $validatedData['password'] = trim($validatedData['password']);
            $validatedData['email'] = trim($validatedData['email']);

            //*SI el id es  0 o null entonces creamos un usuario
            if (empty($validatedData['id']) || $validatedData['id'] == 0) {

                $usuario = Usuario::create($validatedData);
            } else {
                //* Actualizar usuario existente y obtenerlo actualizado
                $usuario = Usuario::findOrFail($validatedData['id']);
                $usuario->update($validatedData);
            }

            $usuario = Usuario::getUserDataComplete($usuario->id);

            return response()->json($usuario[0], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function authenticationUser(Request $request)
    {
        try {
            $data = $request->json()->all();
            //!quitamos los espacios
            $data['password'] = trim($data['password']);
            $data['email'] = trim($data['email']);
            
            $usuario = Usuario::authenticationUser($data['email'], $data['password']);

            return response()->json($usuario[0], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


    public function deleteUser($id)
    {
        $usuario = Usuario::find($id);
        $usuario->delete();

        return response()->json(['mensaje' => 'Usuario eliminado correctamente']);
    }
}
