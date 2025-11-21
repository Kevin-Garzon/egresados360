<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Formacion extends Model
{
    protected $table = 'formaciones';

    protected $fillable = [
        'empresa_id',
        'titulo',
        'descripcion',
        'tipo',
        'programa',
        'modalidad',
        'costo',
        'duracion',
        'fecha_inicio',
        'fecha_fin',
        'url_externa',
        'activo',
        'imagen',
    ];

    protected $casts = [
        'fecha_inicio' => 'date',
        'fecha_fin' => 'date',
        'activo' => 'boolean',
    ];

    public function empresa()
    {
        return $this->belongsTo(Empresa::class);
    }
}
