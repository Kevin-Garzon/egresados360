<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\VisitaDiaria;

class MetricsController extends Controller
{
    public function registrarVisita()
    {
        VisitaDiaria::registrarVisita();

        return response()->json(['success' => true]);
    }
}
