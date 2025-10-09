<?php

namespace App\Livewire\Admin\Laboral;

use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\Empresa;
use App\Models\OfertaLaboral;

class OfertaForm extends Component
{
    public bool $isOpen = false;

    // Estado
    public ?int $currentId = null;
    public bool $isEdit = false;

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
        $this->isEdit = false;
        $this->currentId = null;

        $this->activo = true;
        $this->publicada_en = now()->format('Y-m-d');
        $this->isOpen = true;
    }

    #[On('open-edit-oferta')]
    public function openEdit($id)
    {
        $this->resetExcept('empresas');

        $oferta = OfertaLaboral::findOrFail($id);

        $this->currentId   = $oferta->id;
        $this->isEdit      = true;

        $this->empresa_id   = $oferta->empresa_id;
        $this->titulo       = $oferta->titulo;
        $this->descripcion  = $oferta->descripcion;
        $this->ubicacion    = $oferta->ubicacion;
        $this->etiquetas    = is_array($oferta->etiquetas)
            ? implode(',', $oferta->etiquetas)
            : (string) $oferta->etiquetas;
        $this->url_externa  = $oferta->url_externa;
        $this->publicada_en = optional($oferta->publicada_en)->format('Y-m-d');
        $this->fecha_cierre = optional($oferta->fecha_cierre)->format('Y-m-d');
        $this->activo       = (bool) $oferta->activo;

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

        // Convertir etiquetas de texto a array
        $tags = $this->etiquetas ? explode(',', $this->etiquetas) : [];

        if ($this->isEdit && $this->currentId) {
            // Actualizar un registro existente
            $oferta = OfertaLaboral::find($this->currentId);

            if ($oferta) {
                $oferta->update([
                    'empresa_id'   => $this->empresa_id,
                    'titulo'       => $this->titulo,
                    'descripcion'  => $this->descripcion,
                    'ubicacion'    => $this->ubicacion,
                    'etiquetas'    => $tags,
                    'url_externa'  => $this->url_externa,
                    'publicada_en' => $this->publicada_en ?? now(),
                    'fecha_cierre' => $this->fecha_cierre,
                    'activo'       => $this->activo,
                ]);
            }
        } else {
            // Crear un nuevo registro
            OfertaLaboral::create([
                'empresa_id'   => $this->empresa_id,
                'titulo'       => $this->titulo,
                'descripcion'  => $this->descripcion,
                'ubicacion'    => $this->ubicacion,
                'etiquetas'    => $tags,
                'url_externa'  => $this->url_externa,
                'publicada_en' => $this->publicada_en ?? now(),
                'fecha_cierre' => $this->fecha_cierre,
                'activo'       => $this->activo,
            ]);
        }

        // Refrescar tabla y cerrar modal
        $this->dispatch('oferta-added');
        $this->close();
        $this->js('window.location.reload()');
    }

    public function render()
    {
        return view('livewire.admin.laboral.oferta-form');
    }
}
