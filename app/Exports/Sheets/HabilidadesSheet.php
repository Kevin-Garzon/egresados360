<?php

namespace App\Exports\Sheets;

use App\Models\BienestarHabilidad;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Carbon\Carbon;

class HabilidadesSheet implements FromQuery, WithHeadings, ShouldAutoSize, WithMapping, WithStyles
{
    public function query()
    {
        // Solo habilidades activas
        return BienestarHabilidad::where('activo', true)
            ->select('titulo', 'tema', 'modalidad', 'fecha', 'created_at');
    }

    public function headings(): array
    {
        return [
            'Título',
            'Tema',
            'Modalidad',
            'Fecha de actividad',
            'Registrado en',
        ];
    }

    public function map($habilidad): array
    {
        return [
            $habilidad->titulo ?? '—',
            $habilidad->tema ?? '—',
            $habilidad->modalidad ?? '—',
            $habilidad->fecha
                ? Carbon::parse($habilidad->fecha)->setTimezone('America/Bogota')->format('Y-m-d')
                : '—',
            $habilidad->created_at
                ? Carbon::parse($habilidad->created_at)->setTimezone('America/Bogota')->format('Y-m-d H:i')
                : '',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Encabezado verde con texto blanco
        $sheet->getStyle('A1:E1')->applyFromArray([
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
            'fill' => ['fillType' => 'solid', 'color' => ['rgb' => '09B451']],
            'alignment' => ['horizontal' => 'center', 'vertical' => 'center'],
        ]);

        // Bordes finos
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
