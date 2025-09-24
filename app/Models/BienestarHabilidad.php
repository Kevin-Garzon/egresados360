<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BienestarHabilidad extends Model
{
    protected $table = 'bienestar_habilidades';

    protected $fillable = [
        'titulo',
        'descripcion',
        'modalidad',
        'fecha_inicio',
        'fecha_fin',
        'duracion',
        'activo',
    ];

    protected $casts = [
        'fecha_inicio' => 'date',
        'fecha_fin' => 'date',
        'activo' => 'boolean',
    ];
}
