<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PerfilEgresado;

class EgresadoProfileController extends Controller
{
    public function upsert(Request $request)
    {
        $validated = $request->validate([
            'nombre'      => 'required|string|max:255',
            'correo'      => 'required|email',
            'celular'     => 'nullable|string|max:20',
            'programa'    => 'nullable|string|max:255',
            'anio_egreso' => 'nullable|digits:4',
        ]);

        $perfil = PerfilEgresado::updateOrCreate(
            ['correo' => $validated['correo']],
            $validated
        );

        return response()->json([
            'success'   => true,
            'perfil_id' => $perfil->id,
        ]);
    }
}
