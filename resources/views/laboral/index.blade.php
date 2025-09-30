@extends('layouts.app')

@section('title', 'Ofertas Laborales — Egresados 360')

@section('content')

{{-- Hero de bienvenida --}}
<x-hero 
  badge="Bolsa de Empleo"
  title="Oportunidades"
  highlight="Laborales"
  subtitle="Conecta con empresas aliadas"
  description="Encuentra ofertas laborales vigentes gracias a nuestras alianzas con compañías e instituciones."
  :btnPrimary="['text' => 'Ver Ofertas', 'icon' => 'fa-solid fa-briefcase', 'link' => '#ofertas']"
  :btnSecondary="['text' => 'Empresas Aliadas', 'icon' => 'fa-solid fa-building', 'link' => '#empresas']"
  image="https://www.stelorder.com/wp-content/uploads/2021/09/portada-sociedad-laboral.jpg"
/>


{{-- Ofertas Laborales --}}
<section class="container-app py-20">
  {{-- Título --}}
  <div class="text-center max-w-2xl mx-auto mb-14">
    <h2 class="text-3xl sm:text-4xl font-poppins font-semibold">
      Oportunidades <span class="text-primary">Laborales</span>
    </h2>
    <p class="mt-3 text-rblack/70">
      Posuere suspendisse mattis, ligula molestie placerat odio leo accumsan nascetur pulvinar magna
      vehicula dignissim vivamus, facilisi velit ut quis donec pellentesque.
    </p>
  </div>

  {{-- Grid de ofertas --}}
  <div class="grid gap-8 md:grid-cols-2">
    @forelse($ofertas as $oferta)
      <div class="card p-6 flex flex-col justify-between">
        <div>
          <h3 class="font-poppins font-semibold text-lg">{{ $oferta->titulo }}</h3>
          <p class="text-primary font-medium">{{ $oferta->empresa }}</p>
          <p class="text-sm text-rblack/70 mt-2 mb-4">
            {{ Str::limit($oferta->descripcion, 120) }}
          </p>

          {{-- Etiquetas (ejemplo estático, puedes relacionarlas desde DB si lo necesitas) --}}
          <div class="flex flex-wrap gap-2 mb-4">
            <span class="badge">Tiempo completo</span>
            <span class="badge">Remoto</span>
            <span class="badge">Junior</span>
          </div>
        </div>

        {{-- Ubicación + botón --}}
        <div class="flex items-center justify-between mt-4">
          <p class="text-sm text-rblack/60">
            <i class="fa-solid fa-location-dot text-primary mr-1"></i>
            {{ $oferta->ubicacion }}
          </p>
          <a href="{{ $oferta->url_externa }}" target="_blank" class="btn btn-primary py-2">Ver más</a>
        </div>
      </div>
    @empty
      <p class="text-center text-rblack/70">No hay ofertas laborales disponibles por el momento.</p>
    @endforelse
  </div>
</section>

{{-- Empresas Aliadas --}}
<section class="bg-cultured py-20">
  <div class="container-app">
    <h2 class="text-2xl sm:text-3xl font-poppins font-semibold text-center mb-10">
      Empresas <span class="text-primary">Aliadas</span>
    </h2>

    <div class="grid gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
      {{-- Card de empresa (ejemplo estático, se puede traer de DB también) --}}
      <div class="card text-center p-8">
        <img src="https://upload.wikimedia.org/wikipedia/commons/4/44/Microsoft_logo.svg" 
             alt="Microsoft" class="h-12 mx-auto mb-4">
        <h3 class="font-semibold">Microsoft S.A.S</h3>
        <p class="text-primary text-sm mb-2">Tecnología</p>
        <p class="text-sm text-rblack/70">Oportunidades de innovación y desarrollo.</p>
        <a href="https://microsoft.com" target="_blank" class="btn btn-primary mt-4">Visitar</a>
      </div>

      <div class="card text-center p-8">
        <img src="https://upload.wikimedia.org/wikipedia/commons/0/08/Netflix_2015_logo.svg" 
             alt="Netflix" class="h-12 mx-auto mb-4">
        <h3 class="font-semibold">Netflix</h3>
        <p class="text-primary text-sm mb-2">Entretenimiento</p>
        <p class="text-sm text-rblack/70">Impulsando experiencias digitales globales.</p>
        <a href="https://netflix.com" target="_blank" class="btn btn-primary mt-4">Visitar</a>
      </div>
      

      {{-- Repite más cards de empresas... --}}
    </div>
  </div>
</section>

@endsection
