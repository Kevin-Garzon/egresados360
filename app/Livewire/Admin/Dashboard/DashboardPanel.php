<?php

namespace App\Livewire\Admin\Dashboard;

use Livewire\Component;
use App\Models\VisitaDiaria;
use App\Models\Interaccion;
use App\Models\PerfilEgresado;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardPanel extends Component
{
    /* ============================================================
    |  PROPIEDADES DE ESTADO Y DATOS
     ============================================================ */
    // Datos para los gráficos de visitas
    public $labels = [];
    public $values = [];
    public $totalHoy;
    public $totalSemana;
    public $totalMes;

    // Datos generales y métricas principales
    public $totalInteracciones;
    public $totalPerfiles;
    public $tasaParticipacion;
    public $egresadosActivos;
    public $totalEgresados;

    // Datos para rankings y distribuciones
    public $topItems = [];
    public $interaccionesPorModulo = [];
    public $egresadosPorPrograma = [];

    // Variaciones de comparación
    public $variacionVisitas;
    public $variacionInteracciones;

    // Actividad reciente
    public $ultimasAcciones = [];

    // Estadísticas comparadas (visitas, interacciones, egresados)
    public $visitasTotales;
    public $visitasSemana;
    public $visitasSemanaAnterior;
    public $visitasHoy;
    public $visitasHoyAnterior;
    public $variacionVisitasSemana;
    public $variacionVisitasDia;

    public $interaccionesTotales;
    public $interaccionesSemana;
    public $interaccionesSemanaAnterior;
    public $interaccionesHoy;
    public $interaccionesHoyAnterior;
    public $variacionInteraccionesSemana;
    public $variacionInteraccionesDia;

    public $egresadosTotales;
    public $egresadosSemana;
    public $egresadosSemanaAnterior;
    public $egresadosHoy;
    public $egresadosHoyAnterior;
    public $variacionEgresadosSemana;
    public $variacionEgresadosDia;


    /* ============================================================
    |  MÉTODO PRINCIPAL
     ============================================================ */
    public function mount()
    {
        $this->cargarVisitas();
        $this->cargarInteracciones();
        $this->cargarTasaParticipacion();
        $this->cargarInteraccionesPorModulo();
        $this->cargarEgresadosPorPrograma();
        $this->cargarEstadisticasComparadas();
        $this->cargarActividadReciente();
    }


    /* ============================================================
    |  MÉTODOS DE CARGA DE DATOS
     ============================================================ */

    /** Cargar datos de visitas diarias (últimos 14 días) */
    public function cargarVisitas()
    {
        $hoy = Carbon::today();
        $inicioSemana = $hoy->copy()->startOfWeek();
        $inicioMes = $hoy->copy()->startOfMonth();

        $this->totalHoy = VisitaDiaria::whereDate('fecha', $hoy)->sum('total');
        $this->totalSemana = VisitaDiaria::whereBetween('fecha', [$inicioSemana, $hoy])->sum('total');
        $this->totalMes = VisitaDiaria::whereBetween('fecha', [$inicioMes, $hoy])->sum('total');

        $dias = VisitaDiaria::where('fecha', '>=', $hoy->copy()->subDays(13))
            ->orderBy('fecha', 'asc')
            ->get();

        $this->labels = $dias->pluck('fecha')->map(fn($f) => Carbon::parse($f)->format('d M'))->toArray();
        $this->values = $dias->pluck('total')->toArray();
    }


    /** Cargar resumen de interacciones y top elementos */
    public function cargarInteracciones()
    {
        $this->totalInteracciones = Interaccion::count();
        $this->totalPerfiles = PerfilEgresado::select('correo')->distinct()->count();

        $this->topItems = Interaccion::select('item_title')
            ->selectRaw('COUNT(*) as total')
            ->groupBy('item_title')
            ->orderByDesc('total')
            ->limit(5)
            ->get()
            ->toArray();
    }


    /** Calcular tasa de participación de egresados */
    public function cargarTasaParticipacion()
    {
        $this->totalEgresados = PerfilEgresado::select('correo')->distinct()->count();
        $desde = Carbon::now()->subDays(7)->startOfDay();

        $this->egresadosActivos = Interaccion::where('created_at', '>=', $desde)
            ->distinct('perfil_id')
            ->count('perfil_id');

        $this->tasaParticipacion = $this->totalEgresados > 0
            ? round(($this->egresadosActivos / $this->totalEgresados) * 100, 1)
            : 0;
    }


    /** Cargar distribución de egresados por programa académico */
    public function cargarEgresadosPorPrograma()
    {
        $this->egresadosPorPrograma = PerfilEgresado::select('programa', DB::raw('COUNT(*) as total'))
            ->groupBy('programa')
            ->orderByDesc('total')
            ->limit(6)
            ->pluck('total', 'programa')
            ->toArray();
    }


    /** Cargar conteo de interacciones agrupadas por módulo */
    public function cargarInteraccionesPorModulo()
    {
        $this->interaccionesPorModulo = Interaccion::select('module', DB::raw('COUNT(*) as total'))
            ->groupBy('module')
            ->orderByDesc('total')
            ->pluck('total', 'module')
            ->toArray();
    }


    /** Cargar métricas comparativas entre semanas y días */
    public function cargarEstadisticasComparadas()
    {
        $hoy = Carbon::today();
        $mismoDiaSemanaPasada = $hoy->copy()->subWeek();
        $inicioSemanaActual = $hoy->copy()->startOfWeek();
        $inicioSemanaAnterior = $inicioSemanaActual->copy()->subWeek();
        $finSemanaAnterior = $inicioSemanaActual->copy()->subDay();

        /* ---------- VISITAS ---------- */
        $this->visitasTotales = VisitaDiaria::sum('total');
        $this->visitasSemana = VisitaDiaria::whereBetween('fecha', [$inicioSemanaActual, $hoy])->sum('total');
        $this->visitasSemanaAnterior = VisitaDiaria::whereBetween('fecha', [$inicioSemanaAnterior, $finSemanaAnterior])->sum('total');
        $this->visitasHoy = VisitaDiaria::whereDate('fecha', $hoy)->sum('total');
        $this->visitasHoyAnterior = VisitaDiaria::whereDate('fecha', $mismoDiaSemanaPasada)->sum('total');

        $this->variacionVisitasSemana = $this->visitasSemanaAnterior > 0
            ? round((($this->visitasSemana - $this->visitasSemanaAnterior) / $this->visitasSemanaAnterior) * 100, 1)
            : 0;

        $this->variacionVisitasDia = $this->visitasHoyAnterior > 0
            ? round((($this->visitasHoy - $this->visitasHoyAnterior) / $this->visitasHoyAnterior) * 100, 1)
            : 0;


        /* ---------- INTERACCIONES ---------- */
        $this->interaccionesTotales = Interaccion::count();
        $this->interaccionesSemana = Interaccion::whereBetween('created_at', [$inicioSemanaActual, $hoy->endOfDay()])->count();
        $this->interaccionesSemanaAnterior = Interaccion::whereBetween('created_at', [$inicioSemanaAnterior, $finSemanaAnterior])->count();
        $this->interaccionesHoy = Interaccion::whereDate('created_at', $hoy)->count();
        $this->interaccionesHoyAnterior = Interaccion::whereDate('created_at', $mismoDiaSemanaPasada)->count();

        $this->variacionInteraccionesSemana = $this->interaccionesSemanaAnterior > 0
            ? round((($this->interaccionesSemana - $this->interaccionesSemanaAnterior) / $this->interaccionesSemanaAnterior) * 100, 1)
            : 0;

        $this->variacionInteraccionesDia = $this->interaccionesHoyAnterior > 0
            ? round((($this->interaccionesHoy - $this->interaccionesHoyAnterior) / $this->interaccionesHoyAnterior) * 100, 1)
            : 0;


        /* ---------- EGRESADOS ---------- */
        $this->egresadosTotales = PerfilEgresado::select('correo')->distinct()->count();

        $this->egresadosSemana = PerfilEgresado::whereBetween('created_at', [$inicioSemanaActual, $hoy->endOfDay()])
            ->select('correo')->distinct()->count();

        $this->egresadosSemanaAnterior = PerfilEgresado::whereBetween('created_at', [$inicioSemanaAnterior, $finSemanaAnterior])
            ->select('correo')->distinct()->count();

        $this->egresadosHoy = PerfilEgresado::whereDate('created_at', $hoy)
            ->select('correo')->distinct()->count();

        $this->egresadosHoyAnterior = PerfilEgresado::whereDate('created_at', $mismoDiaSemanaPasada)
            ->select('correo')->distinct()->count();

        $this->variacionEgresadosSemana = $this->egresadosSemanaAnterior > 0
            ? round((($this->egresadosSemana - $this->egresadosSemanaAnterior) / $this->egresadosSemanaAnterior) * 100, 1)
            : 0;

        $this->variacionEgresadosDia = $this->egresadosHoyAnterior > 0
            ? round((($this->egresadosHoy - $this->egresadosHoyAnterior) / $this->egresadosHoyAnterior) * 100, 1)
            : 0;
    }


    /** Cargar últimas interacciones registradas */
    public function cargarActividadReciente()
    {
        $this->ultimasAcciones = Interaccion::with('perfil')
            ->latest()
            ->take(5)
            ->get();
    }


    /* ============================================================
    |  RENDERIZADO DEL COMPONENTE
     ============================================================ */
    public function render()
    {
        return view('livewire.admin.dashboard.dashboard-panel')
            ->extends('layouts.admin')
            ->section('content');
    }
}
