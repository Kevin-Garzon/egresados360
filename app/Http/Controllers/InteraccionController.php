<?php

namespace App\Http\Controllers;

use App\Models\OfertaLaboral;
use Illuminate\Http\Request;

class InteraccionController extends Controller
{
    public function registrar($id)
    {
        $oferta = OfertaLaboral::find($id);

        if ($oferta) {
            $oferta->increment('interacciones');
            return response()->json(['success' => true, 'interacciones' => $oferta->interacciones]);
        }

        return response()->json(['success' => false], 404);
    }
}
