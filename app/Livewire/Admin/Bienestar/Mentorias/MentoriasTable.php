<?php

namespace App\Livewire\Admin\Bienestar\Mentorias;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\BienestarMentoria;

class MentoriasTable extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';

    public string $search = '';
    public string $sortField = 'titulo';
    public string $sortDirection = 'asc';
    public int $perPage = 10;

    protected $listeners = [
        'mentoriaSaved' => '$refresh',
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
        $this->dispatch('open-edit-mentoria', id: $id);
    }

    public function delete(int $id): void
    {
        BienestarMentoria::find($id)?->delete();
        $this->dispatch('mentoriaSaved');
    }

    public function render()
    {
        $query = BienestarMentoria::query()
            ->when($this->search, function ($q) {
                $s = '%' . $this->search . '%';
                $q->where('titulo', 'like', $s)
                    ->orWhere('descripcion', 'like', $s);
            })
            ->orderBy($this->sortField, $this->sortDirection);

        $mentorias = $query->paginate($this->perPage);

        return view('livewire.admin.bienestar.mentorias.mentorias-table', [
            'mentorias' => $mentorias,
        ]);
    }
}
