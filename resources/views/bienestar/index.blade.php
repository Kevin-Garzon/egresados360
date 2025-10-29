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
    :btnSecondary="['text' => 'Servicios', 'icon' => 'fa-solid fa-hand-holding-heart', 'link' => '#beneficios']"
    image="https://storage.googleapis.com/www-saludiario-com/wp-content/uploads/2023/08/8e35f3c3-bienestar-integral.jpg" />

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
            <p class="text-sm text-rblack/70 mt-2 mb-5 line-clamp-3">{{ $h->descripcion }}</p>

            <div class="mt-auto flex flex-col sm:flex-row gap-2 w-full">
                <button
                    type="button"
                    class="btn btn-primary w-full sm:w-auto justify-center px-4 py-2"
                    onclick="verHabilidad('{{ $h->id }}')">
                    <i class="fa-solid fa-eye mr-2"></i> Ver detalles
                </button>

                @if($h->enlace_inscripcion)
                <a
                    href="{{ $h->enlace_inscripcion }}"
                    target="_blank"
                    class="btn w-full sm:w-auto justify-center px-4 py-2"
                    data-track
                    data-module="bienestar"
                    data-action="inscribirse_habilidad"
                    data-type="habilidad"
                    data-id="{{ $h->id }}"
                    data-title="{{ $h->titulo }}">
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

        <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-3">
            @forelse($servicios as $s)
            <article class="card p-6 flex flex-col">
                {{-- Header con logo (si existe) --}}
                <div class="flex items-center gap-4 mb-4">
                    @if($s->logo)
                    <img src="{{ asset('storage/' . $s->logo) }}" alt="Logo {{ $s->nombre }}"
                        class="h-12 w-12 rounded-full object-cover border border-gray-200">
                    @else
                    <div class="bg-primary/10 text-primary p-3 rounded-full">
                        <i class="fa-solid fa-hand-holding-heart text-xl"></i>
                    </div>
                    @endif
                    <div>
                        <h3 class="font-semibold">{{ $s->nombre }}</h3>
                        <p class="text-xs text-rblack/60">{{ $s->tipo ?? '—' }}</p>
                    </div>
                </div>

                <p class="text-sm text-rblack/80 mb-5 flex-1 line-clamp-4">
                    {{ $s->descripcion ?? 'Sin descripción disponible' }}
                </p>

                {{-- Botones --}}
                <div class="flex justify-end gap-2 mt-auto">
                    {{-- Ver detalles --}}
                    <button
                        type="button"
                        class="btn btn-primary px-4 py-2"
                        onclick="verServicio('{{ $s->id }}')">
                        <i class="fa-solid fa-circle-info mr-2"></i> Ver detalles
                    </button>

                    {{-- PDF opcional --}}
                    @if($s->pdf)
                    <a href="{{ asset('storage/' . $s->pdf) }}"
                        target="_blank"
                        class="btn px-4 py-2"
                        title="Ver documento PDF">
                        <i class="fa-solid fa-file-pdf mr-2 text-red-600"></i> PDF
                    </a>
                    @endif
                </div>
            </article>
            @empty
            <p class="text-center text-gray-500 col-span-full">No hay servicios registrados.</p>
            @endforelse
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


    {{-- ================= --}}
    {{-- FILTROS DE EVENTOS --}}
    {{-- ================= --}}
    <div class="flex flex-wrap justify-center gap-3 mb-10">
        <button data-filtro="todos"
            class="filtro-evento-btn activo px-5 py-2 rounded-full border-2 border-primary text-primary hover:bg-primary hover:text-white transition">
            Todos
        </button>
        <button data-filtro="proximo"
            class="filtro-evento-btn px-5 py-2 rounded-full border-2 border-primary text-primary hover:bg-primary hover:text-white transition">
            Próximos
        </button>
        <button data-filtro="encurso"
            class="filtro-evento-btn px-5 py-2 rounded-full border-2 border-primary text-primary hover:bg-primary hover:text-white transition">
            En curso
        </button>
        <button data-filtro="finalizado"
            class="filtro-evento-btn px-5 py-2 rounded-full border-2 border-primary text-primary hover:bg-primary hover:text-white transition">
            Finalizados
        </button>
    </div>




    @if($eventos->isEmpty())
    <p class="text-center text-gray-500">No hay eventos disponibles por el momento.</p>
    @else
    <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-3">
        @foreach($eventos as $e)
        <article class="card overflow-hidden flex flex-col evento-item" data-tipo="{{ $e->tipo_slug }}">
            <img src="{{ $e->imagen ? asset('storage/' . $e->imagen) : 'https://images.unsplash.com/photo-1503424886302-fdbd8fcbf4e4?q=80&w=1200&auto=format&fit=crop' }}"
                alt="{{ $e->titulo }}" class="h-44 w-full object-cover">

            <div class="p-6 flex-1 flex flex-col">
                <p class="text-sm font-medium text-[#09B451] mb-1">
                    {{ $e->tipo_label }} • {{ $e->modalidad ?? '—' }}
                </p>

                <h3 class="font-poppins font-semibold text-lg">{{ $e->titulo }}</h3>

                <p class="text-sm text-rblack/70 mt-2 mb-6 line-clamp-4">
                    {{ $e->descripcion ?? 'Sin descripción disponible' }}
                </p>

                <div class="mt-auto flex items-center justify-between">
                    <div class="text-sm text-rblack/80 flex items-center gap-2">
                        <i class="fa-regular fa-calendar"></i>
                        {{ $e->fecha_inicio ? \Carbon\Carbon::parse($e->fecha_inicio)->translatedFormat('d M Y') : 'Por definir' }}
                    </div>
                    <button
                        type="button"
                        onclick="verEvento('{{ $e->id }}')"
                        class="btn btn-primary px-4 py-2">
                        <i class="fa-solid fa-eye mr-2"></i> Ver más
                    </button>
                </div>
            </div>
        </article>
        @endforeach
    </div>
    @endif
