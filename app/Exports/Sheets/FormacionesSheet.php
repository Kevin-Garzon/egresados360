<?php

namespace App\Exports\Sheets;

use App\Models\Formacion;
use App\Models\Interaccion;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Carbon\Carbon;

class FormacionesSheet implements FromQuery, WithHeadings, ShouldAutoSize, WithMapping, WithStyles
{
    public function query()
    {
        // ✅ Solo formaciones activas
        return Formacion::where('activo', true)
            ->select('id', 'titulo', 'programa', 'modalidad', 'tipo', 'fecha_inicio', 'fecha_fin', 'costo', 'created_at');
    }

    public function headings(): array
    {
        return [
            'Título',
            'Programa académico',
            'Modalidad',
            'Tipo',
            'Inicio',
            'Fin',
            'Costo',
            'Interacciones',
            'Fecha de creación',
        ];
    }

    public function map($formacion): array
    {
        // ✅ Contar interacciones del módulo “formacion”
        $interacciones = Interaccion::where('module', 'formacion')
            ->where('item_id', $formacion->id)
            ->count();

        // ✅ Fechas formateadas
        $inicio = $formacion->fecha_inicio
            ? Carbon::parse($formacion->fecha_inicio)->format('Y-m-d')
            : '—';

        $fin = $formacion->fecha_fin
            ? Carbon::parse($formacion->fecha_fin)->format('Y-m-d')
            : '—';

        $creado = $formacion->created_at
            ? Carbon::parse($formacion->created_at)->setTimezone('America/Bogota')->format('Y-m-d H:i')
            : '';

        return [
            $formacion->titulo,
            $formacion->programa ?? '—',
            $formacion->modalidad ?? '—',
            $formacion->tipo ?? '—',
            $inicio,
            $fin,
            $formacion->costo ? '$' . number_format($formacion->costo, 0, ',', '.') : '—',
            $interacciones,
            $creado,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // ✅ Encabezado verde consistente con los demás
        $sheet->getStyle('A1:I1')->applyFromArray([
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
            'fill' => ['fillType' => 'solid', 'color' => ['rgb' => '09B451']],
            'alignment' => ['horizontal' => 'center', 'vertical' => 'center'],
        ]);

        // ✅ Bordes suaves
        $lastRow = $sheet->getHighestRow();
        $lastColumn = $sheet->getHighestColumn();
        $range = "A1:{$lastColumn}{$lastRow}";

        $sheet->getStyle($range)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['rgb' => 'DDDDDD'],
                ],
            ],
        ]);

        return [];
    }
}
