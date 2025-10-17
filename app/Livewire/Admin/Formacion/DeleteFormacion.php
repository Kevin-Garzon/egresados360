<?php

namespace App\Livewire\Admin\Formacion;

use Livewire\Component;
use App\Models\Formacion;

class DeleteFormacion extends Component
{
    public bool $isOpen = false;
    public ?int $formacion_id = null;
    public ?string $titulo = null;

    protected $listeners = [
        'confirm-delete-formacion' => 'open',
    ];

    public function open(int $id): void
    {
        $formacion = Formacion::find($id);
        if ($formacion) {
            $this->formacion_id = $formacion->id;
            $this->titulo = $formacion->titulo;
            $this->isOpen = true;
        }
    }

    public function close(): void
    {
        $this->reset(['isOpen', 'formacion_id', 'titulo']);
    }

    public function delete(): void
    {
        if ($this->formacion_id) {
            Formacion::whereKey($this->formacion_id)->delete();
            $this->dispatch('formacionSaved'); 
            $this->close();
        }
    }

    public function render()
    {
        return view('livewire.admin.formacion.delete-formacion');
    }
}
