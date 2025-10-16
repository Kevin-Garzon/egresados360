<?php

namespace App\Livewire\Admin\Laboral;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Empresa;
use Illuminate\Support\Facades\Storage;

class EmpresaForm extends Component
{
    use WithFileUploads;

    public bool $isOpen = false;
    public bool $isEdit = false;

    public ?int $empresa_id = null;

    // Campos
    public string $nombre = '';
    public ?string $sector = null;
    public ?string $descripcion = null;
    public ?string $url = null;
    public $logo = null; // file upload

    // Nuevo: logo existente
    public ?string $existingLogo = null;

    protected $listeners = [
        'open-create-empresa' => 'openCreate',
        'open-edit-empresa'   => 'openEdit',
    ];

    protected function rules(): array
    {
        return [
            'nombre'      => ['required', 'string', 'max:255'],
            'sector'      => ['nullable', 'string', 'max:255'],
            'descripcion' => ['nullable', 'string', 'max:1000'],
            'url'         => ['nullable', 'url', 'max:255'],
            /* 'logo'        => ['nullable', 'image', 'max:2048'], */
            'logo'        => ['nullable', 'mimes:jpg,jpeg,png,webp,avif', 'max:2048'],
        ];
    }

    public function openCreate(): void
    {
        $this->resetForm();
        $this->logo = null; 
        $this->isOpen = true;
        $this->isEdit = false;
    }

    public function openEdit(int $id): void
    {
        $this->resetForm();
        $this->logo = null; 

        $empresa = Empresa::findOrFail($id);
        $this->empresa_id  = $empresa->id;
        $this->nombre      = $empresa->nombre ?? '';
        $this->sector      = $empresa->sector;
        $this->descripcion = $empresa->descripcion;
        $this->url         = $empresa->url ?? null;

        // 🔹 Guardar logo actual (si hay)
        $this->existingLogo = $empresa->logo;

        $this->isOpen = true;
        $this->isEdit = true;
    }

    public function save(): void
    {
        $this->validate();

        $data = [
            'nombre'      => $this->nombre,
            'sector'      => $this->sector,
            'descripcion' => $this->descripcion,
            'url'         => $this->url,
        ];

        // Subida y reemplazo de logo
        if ($this->logo) {
            // Eliminar logo anterior si existe
            if ($this->existingLogo && Storage::disk('public')->exists($this->existingLogo)) {
                Storage::disk('public')->delete($this->existingLogo);
            }

            // Guardar nuevo
            $path = $this->logo->store('empresas', 'public');
            $data['logo'] = $path;
        }

        if ($this->isEdit && $this->empresa_id) {
            Empresa::whereKey($this->empresa_id)->update($data);
        } else {
            $empresa = Empresa::create($data);
            $this->empresa_id = $empresa->id;
        }

        $this->dispatch('empresaSaved');
        $this->close();
        $this->js('window.location.reload()');
    }

    public function close(): void
    {
        $this->isOpen = false;
    }

    private function resetForm(): void
    {
        $this->reset([
            'empresa_id', 'nombre', 'sector', 'descripcion', 'url', 'logo', 'existingLogo',
            'isOpen', 'isEdit',
        ]);
    }

    public function render()
    {
        return view('livewire.admin.laboral.empresa-form');
    }
}
