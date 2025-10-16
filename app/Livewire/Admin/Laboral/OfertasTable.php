<?php

namespace App\Livewire\Admin\Laboral;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\OfertaLaboral;

class OfertasTable extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';

    public $search = ''; // Nuevo: texto de búsqueda

    protected $listeners = [
        'oferta-added' => '$refresh',
    ];

    // Reiniciar paginación al cambiar búsqueda
    public function updatingSearch()
    {
        $this->resetPage();
    }

    #[\Livewire\Attributes\On('oferta-added')]
    public function render()
    {
        $ofertas = OfertaLaboral::with('empresa')
            ->when($this->search, function ($query) {
                $query->where('titulo', 'like', "%{$this->search}%")
                    ->orWhereHas('empresa', fn($q) =>
                        $q->where('nombre', 'like', "%{$this->search}%")
                    )
                    ->orWhere('ubicacion', 'like', "%{$this->search}%");
            })
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

    public function confirmDelete($id)
    {
        $this->dispatch('open-delete-confirm', id: $id);
    }
}
