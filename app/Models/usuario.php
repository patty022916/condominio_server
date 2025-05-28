<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class Usuario extends Model
{
    protected $fillable = ['nombre', 'apellido', 'email', 'telefono', 'password', 'id_rol'];


    /**
     *Obtiene los usuarios completos incluyendo el cargo
     *
     * @return [type]
     * 
     */
    public static function  getUserDataComplete($id_user = null)
    {
        $sql = "
        SELECT
            usuarios.id,
            usuarios.nombre,
            usuarios.apellido,
            usuarios.email,
            usuarios.password,
            usuarios.telefono,
            usuarios.id_rol,
            roles.nombre cargo,
            roles.permisos,
            apartamento.piso,
            apartamento.letra
        FROM usuarios
        INNER JOIN roles ON roles.id = usuarios.id_rol
        LEFT JOIN apartamentos as apartamento on apartamento.inquilino_id = usuarios.id 
        or apartamento.propietario_id = usuarios.id 
    ";

        $bindings = [];

        if ($id_user) {
            $sql .= " WHERE usuarios.id = ?";
            $bindings[] = $id_user;
        }

        $response = DB::select($sql, $bindings);

        foreach ($response as $key => $value) {
            $response[$key]->permisos = json_decode($response[$key]->permisos);
        }

        return $response;
    }

    public static function authenticationUser($email, $password)
    {
        //* Verificar si el usuario existe
        $sql = "SELECT * FROM usuarios WHERE email = ? AND password = ?";
        $bindings = [$email, $password];
        $user = DB::select($sql, $bindings);

        //si el arreglo esta vacio entonces el usuario no existe credenciales incorrectas
        if (count($user) == 0) {
            return response()->json(['error' => 'Email o clave incorrecta'], 401);
            throw new \Exception('Email o clave incorrecta', 400);
        }

        //retornamos el usuario
        return self::getUserDataComplete($user[0]->id);
    }
}
