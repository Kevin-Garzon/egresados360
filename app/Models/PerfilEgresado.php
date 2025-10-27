<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PerfilEgresado extends Model
{
    use HasFactory;

    protected $table = 'perfiles_egresado';

    protected $fillable = [
        'nombre',
        'correo',
        'celular',
        'programa',
        'anio_egreso',
    ];

    // Relación con interacciones
    public function interacciones()
    {
        return $this->hasMany(Interaccion::class, 'perfil_id');
    }
}
