<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Apartamentos;


class ApartamentosController extends Controller
{
    public function listarApartamentos(Request $request)
    {
        try {

            return response()->json(Apartamentos::all(), 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Signa un inquilino a un apartamento existente 
     *
     * @param Request $request
     * 
     * @return [type]
     * 
     */
    public function asignarInquilino(Request $request)
    {
        try {
            //capturamos el body de la peticion
            $data = $request->json()->all();

            //retornamos el apartamento editado
            $apartamento = Apartamentos::asignarInquilino($data['id_inquilino'], $data['id_apartamento']);

            return response()->json($apartamento, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
