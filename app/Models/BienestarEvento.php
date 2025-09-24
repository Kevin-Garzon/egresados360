<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BienestarEvento extends Model
{
    protected $table = 'bienestar_eventos';

    protected $fillable = [
        'titulo',
        'descripcion',
        'modalidad',
        'ubicacion',
        'fecha_inicio',
        'fecha_fin',
        'hora_inicio',
        'activo',
    ];

    protected $casts = [
        'fecha_inicio' => 'date',
        'fecha_fin' => 'date',
        'hora_inicio' => 'datetime:H:i',
        'activo' => 'boolean',
    ];
}
