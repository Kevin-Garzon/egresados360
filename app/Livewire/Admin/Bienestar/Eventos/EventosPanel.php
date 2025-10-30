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
    public $enCurso;

    public function mount()
    {
        $this->totalEventos = BienestarEvento::count();

        $eventosActivos = BienestarEvento::where('activo', true)->get();

        $this->proximos    = $eventosActivos->filter(fn($e) => $e->tipo_slug === 'proximo')->count();
        $this->enCurso     = $eventosActivos->filter(fn($e) => $e->tipo_slug === 'encurso')->count();
        $this->finalizados = $eventosActivos->filter(fn($e) => $e->tipo_slug === 'finalizado')->count();
    }



    public function render()
    {
        return view('livewire.admin.bienestar.eventos.eventos-panel')
            ->extends('layouts.admin')
            ->section('content');
    }
}
