<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VisitaDiaria extends Model
{
    use HasFactory;

    protected $table = 'visitas_diarias';

    protected $fillable = [
        'fecha',
        'total',
    ];

    public $timestamps = true;

    // Método auxiliar para incrementar visitas del día
    public static function registrarVisita()
    {
        $hoy = now()->toDateString();

        $registro = self::firstOrCreate(['fecha' => $hoy]);
        $registro->increment('total');
    }
}
