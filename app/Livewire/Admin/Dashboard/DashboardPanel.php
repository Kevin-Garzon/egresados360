<?php

namespace App\Livewire\Admin\Dashboard;

use Livewire\Component;
use App\Models\VisitaDiaria;
use App\Models\Interaccion;
use App\Models\PerfilEgresado;
use Carbon\Carbon;

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

    public function mount()
    {
        $this->cargarVisitas();
        $this->cargarInteracciones();
        $this->cargarTasaParticipacion();
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
        // Total de interacciones registradas
        $this->totalInteracciones = Interaccion::count();

        // Total de perfiles (egresados registrados)
        $this->totalPerfiles = PerfilEgresado::select('correo')->distinct()->count();

        // Top 5 ítems más clicados
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
        // Total egresados registrados (sin duplicar por correo)
        $this->totalEgresados = PerfilEgresado::select('correo')->distinct()->count();

        // Egresados que han tenido al menos una interacción
        $this->egresadosActivos = Interaccion::distinct('perfil_id')->count('perfil_id');

        // Cálculo de tasa de participación
        if ($this->totalEgresados > 0) {
            $this->tasaParticipacion = round(($this->egresadosActivos / $this->totalEgresados) * 100, 1);
        } else {
            $this->tasaParticipacion = 0;
        }
    }

    public function render()
    {
        return view('livewire.admin.dashboard.dashboard-panel')
            ->extends('layouts.admin')
            ->section('content');
    }
}
