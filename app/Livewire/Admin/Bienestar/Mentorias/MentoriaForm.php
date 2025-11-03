<?php

namespace App\Livewire\Admin\Bienestar\Mentorias;

use Livewire\Component;
use App\Models\BienestarMentoria;

class MentoriaForm extends Component
{
    public bool $isOpen = false;
    public bool $isEdit = false;

    public ?int $mentoria_id = null;
    public string $titulo = '';
    public ?string $descripcion = null;
    public ?string $icono = null;
    public bool $activo = true;

    protected $listeners = [
        'open-create-mentoria' => 'openCreate',
        'open-edit-mentoria'   => 'openEdit',
    ];

    protected function rules(): array
    {
        return [
            'titulo' => ['required', 'string', 'max:100'],
            'descripcion' => ['nullable', 'string', 'max:200'],
            'icono' => ['required', 'string', 'max:100'],
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
        $mentoria = BienestarMentoria::findOrFail($id);

        $this->mentoria_id = $mentoria->id;
        $this->titulo = $mentoria->titulo;
        $this->descripcion = $mentoria->descripcion;
        $this->icono = $mentoria->icono;
        $this->activo = $mentoria->activo;

        $this->isOpen = true;
        $this->isEdit = true;
    }

    public function save(): void
    {
        $this->validate();

        $data = [
            'titulo' => $this->titulo,
            'descripcion' => $this->descripcion,
            'icono' => $this->icono,
            'activo' => $this->activo,
        ];

        if ($this->isEdit && $this->mentoria_id) {
            BienestarMentoria::findOrFail($this->mentoria_id)->update($data);
        } else {
            BienestarMentoria::create($data);
        }

        $this->dispatch('mentoriaSaved');
        $this->close();
    }

    public function close(): void
    {
        $this->isOpen = false;
    }

    private function resetForm(): void
    {
        $this->reset([
            'mentoria_id',
            'titulo',
            'descripcion',
            'icono',
            'activo',
            'isOpen',
            'isEdit',
        ]);
    }

    public function render()
    {
        return view('livewire.admin.bienestar.mentorias.mentoria-form');
    }
}
