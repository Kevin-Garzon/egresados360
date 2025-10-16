<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Formacion;
use Carbon\Carbon;

class FormacionController extends Controller
{
    /**
     * Muestra la vista pública de formación continua.
     */
    public function index()
    {
        // Desactiva automáticamente los programas cuya fecha de fin ya haya pasado
        Formacion::whereDate('fecha_fin', '<', Carbon::today())
            ->where('activo', true)
            ->update(['activo' => false]);

        // Obtiene las formaciones activas, ordenadas por fecha de inicio (más recientes primero)
        $formaciones = Formacion::where('activo', true)
            ->orderBy('fecha_inicio', 'desc')
            ->get();

        // Obtiene las categorías únicas (programa) para los filtros del front
        $categorias = Formacion::whereNotNull('programa')
            ->distinct()
            ->pluck('programa');

        // Retorna la vista pública con los datos
        return view('formacion.index', compact('formaciones', 'categorias'));
    }

    public function show(Formacion $formacion)
    {
        return view('formacion.show', compact('formacion'));
    }
}
