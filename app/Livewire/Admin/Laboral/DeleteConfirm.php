<?php

namespace App\Livewire\Admin\Laboral;

use Livewire\Component;
use App\Models\OfertaLaboral;
use Livewire\Attributes\On;

class DeleteConfirm extends Component
{
    public bool $isOpen = false;
    public ?int $ofertaId = null;
    public ?string $titulo = null;

    #[On('open-delete-confirm')]
    public function open($id)
    {
        $oferta = OfertaLaboral::find($id);
        if ($oferta) {
            $this->ofertaId = $id;
            $this->titulo = $oferta->titulo;
            $this->isOpen = true;
        }
    }


    public function close()
    {
        $this->reset(['isOpen', 'ofertaId', 'titulo']);
    }

    public function delete()
    {
        if ($this->ofertaId) {
            OfertaLaboral::where('id', $this->ofertaId)->delete();
            $this->dispatch('oferta-added'); // refrescar tabla
        }

        $this->close();
        $this->js('window.location.reload()');
    }

    public function render()
    {
        return view('livewire.admin.laboral.delete-confirm');
    }
}
