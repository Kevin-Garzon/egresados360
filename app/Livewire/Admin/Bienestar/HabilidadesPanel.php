<?php

namespace App\Livewire\Admin\Bienestar;

use Livewire\Component;

class HabilidadesPanel extends Component
{
    public function render()
    {
        
        return view('livewire.admin.bienestar.habilidades-panel')
            ->extends('layouts.admin')
            ->section('content');
    }
}
