<?php

namespace App\Livewire\Admin\Dashboard;

use Livewire\Component;
use App\Models\VisitaDiaria;
use App\Models\Interaccion;
use App\Models\PerfilEgresado;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardPanel extends Component
{
    public $labels = [];
    public $values = [];
    public $totalHoy;
    public $totalSemana;
    public $totalMes;

    public $totalInteracciones;
    public $totalPerfiles;
    public $tasaParticipacion;

    public $egresadosActivos;
    public $totalEgresados;

    public $topItems = [];
    public $interaccionesPorModulo = [];

    public $variacionVisitas;
    public $variacionInteracciones;

    public $ultimasAcciones = [];

    public function mount()
    {
        $this->cargarVisitas();
        $this->cargarInteracciones();
        $this->cargarTasaParticipacion();
        $this->cargarInteraccionesPorModulo();
        $this->cargarComparativos();
        $this->cargarActividadReciente();
    }

    public function cargarVisitas()
    {
        $hoy = Carbon::today();
        $inicioSemana = $hoy->copy()->startOfWeek();
        $inicioMes = $hoy->copy()->startOfMonth();

        $this->totalHoy = VisitaDiaria::whereDate('fecha', $hoy)->sum('total');
        $this->totalSemana = VisitaDiaria::whereBetween('fecha', [$inicioSemana, $hoy])->sum('total');
        $this->totalMes = VisitaDiaria::whereBetween('fecha', [$inicioMes, $hoy])->sum('total');

        $dias = VisitaDiaria::orderBy('fecha', 'asc')
            ->where('fecha', '>=', $hoy->copy()->subDays(13))
            ->get();

        $this->labels = $dias->pluck('fecha')->map(fn($f) => Carbon::parse($f)->format('d M'))->toArray();
        $this->values = $dias->pluck('total')->toArray();
    }

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

    public function cargarTasaParticipacion()
    {
        $this->totalEgresados = PerfilEgresado::select('correo')->distinct()->count();
        $this->egresadosActivos = Interaccion::distinct('perfil_id')->count('perfil_id');

        $this->tasaParticipacion = $this->totalEgresados > 0
            ? round(($this->egresadosActivos / $this->totalEgresados) * 100, 1)
            : 0;
    }

    public function cargarInteraccionesPorModulo()
    {
        $this->interaccionesPorModulo = Interaccion::select('module', DB::raw('COUNT(*) as total'))
            ->groupBy('module')
            ->orderByDesc('total')
            ->pluck('total', 'module')
            ->toArray();
    }

    public function cargarComparativos()
    {
        $hoy = Carbon::today();
        $inicioSemanaActual = $hoy->copy()->startOfWeek();
        $inicioSemanaPasada = $inicioSemanaActual->copy()->subWeek();
        $finSemanaPasada = $inicioSemanaActual->copy()->subDay();

        $visitasActual = VisitaDiaria::whereBetween('fecha', [$inicioSemanaActual, $hoy])->sum('total');
        $visitasAnterior = VisitaDiaria::whereBetween('fecha', [$inicioSemanaPasada, $finSemanaPasada])->sum('total');

        $this->variacionVisitas = $visitasAnterior > 0
            ? round((($visitasActual - $visitasAnterior) / $visitasAnterior) * 100, 1)
            : 0;

        $interaccionesActual = Interaccion::whereBetween('created_at', [$inicioSemanaActual, $hoy])->count();
        $interaccionesAnterior = Interaccion::whereBetween('created_at', [$inicioSemanaPasada, $finSemanaPasada])->count();

        $this->variacionInteracciones = $interaccionesAnterior > 0
            ? round((($interaccionesActual - $interaccionesAnterior) / $interaccionesAnterior) * 100, 1)
            : 0;
    }

    public function cargarActividadReciente()
    {
        $this->ultimasAcciones = Interaccion::with('perfil')
            ->latest()
            ->take(5)
            ->get();
    }

    public function render()
    {
        return view('livewire.admin.dashboard.dashboard-panel')
            ->extends('layouts.admin')
            ->section('content');
    }
}
