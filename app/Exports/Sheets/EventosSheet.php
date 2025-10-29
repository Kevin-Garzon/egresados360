<?php

namespace App\Exports\Sheets;

use App\Models\BienestarEvento;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Carbon\Carbon;

class EventosSheet implements FromQuery, WithHeadings, ShouldAutoSize, WithMapping, WithStyles
{
    public function query()
    {
        // Trae todos los eventos 
        return BienestarEvento::select('titulo', 'modalidad', 'ubicacion', 'fecha_inicio', 'fecha_fin', 'created_at');
    }

    public function headings(): array
    {
        return [
            'Título del evento',
            'Modalidad',
            'Ubicación',
            'Fecha de inicio',
            'Fecha de finalización',
            'Registrado en',
        ];
    }

    public function map($evento): array
    {
        return [
            $evento->titulo ?? '—',
            $evento->modalidad ?? '—',
            $evento->ubicacion ?? '—',
            $evento->fecha_inicio
                ? Carbon::parse($evento->fecha_inicio)->setTimezone('America/Bogota')->format('Y-m-d H:i')
                : '—',
            $evento->fecha_fin
                ? Carbon::parse($evento->fecha_fin)->setTimezone('America/Bogota')->format('Y-m-d H:i')
                : '—',
            $evento->created_at
                ? Carbon::parse($evento->created_at)->setTimezone('America/Bogota')->format('Y-m-d H:i')
                : '',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Encabezado verde institucional
        $sheet->getStyle('A1:F1')->applyFromArray([
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
            'fill' => ['fillType' => 'solid', 'color' => ['rgb' => '09B451']],
            'alignment' => ['horizontal' => 'center', 'vertical' => 'center'],
        ]);

        // Bordes suaves
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