</section>




{{-- ================= --}}
{{-- SECCIÓN: LÍNEA DE APOYO --}}
{{-- ================= --}}
<section id="apoyo" class="bg-cultured py-24">
    <div class="container-app">

        {{-- Título principal --}}
        <div class="text-center mb-14">
            <h2 class="text-3xl sm:text-4xl font-poppins font-semibold text-gunmetal">
                Línea de <span class="text-primary">Apoyo</span>
            </h2>
            <p class="mt-3 text-rblack/70 max-w-2xl mx-auto">
                Acompañamiento profesional, académico y emocional para fortalecer tu bienestar como egresado FET.
            </p>
        </div>

        {{-- ===================== --}}
        {{-- BLOQUE 1: MENTORÍAS --}}
        {{-- ===================== --}}
        <div class="mb-20">
            <h3 class="text-2xl font-semibold text-primary text-center mb-10">
                Mentorías y Fortalecimiento
            </h3>

            @if($mentorias->isEmpty())
            <p class="text-center text-gray-500">No hay mentorías disponibles por el momento.</p>
            @else
            <div class="grid gap-8 md:grid-cols-3">
                @foreach($mentorias as $m)
                <div class="bg-white rounded-2xl p-8 shadow-sm hover:shadow-md transition">
                    <div class="text-center mb-4">
                        <div class="inline-flex items-center justify-center w-16 h-16 bg-primary/10 text-primary rounded-full text-3xl mb-3">
                            <i class="fa-solid {{ $m->icono ?? 'fa-user-tie' }}"></i>
                        </div>
                        <h4 class="font-semibold text-lg text-gunmetal mb-2">{{ $m->titulo }}</h4>
                        <p class="text-sm text-rblack/70 leading-relaxed">
                            {{ $m->descripcion ?? 'Sin descripción disponible.' }}
                        </p>
                    </div>
                    <button
                        class="btn btn-primary w-full mt-4 py-2 flex items-center justify-center"
                        data-track
                        data-module="bienestar"
                        data-action="solicitar_mentoria"
                        data-type="mentoria"
                        data-id="{{ $m->id }}"
                        data-title="{{ $m->titulo }}">
                        <i class="fa-solid fa-calendar-day mr-2"></i> Solicitar mentoría
                    </button>

                </div>
                @endforeach
            </div>
            @endif
        </div>


        {{-- ===================== --}}
        {{-- BLOQUE 2: ESPACIO DE ESCUCHA --}}
        {{-- ===================== --}}

        {{-- BLOQUE 2 — ESPACIOS DE ESCUCHA (Franja horizontal) --}}
        <div class="bg-primary/5 border border-primary/10 rounded-xl px-8 py-10 flex flex-col md:flex-row items-center justify-between max-w-5xl mx-auto gap-6 text-center md:text-left">
            <div class="flex items-center gap-4">
                <div class="text-primary text-4xl">
                    <i class="fa-solid fa-hand-holding-heart"></i>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gunmetal">Espacios de Escucha</h3>
                    <p class="text-sm text-rblack/70 leading-relaxed">
                        Acompañamiento emocional y orientación con el equipo de Bienestar Institucional.
                    </p>
                </div>
            </div>

            <a
                href="https://wa.me/573001234567?text=Hola,%20soy%20egresado%20FET%20y%20quisiera%20solicitar%20un%20espacio%20de%20escucha."
                target="_blank"
                class="btn btn-primary px-6 py-2 flex items-center shadow"
                data-track
                data-module="bienestar"
                data-action="solicitar_espacio_escucha"
                data-type="atencion"
                data-id="0"
                data-title="Espacio de Escucha">
                <i class="fa-brands fa-whatsapp mr-2"></i> Solicitar
            </a>

        </div>



    </div>
</section>




<x-bienestar.modal-habilidad />
<x-bienestar.modal-servicio />
<x-bienestar.modal-evento />

@endsection