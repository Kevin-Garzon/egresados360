<?php

namespace App\Livewire\Public;

use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\PerfilEgresado;

class PerfilEgresadoForm extends Component
{

    public $nombre;
    public $correo;
    public $celular;
    public $programa;
    public $anio_egreso;
    public $mostrarModal = false;

    protected $rules = [
        'nombre' => 'required|string|max:255',
        'correo' => 'required|email|max:255',
        'celular' => 'nullable|string|max:20',
        'programa' => 'nullable|string|max:255',
        'anio_egreso' => 'nullable|digits:4',
    ];

    #[On('abrirFormularioPerfil')]
    public function mostrarFormulario(): void
    {
        $this->mostrarModal = true;
    }

    public function guardarPerfil(): void
    {
        $this->validate();

        $perfil = PerfilEgresado::updateOrCreate(
            ['correo' => $this->correo],
            [
                'nombre' => $this->nombre,
                'celular' => $this->celular,
                'programa' => $this->programa,
                'anio_egreso' => $this->anio_egreso,
            ]
        );

        // JS escuchará esto para guardar perfil_id y reanudar el clic pendiente
        $this->dispatch('perfil-guardado', id: $perfil->id);


        $this->mostrarModal = false;
        $this->reset(['nombre', 'correo', 'celular', 'programa', 'anio_egreso']);
    }

    public function render()
    {
        return view('livewire.public.perfil-egresado-form');
    }
}
