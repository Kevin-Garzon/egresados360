<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\Exportable;

class DashboardMetricsExport implements WithMultipleSheets
{
    use Exportable;

    public function __construct()
    {
        // Optimización de memoria y tiempo para entorno de servidor
        ini_set('memory_limit', '512M');
        ini_set('max_execution_time', '120');
    }

    public function sheets(): array
    {
        return [
            new \App\Exports\Sheets\VisitasSheet(),
            new \App\Exports\Sheets\InteraccionesSheet(),
            new \App\Exports\Sheets\EgresadosSheet(),
        ];
    }
}
