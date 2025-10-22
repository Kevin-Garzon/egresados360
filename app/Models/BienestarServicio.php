<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BienestarServicio extends Model
{
    protected $table = 'bienestar_servicios';

    protected $fillable = [
        'nombre',
        'descripcion',
        'tipo',
        'contacto',
        'ubicacion',
        'url',
        'logo',
        'pdf',
        'activo',
    ];

    protected $casts = [
        'activo' => 'boolean',
    ];
}
