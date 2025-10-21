<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BienestarHabilidad extends Model
{
    protected $table = 'bienestar_habilidades';

    protected $fillable = [
        'titulo',
        'descripcion',
        'tema',
        'modalidad',
        'fecha',
        'enlace_inscripcion',
        'imagen',
        'activo',
    ];

    protected $casts = [
        'fecha'  => 'date',
        'activo' => 'boolean',
    ];

    public function scopeActivas($query)
    {
        return $query->where('activo', true)
            ->orderByDesc('fecha');
    }
}
