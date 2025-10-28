@extends('layouts.app')

@section('title', 'Política de Tratamiento de Datos — Egresados 360')

@section('content')
<section class="bg-white py-20">
    <div class="container-app max-w-3xl mx-auto px-6">
        {{-- Encabezado --}}
        <h1 class="text-3xl sm:text-4xl font-poppins font-semibold text-gunmetal mb-4">
            Política de <span class="text-primary">Tratamiento de Datos Personales</span>
        </h1>
        <p class="text-rblack/70 mb-10">
            Última actualización: <strong>{{ now()->format('d/m/Y') }}</strong>
        </p>

        {{-- Cuerpo del documento --}}
        <div class="prose prose-green max-w-none text-rblack/80 leading-relaxed">
            <p>
                La <strong>Fundación Escuela Tecnológica de Neiva “Jesús Oviedo Pérez” (FET)</strong>, en cumplimiento de la
                <strong>Ley 1581 de 2012</strong> y el <strong>Decreto 1377 de 2013</strong>, informa que los datos personales recolectados
                a través del portal <strong>Egresados 360</strong> serán tratados conforme a los principios de legalidad, finalidad, libertad,
                veracidad, transparencia, acceso y confidencialidad.
            </p>

            <h2 class="text-2xl font-semibold text-gunmetal mt-10 mb-3">1. Finalidad del tratamiento</h2>
            <p>
                La información suministrada por los egresados será utilizada exclusivamente para los siguientes fines:
            </p>
            <ul class="list-disc list-inside">
                <li>Mantener comunicación institucional con los egresados.</li>
                <li>Ofrecer servicios, programas y actividades académicas, laborales y de bienestar.</li>
                <li>Generar reportes estadísticos y análisis para la mejora continua de los procesos institucionales.</li>
                <li>Enviar información relevante sobre convocatorias, eventos o proyectos de interés para la comunidad FET.</li>
            </ul>

            <h2 class="text-2xl font-semibold text-gunmetal mt-10 mb-3">2. Datos recolectados</h2>
            <p>
                El portal podrá solicitar los siguientes datos personales: nombre completo, correo electrónico, número de contacto,
                programa académico y año de egreso. No se solicitarán datos sensibles ni financieros.
            </p>

            <h2 class="text-2xl font-semibold text-gunmetal mt-10 mb-3">3. Derechos del titular</h2>
            <p>
                El egresado podrá conocer la información registrada en el portal y, en caso de requerir actualización o eliminación de sus datos, podrá solicitarlo a la
                <strong>Oficina de Egresados</strong> de la Fundación Escuela Tecnológica de Neiva “Jesús Oviedo Pérez”, mediante comunicación escrita o correo electrónico a
                <a href="mailto:ori-egresados@fet.edu.co" class="text-primary underline hover:text-green-700 transition">ori-egresados@fet.edu.co</a>.
            </p>
            <p class="mt-4">
                La institución garantiza la confidencialidad, seguridad y adecuado uso de la información suministrada, conforme a lo establecido en la <strong>Ley 1581 de 2012</strong>.
            </p>


            <h2 class="text-2xl font-semibold text-gunmetal mt-10 mb-3">4. Responsable del tratamiento</h2>
            <p>
                <strong>Fundación Escuela Tecnológica de Neiva “Jesús Oviedo Pérez” (FET)</strong><br>
                Área de Egresados y Relaciones Institucionales<br>
                Correo: <a href="mailto:ori-egresados@fet.edu.co" class="text-primary hover:underline">ori-egresados@fet.edu.co</a><br>
                Teléfono: (+57) xxx xxx xxxx
            </p>

            <h2 class="text-2xl font-semibold text-gunmetal mt-10 mb-3">5. Vigencia</h2>
            <p>
                La información se conservará durante el tiempo necesario para cumplir las finalidades descritas
                y mientras el titular no solicite su eliminación.
            </p>

            <p class="mt-8 text-rblack/70">
                Al diligenciar el formulario de registro, el titular manifiesta haber leído y aceptado esta política de tratamiento de datos personales.
            </p>
        </div>

        {{-- Botón volver --}}
        <div class="mt-12 text-center">
            <a href="{{ route('inicio') }}"
                class="inline-flex items-center gap-2 px-6 py-3 rounded-lg bg-primary text-white font-medium shadow hover:bg-green-700 transition">
                <i class="fa-solid fa-arrow-left"></i> Volver al inicio
            </a>
        </div>
    </div>
</section>
@endsection