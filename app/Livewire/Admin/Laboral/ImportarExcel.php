<?php

namespace App\Livewire\Admin\Laboral;

use Livewire\Component;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\OfertasLaboralesImport;

class ImportarExcel extends Component
{
    use WithFileUploads;

    public $open = false;
    public $archivo;

    protected $rules = [
        'archivo' => 'required|file|mimes:xls,xlsx|max:10240',
    ];

    public function updatedArchivo()
    {
        $this->validate();
    }

    public function importar()
    {
        $this->validate();

        try {
            Excel::import(new OfertasLaboralesImport, $this->archivo);

            session()->flash('status', 'Ofertas importadas correctamente.');
            $this->reset(['archivo', 'open']);

            $this->dispatch('excel-importado'); // refrescar tabla si deseas
        } catch (\Exception $e) {
            session()->flash('error', 'Error al importar: '.$e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.admin.laboral.importar-excel');
    }
}
