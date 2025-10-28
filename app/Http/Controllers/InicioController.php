<?php

namespace App\Http\Controllers;

use App\Models\OfertaLaboral;
use App\Models\Formacion;
use App\Models\BienestarEvento;
use App\Models\BienestarHabilidad;
use App\Models\BienestarServicio;
use App\Models\BienestarMentoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;

class InicioController extends Controller
{
    public function index()
    {
        // Consultas: últimas 5 por fecha, combinadas y ordenadas
        $items = collect()
            ->merge(
                OfertaLaboral::select('titulo', 'created_at')
                    ->addSelect(\DB::raw("'Laboral' as tipo"))
                    ->addSelect(\DB::raw("'/laboral' as url"))
                    ->latest('created_at')
                    ->take(5)
                    ->get()
            )
            ->merge(
                Formacion::select('titulo', 'created_at')
                    ->addSelect(\DB::raw("'Formación' as tipo"))
                    ->addSelect(\DB::raw("'/formacion' as url"))
                    ->latest('created_at')
                    ->take(5)
                    ->get()
            )
            ->merge(
                BienestarEvento::select('titulo', 'created_at')
                    ->addSelect(\DB::raw("'Evento' as tipo"))
                    ->addSelect(\DB::raw("'/bienestar' as url"))
                    ->latest('created_at')
                    ->take(5)
                    ->get()
            )
            ->merge(
                BienestarHabilidad::select('titulo', 'created_at')
                    ->addSelect(\DB::raw("'Habilidad' as tipo"))
                    ->addSelect(\DB::raw("'/bienestar' as url"))
                    ->latest('created_at')
                    ->take(5)
                    ->get()
            )
            ->merge(
                BienestarServicio::select('nombre as titulo', 'created_at')
                    ->addSelect(\DB::raw("'Servicio' as tipo"))
                    ->addSelect(\DB::raw("'/bienestar' as url"))
                    ->latest('created_at')
                    ->take(5)
                    ->get()
            )
            ->merge(
                BienestarMentoria::select('titulo', 'created_at')
                    ->addSelect(\DB::raw("'Mentoría' as tipo"))
                    ->addSelect(\DB::raw("'/bienestar' as url"))
                    ->latest('created_at')
                    ->take(5)
                    ->get()
            )
            ->sortByDesc('created_at')
            ->take(5)
            ->values();

        return view('inicio', compact('items'));
    }
}
