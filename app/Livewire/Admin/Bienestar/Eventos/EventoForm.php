<?php

namespace App\Livewire\Admin\Bienestar\Eventos;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\BienestarEvento;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class EventoForm extends Component
{
    use WithFileUploads;

    public bool $isOpen = false;
    public bool $isEdit = false;

    public ?int $evento_id = null;
    public string $titulo = '';
    public ?string $descripcion = null;
    public ?string $modalidad = null;
    public ?string $ubicacion = null;
    public ?string $fecha_inicio = null;
    public ?string $fecha_fin = null;
    public ?string $hora_inicio = null;
    public bool $activo = true;

    public $imagen;
    public ?string $existingImage = null;

    protected $listeners = [
        'open-create-evento' => 'openCreate',
        'open-edit-evento'   => 'openEdit',
    ];

    protected function rules(): array
    {
        return [
            'titulo'       => ['required', 'string', 'max:150'],
            'descripcion'  => ['nullable', 'string'],
            'modalidad'    => ['nullable', 'string', 'max:50'],
            'ubicacion'    => ['nullable', 'string', 'max:150'],
            'fecha_inicio' => ['nullable', 'date'],
            'fecha_fin'    => ['nullable', 'date', 'after_or_equal:fecha_inicio'],
            'hora_inicio'  => ['nullable', 'date_format:H:i'],
            'imagen'       => ['nullable', 'image', 'max:2048'],
            'activo'       => ['boolean'],
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
        $evento = BienestarEvento::findOrFail($id);

        $this->evento_id    = $evento->id;
        $this->titulo       = $evento->titulo;
        $this->descripcion  = $evento->descripcion;
        $this->modalidad    = $evento->modalidad;
        $this->ubicacion    = $evento->ubicacion;
        $this->fecha_inicio = $evento->fecha_inicio?->format('Y-m-d');
        $this->fecha_fin    = $evento->fecha_fin?->format('Y-m-d');
        $this->hora_inicio  = $evento->hora_inicio
            ? substr((string)$evento->hora_inicio, 0, 5)
            : null;
        $this->activo       = $evento->activo;
        $this->existingImage = $evento->imagen;

        $this->isOpen = true;
        $this->isEdit = true;
    }

    public function save(): void
    {
        // Normalizar hora
        if (is_string($this->hora_inicio) && preg_match('/^\d{2}:\d{2}:\d{2}$/', $this->hora_inicio)) {
            $this->hora_inicio = substr($this->hora_inicio, 0, 5);
        }
        if ($this->hora_inicio === '') {
            $this->hora_inicio = null;
        }

        $this->validate();

        // Determinar tipo automáticamente
        /* $tipo = null;
        if ($this->fecha_inicio) {
            $hoy = Carbon::today();
            $inicio = Carbon::parse($this->fecha_inicio);
            $fin = $this->fecha_fin ? Carbon::parse($this->fecha_fin) : null;

            if ($inicio->isFuture()) {
                $tipo = 'Próximo';
            } elseif ($inicio->isToday() || ($fin && $hoy->between($inicio, $fin))) {
                $tipo = 'En curso';
            } elseif ($fin && $fin->isPast()) {
                $tipo = 'Finalizado';
            } else {
                $tipo = 'Finalizado';
            }
        } */

        $data = [
            'titulo'       => $this->titulo,
            'descripcion'  => $this->descripcion,
            'modalidad'    => $this->modalidad,
            'ubicacion'    => $this->ubicacion,
            'fecha_inicio' => $this->fecha_inicio,
            'fecha_fin'    => $this->fecha_fin,
            'hora_inicio'  => $this->hora_inicio,
            /* 'tipo'         => $tipo,  */
            'activo'       => $this->activo,
        ];

        // Subir o reemplazar imagen
        if ($this->imagen) {
            if ($this->isEdit && $this->existingImage && Storage::disk('public')->exists($this->existingImage)) {
                Storage::disk('public')->delete($this->existingImage);
            }
            $path = $this->imagen->store('eventos/imagenes', 'public');
            $data['imagen'] = $path;
        }

        if ($this->isEdit && $this->evento_id) {
            BienestarEvento::findOrFail($this->evento_id)->update($data);
        } else {
            BienestarEvento::create($data);
        }

        $this->dispatch('eventoSaved');
        $this->close();
    }

    public function close(): void
    {
        $this->isOpen = false;
    }

    private function resetForm(): void
    {
        $this->reset([
            'evento_id',
            'titulo',
            'descripcion',
            'modalidad',
            'ubicacion',
            'fecha_inicio',
            'fecha_fin',
            'hora_inicio',
            'activo',
            'imagen',
            'existingImage',
            'isOpen',
            'isEdit',
        ]);
    }

    public function render()
    {
        return view('livewire.admin.bienestar.eventos.evento-form');
    }
}
