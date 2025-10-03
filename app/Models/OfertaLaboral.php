<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OfertaLaboral extends Model
{
    protected $table = 'ofertas_laborales';

    protected $fillable = [
        'titulo',
        'empresa_id',
        'descripcion',
        'ubicacion',
        'etiquetas',
        'url_externa',
        'publicada_en',
        'fecha_cierre',
        'activo',
    ];

    protected $casts = [
        'publicada_en' => 'datetime',
        'fecha_cierre' => 'datetime',
        'activo' => 'boolean',
        'etiquetas' => 'array', // para que Laravel lo maneje como array
    ];

    // Relación con empresa
    public function empresa()
    {
        return $this->belongsTo(Empresa::class);
    }
}
