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


    /*  public function render()
    {
        $ofertas = OfertaLaboral::with('empresa')
            ->latest('created_at')
            ->paginate(10);

        return view('livewire.admin.laboral.ofertas-table', [
            'ofertas' => $ofertas
        ]);
    } */

    #[\Livewire\Attributes\On('oferta-added')]
    public function render()
    {
        $ofertas = \App\Models\OfertaLaboral::with('empresa')
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
    public function confirmDelete($id)
    {
        $this->dispatch('open-delete-confirm', id: $id);
    }
}
