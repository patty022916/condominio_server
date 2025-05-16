<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Roles;

class RolesController extends Controller
{
    public function getRoles(Request $request)
    {
        try {
            $roles = Roles::all();
            foreach ($roles as $key => $value) {
                $roles[$key]->permisos = json_decode($roles[$key]->permisos);
            }

            return response()->json($roles, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
