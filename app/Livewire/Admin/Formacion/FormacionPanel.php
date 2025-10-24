<?php

namespace App\Livewire\Admin\Formacion;

use Livewire\Component;
use App\Models\Formacion;

class FormacionPanel extends Component
{
    public $totalFormaciones;
    public $activas;
    public $finalizadas;

    public function mount()
    {
        $this->totalFormaciones = Formacion::count();
        $this->activas = Formacion::where('activo', true)->count();
        $this->finalizadas = Formacion::where('activo', false)->count();
    }

    public function render()
    {
        return view('livewire.admin.formacion.formacion-panel')
            ->extends('layouts.admin')
            ->section('content');
    }
}
