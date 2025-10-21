<?php

namespace App\Http\Controllers;

use App\Models\BienestarHabilidad;
use Illuminate\Http\JsonResponse;

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

    public function show($id): JsonResponse
    {
        $habilidad = BienestarHabilidad::find($id);

        if (!$habilidad) {
            return response()->json(['error' => 'Habilidad no encontrada'], 404);
        }

        // Agregamos URL pública completa de la imagen si existe
        if ($habilidad->imagen) {
            $habilidad->imagen_url = asset('storage/' . $habilidad->imagen);
        }

        return response()->json($habilidad);
    }
}
