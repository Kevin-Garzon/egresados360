<?php

namespace App\Livewire\Admin\Dashboard;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Interaccion;

class InteraccionesTable extends Component
{
    use WithPagination;

    public $filtroModulo = '';
    public $filtroIdentificacion = '';

    protected $paginationTheme = 'tailwind';
    
    public function updating($name)
    {
        // Cuando se cambie un filtro, reinicia la paginación de la tabla
        $this->resetPage('interaccionesPage');
    }

    public function render()
    {
        $query = Interaccion::with('perfil')->latest();

        if ($this->filtroModulo) {
            $query->where('module', $this->filtroModulo);
        }

        if ($this->filtroIdentificacion === 'identificado') {
            $query->whereNotNull('perfil_id');
        } elseif ($this->filtroIdentificacion === 'anonimo') {
            $query->whereNull('perfil_id');
        }

        // 🚨 CAMBIO CLAVE: Usar 'interaccionesPage' en paginate()
        $interacciones = $query->paginate(10, ['*'], 'interaccionesPage');

        return view('livewire.admin.dashboard.interacciones-table', [
            'interacciones' => $interacciones,
        ]);
    }
}