<?php

namespace App\Livewire\Admin\Laboral;

use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\Empresa;
use App\Models\OfertaLaboral;

class OfertaForm extends Component
{
    public bool $isOpen = false;

    // Campos
    public ?int $empresa_id = null;
    public string $titulo = '';
    public ?string $descripcion = null;
    public ?string $ubicacion = null;
    public string $etiquetas = ''; 
    public ?string $url_externa = null;
    public ?string $publicada_en = null;
    public ?string $fecha_cierre = null;
    public bool $activo = true;

    public $empresas = [];

    public function mount()
    {
        $this->empresas = Empresa::select('id', 'nombre')->orderBy('nombre')->get();
    }

    #[On('open-create-oferta')]
    public function openCreate()
    {
        $this->resetExcept('empresas');
        $this->activo = true;
        $this->publicada_en = now()->format('Y-m-d');
        $this->isOpen = true;
    }

    public function close()
    {
        $this->isOpen = false;
    }

    public function save()
    {


        $this->validate([
            'empresa_id'   => 'required|exists:empresas,id',
            'titulo'       => 'required|string|max:150',
            'descripcion'  => 'nullable|string',
            'ubicacion'    => 'nullable|string|max:120',
            'etiquetas'    => 'nullable|string',
            'url_externa'  => 'required|url|max:2048',
            'publicada_en' => 'nullable|date',
            'fecha_cierre' => 'nullable|date|after_or_equal:publicada_en',
            'activo'       => 'boolean',
        ]);

        OfertaLaboral::create([
            'empresa_id'   => $this->empresa_id,
            'titulo'       => $this->titulo,
            'descripcion'  => $this->descripcion,
            'ubicacion'    => $this->ubicacion,
            'etiquetas'    => $this->etiquetas
                                ? explode(',', $this->etiquetas) : [],
            'url_externa'  => $this->url_externa,
            'publicada_en' => $this->publicada_en ?? now(),
            'fecha_cierre' => $this->fecha_cierre,
            'activo'       => $this->activo,
        ]);

        // Cerramos y notificamos a la tabla
        $this->dispatch('oferta-added');
        $this->close();
    }

    public function render()
    {
        return view('livewire.admin.laboral.oferta-form');
    }
}
