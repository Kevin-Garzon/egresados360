<?php

namespace App\Livewire\Admin\Bienestar\habilidades;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use App\Models\BienestarHabilidad;
use Illuminate\Support\Carbon;

class HabilidadForm extends Component
{
    use WithFileUploads;

    public bool $isOpen = false;
    public bool $isEdit = false;

    public ?int $habilidad_id = null;
    public string $titulo = '';
    public ?string $descripcion = null;
    public ?string $tema = null;
    public ?string $modalidad = null;
    public ?string $fecha = null;
    public bool $activo = true;
    public $imagen;
    public ?string $existingImage = null;

    protected $listeners = [
        'open-create-habilidad' => 'openCreate',
        'open-edit-habilidad'   => 'openEdit',
    ];

    protected function rules(): array
    {
        return [
            'titulo' => ['required', 'string', 'max:150'],
            'descripcion' => ['nullable', 'string'],
            'tema' => ['nullable', 'string', 'max:100'],
            'modalidad' => ['nullable', 'string', 'max:50'],
            'fecha' => ['nullable', 'date'],
            'activo' => ['boolean'],
            'imagen' => ['nullable', 'image', 'max:2048'],
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
        $habilidad = BienestarHabilidad::findOrFail($id);

        $this->habilidad_id = $habilidad->id;
        $this->titulo = $habilidad->titulo;
        $this->descripcion = $habilidad->descripcion;
        $this->tema = $habilidad->tema;
        $this->modalidad = $habilidad->modalidad;
        $this->fecha = $habilidad->fecha ? Carbon::parse($habilidad->fecha)->format('Y-m-d') : null;
        $this->activo = $habilidad->activo;
        $this->existingImage = $habilidad->imagen;

        $this->isOpen = true;
        $this->isEdit = true;
    }

    public function save(): void
    {
        $this->validate();

        $data = [
            'titulo' => $this->titulo,
            'descripcion' => $this->descripcion,
            'tema' => $this->tema,
            'modalidad' => $this->modalidad,
            'fecha' => $this->fecha,
            'activo' => $this->activo,
        ];

        if ($this->imagen) {
            if ($this->isEdit && $this->existingImage && Storage::disk('public')->exists($this->existingImage)) {
                Storage::disk('public')->delete($this->existingImage);
            }

            $path = $this->imagen->store('habilidades', 'public');
            $data['imagen'] = $path;
        }

        if ($this->isEdit && $this->habilidad_id) {
            BienestarHabilidad::whereKey($this->habilidad_id)->update($data);
        } else {
            BienestarHabilidad::create($data);
        }

        $this->dispatch('habilidadSaved');
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
            'habilidad_id',
            'titulo',
            'descripcion',
            'tema',
            'modalidad',
            'fecha',
            'activo',
            'isOpen',
            'isEdit',
            'imagen',
            'existingImage',
        ]);
    }

    public function render()
    {
        return view('livewire.admin.bienestar.habilidades.habilidad-form');
    }
}
