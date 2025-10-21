@extends('layouts.app')

@section('title', 'Bienestar del Egresado — Egresados 360')

@section('content')

{{-- ==================== --}}
{{-- HERO PRINCIPAL --}}
{{-- ==================== --}}
<x-hero
    badge="Bienestar del Egresado"
    title="Tu bienestar,"
    highlight="nuestra prioridad"
    subtitle="Actividades, servicios y recursos que fortalecen tu desarrollo."
    description="Descubre las iniciativas de la FET para acompañarte en tu crecimiento integral como egresado."
    :btnPrimary="['text' => 'Ver Habilidades', 'icon' => 'fa-solid fa-heart-pulse', 'link' => '#habilidades']"
    :btnSecondary="['text' => 'Servicios y Beneficios', 'icon' => 'fa-solid fa-hand-holding-heart', 'link' => '#beneficios']"
    image="https://images.unsplash.com/photo-1516302350523-4c31f511c3c7?q=80&w=1600&auto=format&fit=crop" />

{{-- ========================= --}}
{{-- HABILIDADES PARA LA VIDA --}}
{{-- ========================= --}}
<section id="habilidades" class="container-app py-20">
    <div class="text-center max-w-2xl mx-auto mb-10">
        <h2 class="text-3xl sm:text-4xl font-poppins font-semibold">
            Habilidades <span class="text-primary">para la vida</span>
        </h2>
        <p class="mt-3 text-rblack/70">
            Talleres y charlas cortas para fortalecer competencias blandas clave en tu ruta profesional.
        </p>
    </div>

    <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-3">
        @forelse($habilidades as $h)
        <article class="card p-6 flex flex-col">
            <img src="{{ $h->imagen ? asset('storage/'.$h->imagen) : 'https://via.placeholder.com/400x250?text=Sin+Imagen' }}"
                alt="{{ $h->titulo }}"
                class="rounded-xl mb-4 h-44 w-full object-cover">

            <h3 class="font-poppins font-semibold text-lg">{{ $h->titulo }}</h3>
            <p class="text-sm text-rblack/70 mt-2 mb-5">{{ $h->descripcion }}</p>

            <div class="mt-auto flex gap-2">
                <button
                    type="button"
                    class="btn btn-primary px-4 py-2"
                    onclick="verHabilidad('{{ $h->id }}')">
                    <i class="fa-solid fa-eye mr-2"></i> Ver detalles
                </button>


                @if($h->enlace_inscripcion)
                <a href="{{ $h->enlace_inscripcion }}" target="_blank" class="btn px-4 py-2">
                    <i class="fa-solid fa-clipboard-check mr-2"></i> Inscribirme
                </a>
                @endif
            </div>

        </article>
        @empty
        <p class="col-span-full text-center text-gray-500">No hay habilidades disponibles actualmente.</p>
        @endforelse
    </div>

</section>

