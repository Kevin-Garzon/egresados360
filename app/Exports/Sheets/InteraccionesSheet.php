<?php

namespace App\Exports\Sheets;

use App\Models\Interaccion;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Carbon\Carbon;

class InteraccionesSheet implements 
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
        // Configuración para compatibilidad con Excel en español
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
        // Traemos las interacciones con los perfiles asociados
        return Interaccion::with('perfil:id,nombre,correo')
            ->select('module', 'action', 'item_type', 'item_title', 'perfil_id', 'created_at');
    }

    public function headings(): array
    {
        return [
            'Módulo',
            'Acción',
            'Tipo de ítem',
            'Título del ítem',
            'Perfil asociado',
            'Fecha de registro',
        ];
    }

    public function title(): string
    {
        return 'Interacciones';
    }

    public function chunkSize(): int
    {
        return 500;
    }

    // Mapeo y formateo de los datos
    public function map($interaccion): array
    {
        // 🔹 Fecha
        $fecha = '';
        if (!empty($interaccion->created_at)) {
            try {
                $fecha = Carbon::parse($interaccion->created_at)->format('Y-m-d H:i');
            } catch (\Exception $e) {
                $fecha = $interaccion->created_at;
            }
        }

        // Perfil asociado
        if ($interaccion->perfil) {
            $perfil = "{$interaccion->perfil->nombre} ({$interaccion->perfil->correo})";
        } else {
            $perfil = 'Anónimo';
        }

        return [
            ucfirst($interaccion->module),
            ucfirst($interaccion->action),
            ucfirst($interaccion->item_type ?? '—'),
            $interaccion->item_title ?? '—',
            $perfil,
            $fecha,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Encabezado visual
        $sheet->getStyle('A1:F1')->applyFromArray([
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
            'fill' => ['fillType' => 'solid', 'color' => ['rgb' => '09B451']],
            'alignment' => ['horizontal' => 'center', 'vertical' => 'center'],
        ]);

        // Bordes
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
