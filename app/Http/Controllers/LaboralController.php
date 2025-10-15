<?php

namespace App\Http\Controllers;

use App\Models\OfertaLaboral;
use App\Models\Empresa;

class LaboralController extends Controller
{
    public function index()
    {
        // Ofertas activas
        $ofertas = OfertaLaboral::with('empresa')
            ->where('activo', true)
            ->orderBy('publicada_en', 'desc')
            ->get();

        
        $empresas = Empresa::orderBy('nombre')->get();

        return view('laboral.index', compact('ofertas', 'empresas'));
    }
}
