<?php

namespace App\Livewire\Admin\Laboral;

use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\Empresa;
use App\Models\OfertaLaboral;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;


class OfertaForm extends Component
{
    // 
    use WithFileUploads;
    public $flyer;
    public ?string $flyerNombre = null;


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
    public $existingFlyer = null;
    public ?string $ofertaFlyer = null;



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
        $this->existingFlyer = $oferta->flyer;
        $this->flyerNombre = $oferta->flyer ? basename($oferta->flyer) : null;


        $this->isOpen = true;
    }




    public function close()
    {
        $this->isOpen = false;
    }

    public function save()
    {
        $this->publicada_en = $this->publicada_en ?: null;
        $this->fecha_cierre = $this->fecha_cierre ?: null;

        $path = $this->existingFlyer; // mantiene el actual por defecto

        if ($this->flyer) {
            // si hay nuevo flyer, elimina el anterior y guarda el nuevo
            if ($this->existingFlyer && Storage::disk('public')->exists($this->existingFlyer)) {
                Storage::disk('public')->delete($this->existingFlyer);
            }

            $path = $this->flyer->store('flyers', 'public');
            $this->flyerNombre = basename($path);
        }


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
            'flyer'        => 'nullable|image|max:4096',
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
                    'flyer'        => $path,
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
                'flyer'        => $path,
            ]);
        }

        // Refrescar tabla, pag y cerrar modal
        $this->dispatch('oferta-added');
        $this->close();
        $this->js('window.location.reload()');
    }

    public function render()
    {
        return view('livewire.admin.laboral.oferta-form');
    }
}
