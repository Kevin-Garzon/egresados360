<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\OfertaLaboral;

class OfertaLaboralSeeder extends Seeder
{
    public function run(): void
    {
        OfertaLaboral::create([
            'titulo' => 'Desarrollador Backend Junior',
            'empresa' => 'Tech Solutions S.A.S.',
            'descripcion' => 'Se busca desarrollador con conocimientos en PHP y MySQL.',
            'ubicacion' => 'Neiva, Huila',
            'etiquetas' => 'PHP, MySQL, Laravel, Junior',
            'url_externa' => 'https://empleos.com/techteam/backend-junior',
            'publicada_en' => now(),
            'activo' => true,
        ]);

        OfertaLaboral::create([
            'titulo' => 'Ingeniero de Software',
            'empresa' => 'Comfamiliar Huila',
            'descripcion' => 'Apoyo en el desarrollo de aplicaciones internas.',
            'ubicacion' => 'Remoto',
            'etiquetas' => 'Remoto, Tiempo completo',
            'url_externa' => 'https://empleos.com/comfamiliar/ingeniero-software',
            'publicada_en' => now(),
            'activo' => true,
        ]);
    }
}
