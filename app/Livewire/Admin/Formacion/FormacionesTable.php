<?php

namespace App\Livewire\Admin\Formacion;

use App\Models\Formacion;
use App\Models\Interaccion;
use Livewire\Component;
use Livewire\WithPagination;

class FormacionesTable extends Component
{
    use WithPagination;

    // Mantener Tailwind en la paginación
    protected $paginationTheme = 'tailwind';

    // Búsqueda y ordenamiento
    public string $search = '';
    public string $sortField = 'fecha_inicio'; // campo por defecto
    public string $sortDirection = 'desc';

    public int $perPage = 10;

    // Eventos: el formulario escuchará estos
    protected $listeners = [
        'formacionSaved' => '$refresh', // refresca la tabla cuando se guarda algo
    ];

    // Ordenar por columna
    public function sortBy(string $field): void
    {
        // Si vuelvo a hacer click en la misma columna, invierto el orden
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
        $this->dispatch('open-create-formacion');
    }

    // Abrir formulario de edición
    public function openEdit(int $id): void
    {
        $this->dispatch('open-edit-formacion', id: $id);
    }

    // Eliminar registro
    public function delete(int $id): void
    {
        // Confirmación básica; si se requiere modal, se implementa luego
        Formacion::whereKey($id)->delete();
        $this->dispatch('formacionSaved');
    }

    public function updatingSearch(): void
    {
        // Cuando cambia el search, vuelvo a la primera página
        $this->resetPage();
    }

    public function render()
    {
        // Filtro por búsqueda en campos clave
        $query = Formacion::query()
            ->when($this->search, function ($q) {
                $s = '%' . $this->search . '%';
                $q->where(function ($q2) use ($s) {
                    $q2->where('titulo', 'like', $s)
                        ->orWhere('programa', 'like', $s)
                        ->orWhere('modalidad', 'like', $s)
                        ->orWhere('tipo', 'like', $s);
                });
            })
            ->orderBy($this->sortField, $this->sortDirection);

        $formaciones = $query->paginate($this->perPage);

        // Reemplaza el contador viejo por el nuevo sistema global
        $formaciones->getCollection()->transform(function ($formacion) {
            $formacion->interacciones_nuevas = \App\Models\Interaccion::where('module', 'formacion')
                ->where('item_id', $formacion->id)
                ->count();
            return $formacion;
        });

        return view('livewire.admin.formacion.formaciones-table', [
            'formaciones' => $formaciones,
        ]);
    }
}
