<?php

namespace App\Exports\Sheets;

use App\Models\OfertaLaboral;
use App\Models\Interaccion;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Carbon\Carbon;

class OfertasSheet implements FromQuery, WithHeadings, ShouldAutoSize, WithMapping, WithStyles
{
    public function query()
    {
        // ✅ Solo ofertas activas, sin seleccionar la columna interacciones (ya no existe)
        return OfertaLaboral::with('empresa')
            ->where('activo', true)
            ->select('id', 'titulo', 'empresa_id', 'ubicacion', 'created_at');
    }

    public function headings(): array
    {
        return [
            'Título',
            'Empresa',
            'Ubicación',
            'Interacciones',
            'Fecha de creación',
        ];
    }

    public function map($oferta): array
    {
        // ✅ Contar interacciones dinámicamente
        $interacciones = Interaccion::where('module', 'laboral')
            ->where('item_id', $oferta->id)
            ->count();

        // ✅ Formatear fecha
        $fecha = $oferta->created_at
            ? Carbon::parse($oferta->created_at)->setTimezone('America/Bogota')->format('Y-m-d H:i')
            : '';

        return [
            $oferta->titulo,
            optional($oferta->empresa)->nombre ?? '—',
            $oferta->ubicacion ?? '—',
            $interacciones,
            $fecha,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // ✅ Encabezado visual consistente
        $sheet->getStyle('A1:E1')->applyFromArray([
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
