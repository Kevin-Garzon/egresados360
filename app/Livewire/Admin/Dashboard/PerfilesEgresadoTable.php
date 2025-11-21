<?php

namespace App\Livewire\Admin\Dashboard;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\PerfilEgresado;
use App\Models\Interaccion;
use Illuminate\Support\Facades\DB;

class PerfilesEgresadoTable extends Component
{
    use WithPagination;

    public $filtroPrograma = '';
    public $buscar = '';

    public $mostrarHistorial = false;
    public $egresadoSeleccionado = null;
    public $historial = [];

    protected $paginationTheme = 'tailwind';

    public function updated($field)
    {
        if (in_array($field, ['filtroPrograma', 'buscar'])) {
            $this->resetPage('perfilesPage');
        }
    }

    // Abrir modal con historial
    public function verHistorial($correo)
    {
        $this->egresadoSeleccionado = PerfilEgresado::where('correo', $correo)->first();

        if ($this->egresadoSeleccionado) {
            $this->historial = Interaccion::where('perfil_id', $this->egresadoSeleccionado->id)
                ->orderByDesc('created_at')
                ->get();

            $this->mostrarHistorial = true;
        }
    }

    public function render()
    {
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

        // Filtro por programa
        if ($this->filtroPrograma) {
            $query->where('programa', $this->filtroPrograma);
        }

        // Búsqueda por nombre o correo
        if ($this->buscar) {
            $query->where(function ($q) {
                $q->where('nombre', 'like', '%' . $this->buscar . '%')
                  ->orWhere('correo', 'like', '%' . $this->buscar . '%');
            });
        }

        $perfiles = $query->paginate(10, ['*'], 'perfilesPage');

        return view('livewire.admin.dashboard.perfiles-egresado-table', [
            'perfiles' => $perfiles,
        ]);
    }
}
