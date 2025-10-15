<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    protected $table = 'empresas';

    protected $fillable = [
        'nombre',
        'sector',
        'descripcion',
        'logo',
        'url',
    ];

    public function ofertas()
{
    return $this->hasMany(\App\Models\OfertaLaboral::class, 'empresa_id');
}
}


