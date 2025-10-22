<?php

namespace App\Http\Controllers;

use App\Models\BienestarHabilidad;
use App\Models\BienestarServicio;
use App\Models\BienestarEvento;
use Illuminate\Http\JsonResponse;
use Carbon\Carbon;

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

        // Mostrar los eventos activos ordenados por fecha
        $eventos = BienestarEvento::where('activo', true)
            ->orderBy('fecha_inicio', 'asc')
            ->get();

        return view('bienestar.index', compact('habilidades', 'servicios', 'eventos'));
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

    // =======================
    // EVENTOS (LISTADO Y DETALLES)
    // =======================
    public function showEvento($id): JsonResponse
    {
        $evento = BienestarEvento::find($id);

        if (!$evento) {
            return response()->json(['error' => 'Evento no encontrado'], 404);
        }

        if ($evento->imagen) {
            $evento->imagen_url = asset('storage/' . $evento->imagen);
        }

        $evento->fecha_inicio_format = $evento->fecha_inicio
            ? Carbon::parse($evento->fecha_inicio)->translatedFormat('d M Y')
            : null;

        $evento->fecha_fin_format = $evento->fecha_fin
            ? Carbon::parse($evento->fecha_fin)->translatedFormat('d M Y')
            : null;

        return response()->json($evento);
    }
}
