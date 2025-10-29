<?php

namespace App\Exports\Sheets;

use App\Models\Empresa;
use App\Models\OfertaLaboral;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Carbon\Carbon;

class EmpresasSheet implements FromQuery, WithHeadings, ShouldAutoSize, WithMapping, WithStyles
{
    public function query()
    {
        return Empresa::orderBy('nombre', 'asc')
            ->select('id', 'nombre', 'sector', 'url', 'created_at');
    }

    public function headings(): array
    {
        return [
            'Nombre de la empresa',
            'Sector económico',
            'Sitio web',
            'Ofertas totales',
            'Ofertas activas',
            'Registrada en',
        ];
    }

    public function map($empresa): array
    {
        // ✅ Contar ofertas de esta empresa
        $totalOfertas = OfertaLaboral::where('empresa_id', $empresa->id)->count();
        $activas = OfertaLaboral::where('empresa_id', $empresa->id)->where('activo', true)->count();

        // ✅ Formatear fecha
        $fecha = $empresa->created_at
            ? Carbon::parse($empresa->created_at)->setTimezone('America/Bogota')->format('Y-m-d H:i')
            : '';

        // ✅ Devolver fila formateada
        return [
            $empresa->nombre,
            $empresa->sector ?? '—',
            $empresa->url ?? '—',
            $totalOfertas,
            $activas,
            $fecha,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // ✅ Encabezado con fondo verde y texto blanco
        $sheet->getStyle('A1:F1')->applyFromArray([
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
