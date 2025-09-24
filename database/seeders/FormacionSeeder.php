<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Formacion;

class FormacionSeeder extends Seeder
{
    public function run(): void
    {
        Formacion::create([
            'titulo' => 'Diplomado en Desarrollo Web con Laravel',
            'descripcion' => 'Formación avanzada en desarrollo de aplicaciones web usando Laravel y MySQL.',
            'entidad' => 'FET',
            'tipo' => 'Diplomado',
            'programa' => 'Ingeniería de Software',
            'modalidad' => 'Virtual',
            'costo' => 0,
            'fecha_inicio' => '2025-10-15',
            'fecha_fin' => '2025-12-15',
            'url_externa' => null, // porque es de la FET
            'activo' => true,
        ]);

        Formacion::create([
            'titulo' => 'Curso de Análisis de Datos en Python',
            'descripcion' => 'Capacitación básica en análisis de datos, orientada a principiantes.',
            'entidad' => 'SENA',
            'tipo' => 'Curso',
            'programa' => 'Ingeniería de Software',
            'modalidad' => 'Virtual',
            'costo' => 0,
            'fecha_inicio' => '2025-11-01',
            'fecha_fin' => '2025-11-30',
            'url_externa' => 'https://sena.edu.co/cursos/python',
            'activo' => true,
        ]);

        Formacion::create([
            'titulo' => 'Seminario en Energías Renovables',
            'descripcion' => 'Introducción al uso de energías renovables y sostenibles.',
            'entidad' => 'Cámara de Comercio de Neiva',
            'tipo' => 'Seminario',
            'programa' => 'Ingeniería Eléctrica',
            'modalidad' => 'Presencial',
            'costo' => 150000,
            'fecha_inicio' => '2025-11-20',
            'fecha_fin' => '2025-11-22',
            'url_externa' => 'https://ccneiva.org/renovables',
            'activo' => true,
        ]);
    }
}
