<?php

namespace App\Livewire\Admin\Bienestar\Habilidades;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\BienestarHabilidad;

class HabilidadesTable extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';

    // Propiedades reactivas
    public string $search = '';
    public string $sortField = 'fecha'; // Campo por defecto
    public string $sortDirection = 'desc';
    public int $perPage = 10;

    // Escuchar eventos del formulario para refrescar
    protected $listeners = [
        'habilidadSaved' => '$refresh',
    ];

    // Cambiar orden
    public function sortBy(string $field): void
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
        $this->resetPage();
    }

    // Abrir formulario de creación
    public function openCreate(): void
    {
        $this->dispatch('open-create-habilidad');
    }

    // Abrir formulario de edición
    public function openEdit(int $id): void
    {
        $this->dispatch('open-edit-habilidad', id: $id);
    }

    // Eliminar habilidad
    public function delete(int $id): void
    {
        BienestarHabilidad::whereKey($id)->delete();
        $this->dispatch('habilidadSaved');
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = BienestarHabilidad::query()
            ->when($this->search, function ($q) {
                $s = '%' . $this->search . '%';
                $q->where(function ($sub) use ($s) {
                    $sub->where('titulo', 'like', $s)
                        ->orWhere('tema', 'like', $s)
                        ->orWhere('modalidad', 'like', $s);
                });
            })
            ->orderBy($this->sortField, $this->sortDirection);

        $habilidades = $query->paginate($this->perPage);

        return view('livewire.admin.bienestar.habilidades.habilidades-table', [
            'habilidades' => $habilidades,
        ]);
    }
}
