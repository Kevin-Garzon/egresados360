<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class BienestarEvento extends Model
{
    protected $table = 'bienestar_eventos';

    protected $fillable = [
        'titulo',
        'descripcion',
        'tipo',
        'modalidad',
        'ubicacion',
        'imagen',
        'enlace',
        'fecha_inicio',
        'fecha_fin',
        'hora_inicio',
        'activo',
    ];

    protected $casts = [
        'fecha_inicio' => 'date',
        'fecha_fin'    => 'date',
        'activo'       => 'boolean',
    ];

    // ===============================
    // NORMALIZACIÓN DE ESTADO 
    // ===============================
    public function getTipoSlugAttribute(): string
    {
        // Siempre calcular dinámicamente según las fechas
        return $this->derivarEstadoPorFechas();
    }



    // ======================================
    // CÁLCULO DE ESTADO SEGÚN FECHAS
    // ======================================
    private function derivarEstadoPorFechas(): string
    {
        $hoy = Carbon::today();
        $inicio = $this->fecha_inicio ? Carbon::parse($this->fecha_inicio) : null;
        $fin    = $this->fecha_fin ? Carbon::parse($this->fecha_fin) : null;

        if ($inicio && $fin) {
            if ($hoy->lt($inicio)) return 'proximo';
            if ($hoy->between($inicio, $fin)) return 'encurso';
            if ($hoy->gt($fin)) return 'finalizado';
        }

        if ($inicio && !$fin) {
            return $hoy->lt($inicio) ? 'proximo' : 'encurso';
        }

        if (!$inicio && $fin) {
            return $hoy->gt($fin) ? 'finalizado' : 'encurso';
        }

        // Sin fechas → se asume activo
        return 'encurso';
    }


    // ======================================
    // ETIQUETA AMIGABLE PARA MOSTRAR EN LA VISTA
    // ======================================
    public function getTipoLabelAttribute(): string
    {
        return match ($this->tipo_slug) {
            'proximo'    => 'Próximo',
            'encurso'    => 'En curso',
            'finalizado' => 'Finalizado',
            default      => '—',
        };
    }


    // ======================================
    // URL pública de la imagen (si existe)
    // ======================================
    public function getImagenUrlAttribute(): ?string
    {
        return $this->imagen ? asset('storage/' . $this->imagen) : null;
    }
}
