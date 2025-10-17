<?php

namespace App\Livewire\Admin\Formacion;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use App\Models\Formacion;
use Illuminate\Support\Carbon;


class FormacionForm extends Component
{
    use WithFileUploads;


    public bool $isOpen = false;
    public bool $isEdit = false;

    public ?int $formacion_id = null;

    public string $titulo = '';
    public ?string $descripcion = null;
    public ?string $entidad = null;
    public ?string $programa = null;
    public ?string $modalidad = null;
    public ?string $tipo = null;
    public ?float $costo = null;
    public ?string $duracion = null;
    public ?string $fecha_inicio = null;
    public ?string $fecha_fin = null;
    public ?string $url_externa = null;
    public bool $activo = true;
    public int $interacciones = 0;
    public $imagen; // Archivo temporal
    public ?string $existingImage = null; // Imagen existente


    protected $listeners = [
        'open-create-formacion' => 'openCreate',
        'open-edit-formacion'   => 'openEdit',
    ];

    protected function rules(): array
    {
        return [
            'titulo'        => ['required', 'string', 'max:150'],
            'descripcion'   => ['nullable', 'string'],
            'entidad'       => ['nullable', 'string', 'max:150'],
            'programa'      => ['required', 'string', 'max:100'],
            'modalidad'     => ['required', 'string', 'max:50'],
            'tipo'          => ['required', 'string', 'max:50'],
            'costo'         => ['nullable', 'numeric', 'min:0'],
            'duracion'      => ['nullable', 'string', 'max:50'],
            'fecha_inicio'  => ['nullable', 'date'],
            'fecha_fin'     => ['nullable', 'date', 'after_or_equal:fecha_inicio'],
            'url_externa'   => ['nullable', 'url'],
            'activo'        => ['boolean'],
            'interacciones' => ['integer', 'min:0'],
            'imagen'        => ['nullable', 'image', 'max:2048'],

        ];
    }

    public function openCreate(): void
    {
        $this->resetForm();
        $this->isOpen = true;
        $this->isEdit = false;
    }

    public function openEdit(int $id): void
    {
        $this->resetForm();

        $formacion = Formacion::findOrFail($id);

        $this->formacion_id  = $formacion->id;
        $this->titulo        = $formacion->titulo;
        $this->descripcion   = $formacion->descripcion;
        $this->entidad       = $formacion->entidad;
        $this->programa      = $formacion->programa;
        $this->modalidad     = $formacion->modalidad;
        $this->tipo          = $formacion->tipo;
        $this->costo         = $formacion->costo;
        $this->fecha_inicio  = $formacion->fecha_inicio ? Carbon::parse($formacion->fecha_inicio)->format('Y-m-d') : null;
        $this->fecha_fin     = $formacion->fecha_fin ? Carbon::parse($formacion->fecha_fin)->format('Y-m-d') : null;
        $this->url_externa   = $formacion->url_externa;
        $this->activo        = $formacion->activo;
        $this->interacciones = $formacion->interacciones ?? 0;
        $this->existingImage = $formacion->imagen;


        $this->isOpen = true;
        $this->isEdit = true;
    }

    public function save(): void
    {
        $this->validate();

        $data = [
            'titulo'        => $this->titulo,
            'descripcion'   => $this->descripcion,
            'entidad'       => $this->entidad,
            'programa'      => $this->programa,
            'modalidad'     => $this->modalidad,
            'tipo'          => $this->tipo,
            'costo'         => $this->costo,
            'duracion'      => $this->duracion,
            'fecha_inicio'  => $this->fecha_inicio,
            'fecha_fin'     => $this->fecha_fin,
            'url_externa'   => $this->url_externa,
            'activo'        => $this->activo,
            'interacciones' => $this->interacciones,
        ];

        // Manejo de imagen
        if ($this->imagen) {
            // Si existe imagen previa, la eliminamos
            if ($this->isEdit && $this->existingImage && Storage::disk('public')->exists($this->existingImage)) {
                Storage::disk('public')->delete($this->existingImage);
            }

            // Guardamos nueva imagen
            $path = $this->imagen->store('formaciones', 'public');
            $data['imagen'] = $path;
        }


        if ($this->isEdit && $this->formacion_id) {
            Formacion::whereKey($this->formacion_id)->update($data);
        } else {
            Formacion::create($data);
        }

        $this->dispatch('formacionSaved');
        $this->close();
        $this->js('window.scrollTo({ top: 0, behavior: "smooth" });');
    }

    public function close(): void
    {
        $this->isOpen = false;
    }

    private function resetForm(): void
    {
        $this->reset([
            'formacion_id',
            'titulo',
            'descripcion',
            'entidad',
            'programa',
            'modalidad',
            'tipo',
            'costo',
            'fecha_inicio',
            'fecha_fin',
            'url_externa',
            'activo',
            'interacciones',
            'isOpen',
            'isEdit',
            'imagen',
            'existingImage',
        ]);
    }

    public function render()
    {
        return view('livewire.admin.formacion.formacion-form');
    }
}
