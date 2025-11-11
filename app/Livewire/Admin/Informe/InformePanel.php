<?php

namespace App\Livewire\Admin\Informe;

use Livewire\Component;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\InformeInteligenteController;
use Illuminate\Support\Str;

class InformePanel extends Component
{
    public $informe = null;
    public $generando = false;
    public $periodo = 'general'; // Filtro de periodo

    public function generarInforme()
    {
        $this->generando = true;

        try {
            $controller = new InformeInteligenteController();

            // Enviar periodo como parámetro
            $request = request()->merge(['periodo' => $this->periodo]);
            $response = $controller->generar($request);

            $data = $response->getData(true);

            // Convertimos el Markdown a HTML para mostrarlo en el panel
            $this->informe = isset($data['informe'])
                ? Str::markdown($data['informe'])
                : 'No se pudo generar el informe.';
        } catch (\Exception $e) {
            $this->informe = 'Error generando informe: ' . $e->getMessage();
        }

        $this->generando = false;
    }

    public function descargarPDF()
    {
        if (!$this->informe) return;

        // Usamos directamente el contenido HTML ya procesado
        $contenido = html_entity_decode($this->informe);

        $pdf = Pdf::loadView('pdf.informe-inteligente', [
            'contenido' => $contenido,
            'fecha' => now()->format('d/m/Y H:i'),
        ]);

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->output();
        }, 'informe_inteligente_' . now()->format('Ymd_His') . '.pdf');
    }

    public function render()
    {
        return view('livewire.admin.informe.informe-panel')
            ->extends('layouts.admin')
            ->section('content');
    }
}
