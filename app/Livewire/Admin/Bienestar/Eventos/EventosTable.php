<?php

namespace App\Livewire\Admin\Bienestar\Eventos;

use App\Models\BienestarEvento;
use Livewire\Component;
use Livewire\WithPagination;
use Carbon\Carbon;

class EventosTable extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';

    public string $search = '';
    public string $sortField = 'fecha_inicio';
    public string $sortDirection = 'desc';
    public int $perPage = 10;

    protected $listeners = [
        'eventoSaved' => '$refresh',
    ];
    

    public function updatingSearch()
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
        $this->dispatch('open-edit-evento', id: $id);
    }

    public function delete(int $id): void
    {
        BienestarEvento::find($id)?->delete();
        $this->dispatch('eventoSaved');
    }

    public function render()
    {
        $query = BienestarEvento::query()
            ->when($this->search, function ($q) {
                $s = '%' . $this->search . '%';
                $q->where('titulo', 'like', $s)
                    ->orWhere('descripcion', 'like', $s)
                    ->orWhere('modalidad', 'like', $s)
                    ->orWhere('ubicacion', 'like', $s);
            })
            ->orderBy($this->sortField, $this->sortDirection);

        $eventos = $query->paginate($this->perPage);

        return view('livewire.admin.bienestar.eventos.eventos-table', [
            'eventos' => $eventos,
        ]);
    }
}
