<?php

namespace App\Livewire\Admin\Bienestar\Servicios;

use App\Models\BienestarServicio;
use Livewire\Component;
use Livewire\WithPagination;

class ServiciosTable extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';

    public string $search = '';
    public string $sortField = 'nombre';
    public string $sortDirection = 'asc';
    public int $perPage = 10;

    protected $listeners = [
        'servicioSaved' => '$refresh',
    ];

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function sortBy(string $field): void
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function openEdit(int $id): void
    {
        $this->dispatch('open-edit-servicio', id: $id);
    }

    public function delete(int $id): void
    {
        BienestarServicio::whereKey($id)->delete();
        $this->dispatch('servicioSaved');
    }

    public function render()
    {
        $query = BienestarServicio::query()
            ->when($this->search, fn($q) =>
                $q->where('nombre', 'like', "%{$this->search}%")
                  ->orWhere('tipo', 'like', "%{$this->search}%")
                  ->orWhere('descripcion', 'like', "%{$this->search}%")
            )
            ->orderBy($this->sortField, $this->sortDirection);

        $servicios = $query->paginate($this->perPage);

        return view('livewire.admin.bienestar.servicios.servicios-table', [
            'servicios' => $servicios,
        ]);
    }
}
