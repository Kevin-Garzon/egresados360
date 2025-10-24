<?php

namespace App\Http\Controllers;

use App\Models\OfertaLaboral;
use App\Models\Empresa;
use Carbon\Carbon;

class LaboralController extends Controller
{
    public function index()
    {
        // Desactivar automáticamente las ofertas vencidas
        OfertaLaboral::where('activo', true)
            ->whereDate('fecha_cierre', '<', Carbon::today())
            ->update(['activo' => false]);

        // Ofertas activas 
        $ofertas = OfertaLaboral::with('empresa')
            ->where('activo', true)
            ->orderBy('publicada_en', 'desc')
            ->get();

        // Empresas aliadas
        $empresas = Empresa::orderBy('nombre')->get();

        // Enviar a la vista
        return view('laboral.index', compact('ofertas', 'empresas'));
    }
}
