<?php

namespace App\Imports;

use App\Models\Empresa;
use App\Models\OfertaLaboral;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date as ExcelDate;

class OfertasLaboralesImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // ------------------------------
        // Validar empresa existente
        // ------------------------------
        $empresa = Empresa::where('nombre', trim($row['empresa']))->first();

        if (!$empresa) {
            session()->flash('error', "La empresa '{$row['empresa']}' no existe en la BD.");
            return null;
        }

        return new OfertaLaboral([
            'empresa_id'   => $empresa->id,
            'titulo'       => trim($row['titulo'] ?? ''),
            'descripcion'  => trim($row['descripcion'] ?? ''),
            'ubicacion'    => trim($row['ubicacion'] ?? ''),

            // Etiquetas en formato array (Laravel lo castea)
            'etiquetas'    => $this->parseEtiquetas($row['etiquetas'] ?? ''),

            'url_externa'  => trim($row['url_externa'] ?? ''),

            // Conversión correcta de fechas
            'publicada_en' => $this->parseFecha($row['publicada_en'] ?? null),
            'fecha_cierre' => $this->parseFecha($row['fecha_cierre'] ?? null),

            'flyer'        => trim($row['flyer'] ?? null),

            // Activo: 1 = true, 0 = false
            'activo'       => intval($row['activo'] ?? 0) === 1,
        ]);
    }

    // ------------------------------
    // Convertir etiquetas: "aux,admin" → ['aux', 'admin']
    // ------------------------------
    private function parseEtiquetas($valor)
    {
        if (!$valor) return [];

        $valor = str_replace(';', ',', $valor);
        $items = array_map('trim', explode(',', $valor));

        return array_filter($items, fn($e) => $e !== '');
    }

    // ------------------------------
    // Conversión universal de fechas
    // ------------------------------
    private function parseFecha($valor)
    {
        if (!$valor) return null;

        // 1. Si es serial Excel (número)
        if (is_numeric($valor)) {
            try {
                return Carbon::instance(ExcelDate::excelToDateTimeObject($valor));
            } catch (\Exception $e) {
                return null;
            }
        }

        $valor = trim($valor);

        // 2. Formato YYYY-MM-DD
        if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $valor)) {
            try {
                return Carbon::createFromFormat('Y-m-d', $valor);
            } catch (\Exception $e) {
                return null;
            }
        }

        // 3. Formato DD/MM/YYYY
        if (preg_match('/^\d{2}\/\d{2}\/\d{4}$/', $valor)) {
            try {
                return Carbon::createFromFormat('d/m/Y', $valor);
            } catch (\Exception $e) {
                return null;
            }
        }

        // 4. Último intento (Carbon autodetect)
        try {
            return Carbon::parse($valor);
        } catch (\Exception $e) {
            return null;
        }
    }
}


