<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

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

    // Estado calculado: 'proximo', 'en_curso', 'finalizado'
    public function getEstadoAttribute(): string
    {
        $hoy = Carbon::today();

        $inicio = $this->fecha_inicio ? Carbon::parse($this->fecha_inicio) : null;
        $fin    = $this->fecha_fin ? Carbon::parse($this->fecha_fin) : null;

        if ($inicio && $inicio->isFuture()) {
            return 'proximo';
        }

        if ($inicio && $fin) {
            if ($hoy->between($inicio, $fin)) {
                return 'en_curso';
            }
            if ($fin->isPast()) {
                return 'finalizado';
            }
        }

        if ($inicio && !$fin) {
            return $inicio->isPast() ? 'finalizado' : 'proximo';
        }

        return 'proximo';
    }

    // URL pública de la imagen (si existe)
    public function getImagenUrlAttribute(): ?string
    {
        return $this->imagen ? asset('storage/'.$this->imagen) : null;
    }
}
