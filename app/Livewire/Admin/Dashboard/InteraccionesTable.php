<?php

namespace App\Livewire\Admin\Dashboard;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Interaccion;
use Illuminate\Support\Facades\DB;

class InteraccionesTable extends Component
{
    use WithPagination;

    public $filtroModulo = '';
    public $filtroPrograma = '';
    public $fechaFiltro = null;

    protected $paginationTheme = 'tailwind';

    public function updating($name)
    {
        // Reinicia la paginación cuando cambia cualquier filtro
        $this->resetPage('interaccionesPage');
    }

    public function render()
    {
        $query = Interaccion::with('perfil')->latest();

        // Filtro por módulo
        if ($this->filtroModulo) {
            $query->where('module', $this->filtroModulo);
        }

        // Filtro por programa (a través de la relación con perfil)
        if ($this->filtroPrograma) {
            $query->whereHas('perfil', function ($q) {
                $q->where('programa', $this->filtroPrograma);
            });
        }

        // Filtro por fecha 
        if ($this->fechaFiltro) {
            $query->whereDate('created_at', $this->fechaFiltro);
        }

        $interacciones = $query->paginate(10, ['*'], 'interaccionesPage');

        // Programas distintos disponibles
        $programas = DB::table('perfiles_egresado')
            ->whereNotNull('programa')
            ->distinct()
            ->orderBy('programa')
            ->pluck('programa');

        return view('livewire.admin.dashboard.interacciones-table', [
            'interacciones' => $interacciones,
            'programas'     => $programas,
        ]);
    }
}
