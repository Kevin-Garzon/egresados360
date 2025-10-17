<?php

namespace App\Http\Controllers;

use App\Models\OfertaLaboral;
use App\Models\Formacion;
use Illuminate\Http\Request;

class InteraccionController extends Controller
{
    /**
     * Registra una interacción en una oferta laboral
     */
    public function registrarOferta($id)
    {
        $oferta = OfertaLaboral::find($id);

        if ($oferta) {
            $oferta->increment('interacciones');
            return response()->json(['success' => true, 'interacciones' => $oferta->interacciones]);
        }

        return response()->json(['success' => false], 404);
    }

    /**
     * Registra una interacción en un programa de formación
     */
    public function registrarFormacion($id)
    {
        $formacion = Formacion::find($id);

        if ($formacion) {
            $formacion->increment('interacciones');
            return response()->json(['success' => true, 'interacciones' => $formacion->interacciones]);
        }

        return response()->json(['success' => false], 404);
    }
}
