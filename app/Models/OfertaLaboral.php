<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OfertaLaboral extends Model
{
    protected $table = 'ofertas_laborales';

    protected $fillable = [
        'titulo',
        'empresa',
        'descripcion',
        'ubicacion',
        'etiquetas',
        'url_externa',
        'publicada_en',
        'activo',
    ];

    protected $casts = [
        'publicada_en' => 'datetime',
        'activo' => 'boolean',
    ];
}