{{-- ===================== --}}
{{-- SERVICIOS Y BENEFICIOS --}}
{{-- ===================== --}}
<section id="beneficios" class="bg-cultured py-20">
    <div class="container-app">
        <div class="text-center max-w-2xl mx-auto mb-10">
            <h2 class="text-3xl sm:text-4xl font-poppins font-semibold">
                Servicios y <span class="text-primary">beneficios</span>
            </h2>
            <p class="mt-3 text-rblack/70">
                Accede a convenios, descuentos y servicios aliados exclusivos para egresados FET.
            </p>
        </div>

        @php($beneficios = [
        ['entidad'=>'Comfamiliar','sector'=>'Caja de compensación','beneficio'=>'Descuentos en recreación y salud','logo'=>'https://images.unsplash.com/photo-1522075469751-3a6694fb2f61?q=80&w=900&auto=format&fit=crop'],
        ['entidad'=>'SENA','sector'=>'Formación','beneficio'=>'Rutas de formación complementaria','logo'=>'https://images.unsplash.com/photo-1529101091764-c3526daf38fe?q=80&w=900&auto=format&fit=crop'],
        ['entidad'=>'GymFit Center','sector'=>'Salud','beneficio'=>'30% descuento afiliación mensual','logo'=>'https://images.unsplash.com/photo-1461896836934-ffe607ba8211?q=80&w=900&auto=format&fit=crop'],
        ['entidad'=>'Optisalud','sector'=>'Salud visual','beneficio'=>'2x1 en lentes oftálmicos','logo'=>'https://images.unsplash.com/photo-1556125572-5835e88f9a4b?q=80&w=900&auto=format&fit=crop'],
        ['entidad'=>'Edutech','sector'=>'Software','beneficio'=>'Licencias académicas con 40% dcto.','logo'=>'https://images.unsplash.com/photo-1517694712202-14dd9538aa97?q=80&w=900&auto=format&fit=crop'],
        ['entidad'=>'Banco Amigo','sector'=>'Finanzas','beneficio'=>'Tasa preferencial crédito de egresado','logo'=>'https://images.unsplash.com/photo-1526304640581-d334cdbbf45e?q=80&w=900&auto=format&fit=crop'],
        ])

        <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-3">
            @foreach($beneficios as $b)
            <article class="card p-6">
                <div class="flex items-center gap-4 mb-4">
                    <img class="h-12 w-12 rounded-full object-cover" src="{{ $b['logo'] }}" alt="{{ $b['entidad'] }}">
                    <div>
                        <h3 class="font-semibold">{{ $b['entidad'] }}</h3>
                        <p class="text-xs text-rblack/60">{{ $b['sector'] }}</p>
                    </div>
                </div>
                <p class="text-sm text-rblack/80 mb-5">{{ $b['beneficio'] }}</p>
                <div class="flex gap-2">
                    <a href="#" class="btn btn-primary px-4 py-2">
                        <i class="fa-solid fa-circle-info mr-2"></i> Cómo acceder
                    </a>
                    {{-- El PDF será opcional dentro del modal de detalles --}}
                </div>
            </article>
            @endforeach
        </div>
    </div>
</section>

{{-- ======= --}}
{{-- EVENTOS --}}
{{-- ======= --}}
<section id="eventos" class="container-app py-20">
    <div class="text-center max-w-2xl mx-auto mb-10">
        <h2 class="text-3xl sm:text-4xl font-poppins font-semibold">
            Nuestros <span class="text-primary">eventos</span>
        </h2>
        <p class="mt-3 text-rblack/70">
            Encuentros, jornadas y torneos para reconectar con tu comunidad FET.
        </p>
    </div>

    @php($eventos = [
    ['tipo'=>'Encuentro','modalidad'=>'Presencial','titulo'=>'Encuentro de Egresados 2025','fecha'=>'07 Dic 2025','lugar'=>'Campus FET','img'=>'https://images.unsplash.com/photo-1511578314322-379afb476865?q=80&w=1200&auto=format&fit=crop','desc'=>'Networking, reconocimientos y actividades culturales.'],
    ['tipo'=>'Jornada','modalidad'=>'Presencial','titulo'=>'Jornada de Salud Integral','fecha'=>'14 Dic 2025','lugar'=>'Bienestar FET','img'=>'https://images.unsplash.com/photo-1518314916381-77a37c2a49ae?q=80&w=1200&auto=format&fit=crop','desc'=>'Chequeos básicos, pausas activas y asesoría nutricional.'],
    ['tipo'=>'Torneo','modalidad'=>'Mixta','titulo'=>'Torneo Relámpago de Fútbol 5','fecha'=>'21 Dic 2025','lugar'=>'Cancha sintética FET','img'=>'https://images.unsplash.com/photo-1502877338535-766e1452684a?q=80&w=1200&auto=format&fit=crop','desc'=>'Equipos mixtos, premiación y feria de emprendimientos.'],
    ])

    <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-3">
        @foreach($eventos as $e)
        <article class="card overflow-hidden flex flex-col">
            <img src="{{ $e['img'] }}" alt="{{ $e['titulo'] }}" class="h-44 w-full object-cover">
            <div class="p-6 flex-1 flex flex-col">
                <p class="text-sm font-medium text-[#09B451] mb-1">{{ $e['modalidad'] }} • {{ $e['tipo'] }}</p>
                <h3 class="font-poppins font-semibold text-lg">{{ $e['titulo'] }}</h3>
                <p class="text-sm text-rblack/70 mt-2 mb-6">{{ $e['desc'] }}</p>

                <div class="mt-auto flex items-center justify-between">
                    <div class="text-sm text-rblack/80 flex items-center gap-2">
                        <i class="fa-regular fa-calendar"></i> {{ $e['fecha'] }}
                    </div>
                    <a href="#" class="btn btn-primary px-4 py-2">
                        <i class="fa-solid fa-eye mr-2"></i> Ver más
                    </a>
                </div>
            </div>
        </article>
        @endforeach
    </div>
