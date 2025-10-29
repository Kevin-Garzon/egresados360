@extends('layouts.app')

@section('title', 'Formación Continua — Egresados 360')

@section('content')

{{-- Hero principal --}}
<x-hero
  badge="Educación Continua"
  title="Ofertas de"
  highlight="Formación"
  subtitle="Cursos, diplomados y seminarios FET"
  description="Explora nuestra oferta de formación continua y fortalece tus competencias profesionales con programas actualizados y accesibles."
  :btnPrimary="['text' => 'Ver Cursos', 'icon' => 'fa-solid fa-book-open-reader', 'link' => '#formacion']"
  :btnSecondary="['text' => 'Contacto', 'icon' => 'fa-solid fa-envelope', 'link' => '#contacto']"
  image="https://www.ceduk.edu.mx/blog/wp-content/uploads/2024/07/tecnicas-de-estudio-ejercicios.jpg" />

{{-- Sección principal de formación --}}
<section id="formacion" class="container-app py-20">

  {{-- Encabezado --}}
  <div class="text-center max-w-2xl mx-auto mb-14">
    <h2 class="text-3xl sm:text-4xl font-poppins font-semibold">
      Formación <span class="text-primary">Continua</span>
    </h2>
    <p class="mt-3 text-rblack/70">
      Programas diseñados para la actualización profesional de nuestros egresados en distintas áreas del conocimiento.
    </p>
  </div>

  {{-- Filtros dinámicos --}}
  @if($categorias->count())
  <div class="flex flex-wrap justify-center gap-3 mb-10">
    <button class="filtro-btn activo px-5 py-2 rounded-full border-2 border-primary text-primary hover:bg-primary hover:text-white transition">
      Todos
    </button>
    @foreach($categorias as $categoria)
    <button class="filtro-btn px-5 py-2 rounded-full border-2 border-primary text-primary hover:bg-primary hover:text-white transition">
      {{ ucfirst($categoria) }}
    </button>
    @endforeach
  </div>
  @endif


  {{-- Grid de cursos --}}
  <div id="grid-cursos" class="grid gap-8 md:grid-cols-2 lg:grid-cols-3">
    @forelse($formaciones as $formacion)
    <div class="card p-6 flex flex-col justify-between curso-item" data-categoria="{{ strtolower($formacion->programa) }}">
      {{-- Imagen del curso --}}
      @if($formacion->imagen)
      <img src="{{ asset('storage/'.$formacion->imagen) }}" alt="{{ $formacion->titulo }}" class="rounded-xl mb-4 h-44 w-full object-cover">
      @else
      <div class="h-44 flex items-center justify-center bg-gray-50 rounded-xl mb-4">
        <i class="fa-solid fa-graduation-cap text-primary text-6xl"></i>
      </div>
      @endif

      {{-- Información --}}
      <h3 class="font-poppins font-semibold text-lg">{{ $formacion->titulo }}</h3>
      <p class="text-primary font-medium">{{ $formacion->modalidad }} - {{ $formacion->tipo ?? 'Sin definir' }}</p>

      <p class="text-sm text-rblack/70 mt-2 mb-4 line-clamp-3">
        {{ $formacion->descripcion }}
      </p>

      {{-- Precio y botón --}}
      <div class="flex items-center justify-between mt-4">
        @if($formacion->costo)
        <p class="text-sm text-primary font-semibold">
          <i class="fa-solid fa-money-bill-wave mr-1"></i>
          ${{ number_format($formacion->costo, 0, ',', '.') }}
        </p>
        @endif

        <button class="btn btn-primary py-2" onclick="verCurso('{{ $formacion->id }}')">Detalles</button>

      </div>
    </div>
    @empty
    <p class="text-center text-rblack/60 col-span-full">No hay programas disponibles actualmente.</p>
    @endforelse
  </div>
</section>

<x-formacion.modal-curso />
@endsection