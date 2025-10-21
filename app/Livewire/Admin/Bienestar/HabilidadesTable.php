<?php

namespace App\Livewire\Admin\Bienestar;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\BienestarHabilidad;

class HabilidadesTable extends Component
{
    use WithPagination;

    public string $search = '';
    public string $estado = 'todas'; // todas | activas | inactivas
    public string $orden = 'fecha_desc'; // fecha_desc | fecha_asc | titulo_asc

    protected $queryString = ['search', 'estado', 'orden', 'page'];

    public function updatingSearch() { $this->resetPage(); }
    public function updatingEstado() { $this->resetPage(); }
    public function updatingOrden()  { $this->resetPage(); }

    public function render()
    {
        $q = BienestarHabilidad::query();

        if ($this->search !== '') {
            $q->where(function ($w) {
                $w->where('titulo', 'like', "%{$this->search}%")
                  ->orWhere('descripcion', 'like', "%{$this->search}%")
                  ->orWhere('tema', 'like', "%{$this->search}%");
            });
        }

        if ($this->estado === 'activas')  $q->where('activo', true);
        if ($this->estado === 'inactivas') $q->where('activo', false);

        $q = match ($this->orden) {
            'fecha_asc'  => $q->orderBy('fecha', 'asc'),
            'titulo_asc' => $q->orderBy('titulo', 'asc'),
            default      => $q->orderBy('fecha', 'desc'),
        };

        $habilidades = $q->paginate(10);

        return view('livewire.admin.bienestar.habilidades-table', compact('habilidades'));
    }
}
