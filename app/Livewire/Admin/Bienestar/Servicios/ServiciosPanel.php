<?php

namespace App\Livewire\Admin\Bienestar\Servicios;

use Livewire\Component;
use App\Models\BienestarServicio;

class ServiciosPanel extends Component
{
    public $totalServicios;
    public $activos;
    public $inactivos;

    public function mount()
    {
        $this->totalServicios = BienestarServicio::count();
        $this->activos = BienestarServicio::where('activo', true)->count();
        $this->inactivos = BienestarServicio::where('activo', false)->count();
    }

    public function render()
    {
        return view('livewire.admin.bienestar.servicios.servicios-panel')
            ->extends('layouts.admin')
            ->section('content');
    }
}
