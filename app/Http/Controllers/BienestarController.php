<?php

namespace App\Http\Controllers;

use App\Models\BienestarHabilidad;
use App\Models\BienestarServicio;
use Illuminate\Http\JsonResponse;

class BienestarController extends Controller
{
    public function index()
    {
        // Solo mostrar las habilidades activas
        $habilidades = BienestarHabilidad::where('activo', true)
            ->orderBy('fecha', 'desc')
            ->get();

        // Mostrar los servicios y beneficios activos
        $servicios = BienestarServicio::where('activo', true)
            ->orderBy('nombre', 'asc')
            ->get();

        return view('bienestar.index', compact('habilidades', 'servicios'));
    }

    // =======================
    // HABILIDADES (DETALLES)
    // =======================
    public function show($id): JsonResponse
    {
        $habilidad = BienestarHabilidad::find($id);

        if (!$habilidad) {
            return response()->json(['error' => 'Habilidad no encontrada'], 404);
        }

        // Agregar URL pública completa de la imagen si existe
        if ($habilidad->imagen) {
            $habilidad->imagen_url = asset('storage/' . $habilidad->imagen);
        }

        return response()->json($habilidad);
    }

    // ==========================
    // SERVICIOS Y BENEFICIOS
    // ==========================
    public function showServicio($id): JsonResponse
    {
        $servicio = BienestarServicio::find($id);

        if (!$servicio) {
            return response()->json(['error' => 'Servicio no encontrado'], 404);
        }

        return response()->json($servicio);
    }
}
