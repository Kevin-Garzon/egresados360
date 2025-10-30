<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BienestarMentoria extends Model
{
    protected $table = 'bienestar_mentorias';

    protected $fillable = [
        'titulo',
        'descripcion',
        'icono',
        'url',
        'activo',
    ];

    protected $casts = [
        'activo' => 'boolean',
    ];

    // Icono por defecto si viene null
    public function getIconoAttribute($value): string
    {
        return $value ?: 'fa-user-tie';
    }
}
