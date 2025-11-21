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

    // Tipo de informe seleccionado
    // institucional, comparativo, predictivo, modulo, express
    public $tipoInforme = 'institucional';

    // Periodo (para institucional, por módulo, express)
    // dia, semana, mes, general
    public $periodo = 'general';

    // Tipo de comparación (solo para comparativos)
    // mes_vs_mes_anterior, semana_vs_semana_anterior, dia_vs_dia_semana_pasada
    public $comparativo = 'mes_vs_mes_anterior';

    // Módulo específico (solo para informes por módulo)
    // laboral, formacion, bienestar
    public $modulo = 'laboral';

    // Reset de campos cuando cambia el tipo de informe
    public function updatedTipoInforme()
    {
        // Reset campos dependientes
        $this->periodo = 'general';
        $this->comparativo = 'mes_vs_mes_anterior';
        $this->modulo = 'laboral';
        
        // Limpiar informe anterior si existe
        $this->informe = null;
    }

    public function generarInforme()
    {
        $this->generando = true;

        try {
            $controller = new InformeInteligenteController();

            // Enviar parámetros al controlador
            $request = request();
            $request->merge([
                'tipo_informe' => $this->tipoInforme,
                'periodo'      => $this->periodo,
                'comparativo'  => $this->comparativo,
                'modulo'       => $this->modulo,
            ]);

            $response = $controller->generar($request);
            $data = $response->getData(true);

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

        $contenido = html_entity_decode($this->informe);

        $pdf = Pdf::loadView('pdf.informe-inteligente', [
            'contenido' => $contenido,
            'fecha'     => now()->format('d/m/Y H:i'),
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
