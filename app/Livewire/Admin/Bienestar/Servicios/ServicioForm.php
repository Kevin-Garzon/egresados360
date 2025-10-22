<?php

namespace App\Livewire\Admin\Bienestar\Servicios;

use Livewire\Component;
use App\Models\BienestarServicio;

class ServicioForm extends Component
{
    public bool $isOpen = false;
    public bool $isEdit = false;

    public ?int $servicio_id = null;
    public string $nombre = '';
    public ?string $descripcion = null;
    public ?string $tipo = null;
    public ?string $contacto = null;
    public ?string $ubicacion = null;
    public ?string $url = null;
    public bool $activo = true;

    protected $listeners = [
        'open-create-servicio' => 'openCreate',
        'open-edit-servicio' => 'openEdit',
    ];

    protected function rules(): array
    {
        return [
            'nombre' => ['required', 'string', 'max:150'],
            'descripcion' => ['nullable', 'string'],
            'tipo' => ['nullable', 'string', 'max:100'],
            'contacto' => ['nullable', 'string', 'max:100'],
            'ubicacion' => ['nullable', 'string', 'max:150'],
            'url' => ['nullable', 'url'],
            'activo' => ['boolean'],
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
        $servicio = BienestarServicio::findOrFail($id);

        $this->servicio_id = $servicio->id;
        $this->nombre = $servicio->nombre;
        $this->descripcion = $servicio->descripcion;
        $this->tipo = $servicio->tipo;
        $this->contacto = $servicio->contacto;
        $this->ubicacion = $servicio->ubicacion;
        $this->url = $servicio->url;
        $this->activo = $servicio->activo;

        $this->isOpen = true;
        $this->isEdit = true;
    }

    public function save(): void
    {
        $this->validate();

        $data = [
            'nombre' => $this->nombre,
            'descripcion' => $this->descripcion,
            'tipo' => $this->tipo,
            'contacto' => $this->contacto,
            'ubicacion' => $this->ubicacion,
            'url' => $this->url,
            'activo' => $this->activo,
        ];

        if ($this->isEdit && $this->servicio_id) {
            BienestarServicio::whereKey($this->servicio_id)->update($data);
        } else {
            BienestarServicio::create($data);
        }

        $this->dispatch('servicioSaved');
        $this->close();
    }

    public function close(): void
    {
        $this->isOpen = false;
    }

    private function resetForm(): void
    {
        $this->reset([
            'servicio_id',
            'nombre',
            'descripcion',
            'tipo',
            'contacto',
            'ubicacion',
            'url',
            'activo',
            'isOpen',
            'isEdit',
        ]);
    }

    public function render()
    {
        return view('livewire.admin.bienestar.servicios.servicio-form');
    }
}
