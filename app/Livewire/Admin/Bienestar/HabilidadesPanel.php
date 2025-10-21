<?php

namespace App\Livewire\Admin\Bienestar;

use Livewire\Component;
use App\Models\BienestarHabilidad;

class HabilidadesPanel extends Component
{
    public $totalHabilidades;
    public $activas;
    public $inactivas;

    public function mount()
    {
        $this->totalHabilidades = BienestarHabilidad::count();
        $this->activas = BienestarHabilidad::where('activo', true)->count();
        $this->inactivas = BienestarHabilidad::where('activo', false)->count();
    }

    public function render()
    {
        return view('livewire.admin.bienestar.habilidades-panel')
            ->extends('layouts.admin')
            ->section('content');
    }
}
