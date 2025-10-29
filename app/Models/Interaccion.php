<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Interaccion extends Model
{
    use HasFactory;

    protected $table = 'interacciones';

    protected $fillable = [
        'module',
        'action',
        'item_type',
        'item_id',
        'item_title',
        'perfil_id',
        'is_anonymous',
        'ip',
        'user_agent',
    ];

    // Relación con perfil (opcional)
    public function perfil()
    {
        return $this->belongsTo(PerfilEgresado::class, 'perfil_id');
    }
}
