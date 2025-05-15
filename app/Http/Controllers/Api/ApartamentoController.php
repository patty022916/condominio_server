<?php

namespace App\Http\Controllers\Api;

use App\Models\Apartamento;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ApartamentoController extends Controller
{
    public function index()
    {
        return Apartamento::with(['propietario', 'inquilino'])->get();
    }
}
