<?php

namespace App\Livewire\Admin\Laboral;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Empresa;

class EmpresasTable extends Component
{
    use WithPagination;

    public string $search = '';
    public int $perPage = 10;

    protected $queryString = ['search'];

    protected $listeners = [
        // Cuando creemos/editemos/eliminemos empresas, refrescamos la tabla
        'empresaSaved'   => '$refresh',
        'empresaDeleted' => '$refresh',
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function edit(int $id): void
    {
        // Lo usaremos en el siguiente paso (modal)
        $this->dispatch('open-edit-empresa', id: $id);
    }

    public function confirmDelete(int $id): void
    {
        // Lo usaremos en el siguiente paso (modal)
        $this->dispatch('open-delete-empresa', id: $id);
    }

    public function render()
    {
        $empresas = Empresa::query()
            ->when($this->search, fn ($q) =>
                $q->where('nombre', 'like', "%{$this->search}%")
                  ->orWhere('sector', 'like', "%{$this->search}%")
            )
            ->withCount([
                // total ofertas
                'ofertas',
                // ofertas activas
                'ofertas as ofertas_activas_count' => fn ($q) => $q->where('activo', true),
            ])
            ->orderBy('nombre')
            ->paginate($this->perPage);

        return view('livewire.admin.laboral.empresas-table', [
            'empresas' => $empresas,
        ]);
    }
}
