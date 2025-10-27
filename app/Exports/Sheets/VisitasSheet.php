<?php

namespace App\Exports\Sheets;

use App\Models\VisitaDiaria;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Carbon\Carbon;

class VisitasSheet implements 
    FromQuery, 
    WithHeadings, 
    WithTitle, 
    ShouldAutoSize, 
    WithStyles, 
    WithMapping, 
    WithChunkReading
{
    public function __construct()
    {
        // ✅ Configuración para compatibilidad con Excel en español
        config([
            'excel.exports.csv.delimiter' => ';',
            'excel.exports.csv.enclosure' => '"',
            'excel.exports.csv.use_bom' => true,
            'excel.exports.csv.line_ending' => "\r\n",
            'excel.exports.encoding' => 'UTF-8',
        ]);
    }

    public function query()
    {
        return VisitaDiaria::select('fecha', 'total', 'created_at', 'updated_at');
    }

    public function headings(): array
    {
        return [
            'Fecha',
            'Total de visitas',
            'Creado en',
            'Actualizado en',
        ];
    }

    public function title(): string
    {
        return 'Visitas Diarias';
    }

    public function chunkSize(): int
    {
        return 500;
    }

    // ✅ Formateo de fechas limpio
    public function map($visita): array
    {
        $creado = '';
        $actualizado = '';

        if (!empty($visita->created_at)) {
            try {
                $creado = Carbon::parse($visita->created_at)->format('Y-m-d H:i');
            } catch (\Exception $e) {
                $creado = $visita->created_at;
            }
        }

        if (!empty($visita->updated_at)) {
            try {
                $actualizado = Carbon::parse($visita->updated_at)->format('Y-m-d H:i');
            } catch (\Exception $e) {
                $actualizado = $visita->updated_at;
            }
        }

        return [
            $visita->fecha ? Carbon::parse($visita->fecha)->format('Y-m-d') : '',
            $visita->total,
            $creado,
            $actualizado,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // 🔹 Encabezado verde con texto blanco
        $sheet->getStyle('A1:D1')->applyFromArray([
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
            'fill' => ['fillType' => 'solid', 'color' => ['rgb' => '09B451']],
            'alignment' => ['horizontal' => 'center', 'vertical' => 'center'],
        ]);

        // 🔹 Bordes para el rango usado
        $lastRow = $sheet->getHighestRow();
        $lastColumn = $sheet->getHighestColumn();
        $usedRange = "A1:{$lastColumn}{$lastRow}";

        $sheet->getStyle($usedRange)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['rgb' => 'DDDDDD']
                ]
            ]
        ]);

        return [];
    }
}
