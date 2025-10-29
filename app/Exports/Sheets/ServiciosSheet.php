<?php

namespace App\Exports\Sheets;

use App\Models\BienestarServicio;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Carbon\Carbon;

class ServiciosSheet implements FromQuery, WithHeadings, ShouldAutoSize, WithMapping, WithStyles
{
    public function query()
    {
        // Solo servicios activos
        return BienestarServicio::where('activo', true)
            ->select('nombre', 'tipo', 'contacto', 'ubicacion', 'url', 'created_at');
    }

    public function headings(): array
    {
        return [
            'Nombre del servicio',
            'Tipo',
            'Contacto',
            'Ubicación',
            'Enlace o URL',
            'Registrado en',
        ];
    }

    public function map($servicio): array
    {
        return [
            $servicio->nombre ?? '—',
            $servicio->tipo ?? '—',
            $servicio->contacto ?? '—',
            $servicio->ubicacion ?? '—',
            $servicio->url ?? '—',
            $servicio->created_at
                ? Carbon::parse($servicio->created_at)->setTimezone('America/Bogota')->format('Y-m-d H:i')
                : '',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Encabezado verde y texto blanco
        $sheet->getStyle('A1:F1')->applyFromArray([
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
            'fill' => ['fillType' => 'solid', 'color' => ['rgb' => '09B451']],
            'alignment' => ['horizontal' => 'center', 'vertical' => 'center'],
        ]);

        // Bordes ligeros
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
