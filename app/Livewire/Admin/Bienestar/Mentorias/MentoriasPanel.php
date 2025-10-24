<?php

namespace App\Livewire\Admin\Bienestar\Mentorias;

use Livewire\Component;
use App\Models\BienestarMentoria;

class MentoriasPanel extends Component
{
    public $totalMentorias;
    public $activas;
    public $inactivas;

    public function mount()
    {
        $this->totalMentorias = BienestarMentoria::count();
        $this->activas = BienestarMentoria::where('activo', true)->count();
        $this->inactivas = BienestarMentoria::where('activo', false)->count();
    }

    public function render()
    {
        return view('livewire.admin.bienestar.mentorias.mentorias-panel')
            ->extends('layouts.admin')
            ->section('content');
    }
}
