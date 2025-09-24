<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Formacion extends Model
{
    protected $table = 'formaciones';

    protected $fillable = [
        'titulo',
        'descripcion',
        'entidad',
        'tipo',
        'programa',
        'modalidad',
        'costo',
        'fecha_inicio',
        'fecha_fin',
        'url_externa',
        'activo',
    ];

    protected $casts = [
        'fecha_inicio' => 'date',
        'fecha_fin' => 'date',
        'activo' => 'boolean',
    ];
}
