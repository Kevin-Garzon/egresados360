<?php

namespace App\Livewire\Admin\Bienestar\Servicios;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\BienestarServicio;
use Illuminate\Support\Facades\Storage;

class ServicioForm extends Component
{
    use WithFileUploads;

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

    public $logo;
    public $pdf;
    public ?string $existingLogo = null;
    public ?string $existingPdf = null;

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

            'logo' => ['nullable', 'image', 'max:2048'],
            'pdf' => ['nullable', 'mimes:pdf', 'max:5120'],
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
        $this->existingLogo = $servicio->logo;
        $this->existingPdf = $servicio->pdf;


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

        // Manejo del logo
        if ($this->logo) {
            if ($this->isEdit && $this->existingLogo && Storage::disk('public')->exists($this->existingLogo)) {
                Storage::disk('public')->delete($this->existingLogo);
            }
            $pathLogo = $this->logo->store('servicios/logos', 'public');
            $data['logo'] = $pathLogo;
        }

        // Manejo del PDF
        if ($this->pdf) {
            if ($this->isEdit && $this->existingPdf && Storage::disk('public')->exists($this->existingPdf)) {
                Storage::disk('public')->delete($this->existingPdf);
            }
            $pathPdf = $this->pdf->store('servicios/pdf', 'public');
            $data['pdf'] = $pathPdf;
        }



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
            'logo',
            'pdf',
            'existingLogo',
            'existingPdf',
        ]);
    }

    public function render()
    {
        return view('livewire.admin.bienestar.servicios.servicio-form');
    }
}
