<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Apartamentos extends Model
{
    protected $fillable = ['piso', 'letra', 'habitaciones', 'propietario_id', 'inquilino_id'];


    /**
     * Asigna un inquilino a un apartamento existente
     *
     * @param mixed $id_inquilino
     * @param mixed $id_apartamento
     * 
     * @return [type]
     * 
     */
    public static function asignarInquilino($id_inquilino, $id_apartamento)
    {

        //Buscamos el apartamento para verificar que el inquilino no sea el propietario
        $apartamento = Apartamentos::findOrFail($id_inquilino);

        //lanzamos la excepción
        if ($apartamento->propietario_id == $id_inquilino) {
            throw new \Exception('Un propietario no se puede asignar como inquilino de un apartamento', 400);
        }

        $apartamentos = Apartamentos::findOrFail($id_apartamento);
        $apartamentos->inquilino_id = $id_inquilino;
        $apartamentos->save();

        return $apartamentos;
    }
}
