<?php

namespace App\Livewire\Admin\Laboral;

use Livewire\Component;
use App\Models\Empresa;

class DeleteEmpresa extends Component
{
    public bool $isOpen = false;
    public ?int $empresa_id = null;
    public ?string $nombre = null;

    protected $listeners = [
        'open-delete-empresa' => 'open',
    ];

    public function open(int $id): void
    {
        $empresa = Empresa::find($id);

        if ($empresa) {
            $this->empresa_id = $empresa->id;
            $this->nombre = $empresa->nombre;
            $this->isOpen = true;
        }
    }

    public function close(): void
    {
        $this->reset(['isOpen', 'empresa_id', 'nombre']);
    }

    public function delete(): void
    {
        if ($this->empresa_id) {
            Empresa::whereKey($this->empresa_id)->delete();
            $this->dispatch('empresaDeleted'); // refresca tabla
        }

        $this->close();
        $this->js('window.location.reload()');
    }

    public function render()
    {
        return view('livewire.admin.laboral.delete-empresa');
    }
}
