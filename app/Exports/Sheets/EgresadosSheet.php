<?php

namespace App\Exports\Sheets;

use App\Models\PerfilEgresado;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Carbon\Carbon;

class EgresadosSheet implements 
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
        // Configurar exportación CSV para compatibilidad con Excel en español
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
        return PerfilEgresado::select('nombre', 'correo', 'celular', 'programa', 'anio_egreso', 'created_at');
    }

    public function headings(): array
    {
        return [
            'Nombre completo',
            'Correo electrónico',
            'Celular',
            'Programa académico',
            'Año de egreso',
            'Registrado en',
        ];
    }

    public function title(): string
    {
        return 'Egresados';
    }

    public function chunkSize(): int
    {
        return 500;
    }

    // Aquí corregimos la fecha para que se vea limpia
    public function map($perfil): array
    {
        $fecha = '';

        if (!empty($perfil->created_at)) {
            try {
                $fecha = Carbon::parse($perfil->created_at)->format('Y-m-d H:i');
            } catch (\Exception $e) {
                $fecha = $perfil->created_at; // fallback por si no se puede parsear
            }
        }

        return [
            $perfil->nombre,
            $perfil->correo,
            $perfil->celular,
            $perfil->programa,
            $perfil->anio_egreso,
            $fecha,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Aplica estilo solo al encabezado
        $sheet->getStyle('A1:F1')->applyFromArray([
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
            'fill' => ['fillType' => 'solid', 'color' => ['rgb' => '09B451']],
            'alignment' => ['horizontal' => 'center', 'vertical' => 'center'],
        ]);

        // Determina el rango ocupado realmente
        $lastRow = $sheet->getHighestRow();
        $lastColumn = $sheet->getHighestColumn();
        $usedRange = "A1:{$lastColumn}{$lastRow}";

        // Bordes solo para el rango ocupado
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
