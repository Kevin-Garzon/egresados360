<?php

namespace App\Http\Controllers;

use App\Models\BienestarHabilidad;

class BienestarController extends Controller
{
    public function index()
    {
        // Solo mostrar las habilidades activas
        $habilidades = BienestarHabilidad::where('activo', true)
            ->orderBy('fecha', 'desc')
            ->get();

        return view('bienestar.index', compact('habilidades'));
    }
}
