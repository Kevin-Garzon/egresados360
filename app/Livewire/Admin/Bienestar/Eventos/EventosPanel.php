<?php

namespace App\Livewire\Admin\Bienestar\Eventos;

use Livewire\Component;
use App\Models\BienestarEvento;
use Carbon\Carbon;

class EventosPanel extends Component
{
    public $totalEventos;
    public $proximos;
    public $finalizados;

    public function mount()
    {
        $this->totalEventos = BienestarEvento::count();
        $this->proximos = BienestarEvento::whereDate('fecha_inicio', '>=', Carbon::today())->count();
        $this->finalizados = BienestarEvento::whereDate('fecha_fin', '<', Carbon::today())->count();
    }

    public function render()
    {
        return view('livewire.admin.bienestar.eventos.eventos-panel')
            ->extends('layouts.admin')
            ->section('content');
    }
}
