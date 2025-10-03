<?php

namespace App\Livewire\Admin\Laboral;

use Livewire\Component;
use App\Models\Empresa;
use App\Models\OfertaLaboral;
use Livewire\Attributes\Layout;

#[Layout('layouts.admin')]
class LaboralPanel extends Component
{
    public function render()
    {
        $empresasCount = Empresa::count();
        $ofertasActivas = OfertaLaboral::where('activo', true)->count();

        return view('livewire.admin.laboral.laboral-panel', compact('empresasCount', 'ofertasActivas'));
    }
}