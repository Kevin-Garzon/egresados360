@extends('layouts.app')

@section('title', 'Inicio — Egresados 360')

{{-- Hero de bienvenida --}}
@section('hero')
<section class="relative overflow-hidden bg-white">
    <div class="container-app py-16 grid lg:grid-cols-2 gap-10 items-center">
        <div>
            <span class="badge mb-4">Egresados 360</span>
            <h1 class="text-4xl sm:text-5xl font-poppins font-semibold leading-tight text-gunmetal">
                Bienvenidos <br><span class="text-primary font-bold">Egresados FET</span>
                <span class="block">Orgullo Institucional</span>
            </h1>
            <p class="mt-5 text-lg text-rblack/80 max-w-prose">
                Somos el puente entre la FET y sus egresados: aquí encontrarás oportunidades laborales, formación continua y actividades de bienestar.
            </p>
            <div class="mt-8 flex flex-wrap gap-3">
                <a href="#contacto" class="btn btn-primary"><i class="fa-brands fa-whatsapp" style="color: #ffffff;"></i>Contáctanos</a>

                <a href="#ofertas" class="btn btn-secondary"><i class="fa-solid fa-envelope text-white"></i>Contactanos</a>
            </div>
        </div>
        <div>
            <div class="aspect-[4/3] md:aspect-[16/10] card p-2">
                <img src="https://images.unsplash.com/photo-1541339907198-e08756dedf3f?q=80&w=1400&auto=format&fit=crop"
                    alt="Egresados FET" class="w-full h-full object-cover rounded-2xl" />
            </div>
        </div>
    </div>
</section>
@endsection

{{-- Contenido específico de la página --}}
@section('content')
<section class="container-app py-16">
    <h2 class="text-2xl font-poppins font-semibold mb-4">Sección de prueba</h2>
    <p class="text-rblack/80">Aquí irán los bloques: Oficina de Egresados, Principios, Equipo, Carnetización, Normatividad.</p>
</section>
@endsection