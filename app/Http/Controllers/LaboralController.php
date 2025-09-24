<?php

namespace App\Http\Controllers;

use App\Models\OfertaLaboral;

class LaboralController extends Controller
{
    public function index()
    {
        // Traer todas las ofertas
        $ofertas = OfertaLaboral::all();

        // Pasarlas a la vista
        return view('laboral.index', compact('ofertas'));
    }
}