</section>

{{-- ============== --}}
{{-- LÍNEA DE APOYO --}}
{{-- ============== --}}
<section id="apoyo" class="bg-cultured py-20">
    <div class="container-app">
        <div class="text-center max-w-2xl mx-auto mb-10">
            <h2 class="text-3xl sm:text-4xl font-poppins font-semibold">
                Línea de <span class="text-primary">apoyo</span>
            </h2>
            <p class="mt-3 text-rblack/70">
                Mentorías, espacios de escucha y orientación. Tu bienestar primero.
            </p>
        </div>

        <div class="grid gap-8 md:grid-cols-2">
            {{-- Mentorías --}}
            <article class="card p-6">
                <div class="flex items-start gap-4">
                    <div class="text-5xl text-primary"><i class="fa-solid fa-user-tie"></i></div>
                    <div>
                        <h3 class="font-semibold text-lg mb-1">Programa de mentorías</h3>
                        <p class="text-sm text-rblack/70">
                            Solicita una sesión con mentores egresados en temas de carrera, portafolio y entrevistas.
                        </p>
                        <ul class="text-sm text-rblack/80 list-disc ml-5 mt-3 space-y-1">
                            <li>Temas: carrera, emprendimiento, TI, diseño CV.</li>
                            <li>Canales: virtual o presencial (Campus FET).</li>
                            <li>Duración sugerida: 45–60 min.</li>
                        </ul>
                        <div class="mt-4 flex gap-2">
                            <a href="#" class="btn btn-primary px-4 py-2">
                                <i class="fa-solid fa-calendar-day mr-2"></i> Solicitar mentoría
                            </a>
                            <a href="#" class="btn px-4 py-2">
                                <i class="fa-solid fa-circle-info mr-2"></i> Ver lineamientos
                            </a>
                        </div>
                    </div>
                </div>
            </article>

            {{-- Espacios de escucha --}}
            <article class="card p-6">
                <div class="flex items-start gap-4">
                    <div class="text-5xl text-primary"><i class="fa-solid fa-hand-holding-heart"></i></div>
                    <div>
                        <h3 class="font-semibold text-lg mb-1">Espacios de escucha</h3>
                        <p class="text-sm text-rblack/70">
                            Atención confidencial y acompañamiento emocional articulado con Bienestar Institucional.
                        </p>
                        <ul class="text-sm text-rblack/80 list-disc ml-5 mt-3 space-y-1">
                            <li>Protocolos de confidencialidad y derivación.</li>
                            <li>Horarios de atención y canales oficiales.</li>
                            <li>Consentimiento informado y tratamiento de datos.</li>
                        </ul>
                        <div class="mt-4 flex gap-2">
                            <a href="#" class="btn btn-primary px-4 py-2">
                                <i class="fa-solid fa-envelope-open-text mr-2"></i> Solicitar cita
                            </a>
                            <a href="#" class="btn px-4 py-2">
                                <i class="fa-solid fa-shield-heart mr-2"></i> Política de privacidad
                            </a>
                        </div>
                    </div>
                </div>
            </article>
        </div>
    </div>
</section>

<x-bienestar.modal-habilidad />

@endsection