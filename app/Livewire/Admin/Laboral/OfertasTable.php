<?php

namespace App\Livewire\Admin\Laboral;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\OfertaLaboral;

class OfertasTable extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';

    protected $listeners = [
        'oferta-added' => '$refresh',
    ];


    public function render()
    {
        $ofertas = OfertaLaboral::with('empresa')
            ->latest('created_at')
            ->paginate(10);

        return view('livewire.admin.laboral.ofertas-table', [
            'ofertas' => $ofertas
        ]);
    }

    public function edit($id)
    {
        $this->dispatch('open-edit-oferta', id: $id);
    }

    // Eliminar oferta
    public function deleteConfirm($id)
    {
        
        $oferta = \App\Models\OfertaLaboral::find($id);

        if ($oferta) {
            $oferta->delete();
            $this->dispatch('oferta-added'); 
        }
    }
}
