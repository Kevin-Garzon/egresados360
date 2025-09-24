<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Empresa;

class EmpresaSeeder extends Seeder
{
    public function run(): void
    {
        Empresa::create([
            'nombre' => 'Comfamiliar Huila',
            'sector' => 'Salud y Servicios',
            'descripcion' => 'Entidad aliada en programas de formación y empleabilidad.',
            'logo' => 'logos/comfamiliar.png', // lo llenaremos después con archivos reales
            'url' => 'https://www.comfamiliarhuila.com',
        ]);

        Empresa::create([
            'nombre' => 'SENA',
            'sector' => 'Educación',
            'descripcion' => 'Aliado estratégico en capacitación y certificación laboral.',
            'logo' => 'logos/sena.png',
            'url' => 'https://www.sena.edu.co',
        ]);

        Empresa::create([
            'nombre' => 'Cámara de Comercio de Neiva',
            'sector' => 'Empresarial',
            'descripcion' => 'Apoya iniciativas empresariales y de empleabilidad en la región.',
            'logo' => 'logos/ccneiva.png',
            'url' => 'https://www.ccneiva.org',
        ]);
    }
}
