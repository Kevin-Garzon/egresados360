<?php

namespace App\Livewire\Admin\Dashboard;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\PerfilEgresado;
use Illuminate\Support\Facades\DB;

class PerfilesEgresadoTable extends Component
{
    use WithPagination;

    public $filtroPrograma = '';

    protected $paginationTheme = 'tailwind';

    public function updatedFiltroPrograma()
    {
        $this->resetPage();
    }

    public function render()
    {
        // Obtenemos los egresados únicos por correo (sin duplicados)
        $query = PerfilEgresado::select(
                DB::raw('MIN(id) as id'),
                'nombre',
                'correo',
                'celular',
                'programa',
                'anio_egreso',
                DB::raw('MIN(created_at) as created_at')
            )
            ->groupBy('nombre', 'correo', 'celular', 'programa', 'anio_egreso')
            ->orderByDesc(DB::raw('MIN(created_at)'));

        if ($this->filtroPrograma) {
            $query->where('programa', $this->filtroPrograma);
        }

        $perfiles = $query->paginate(10);

        return view('livewire.admin.dashboard.perfiles-egresado-table', [
            'perfiles' => $perfiles,
        ]);
    }
}
