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
  image="https://www.stelorder.com/wp-content/uploads/2021/09/portada-sociedad-laboral.jpg" />


{{-- Ofertas Laborales --}}
<section class="container-app py-20" id="ofertas">
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
        <p class="text-primary font-medium">{{ $oferta->empresa->nombre ?? 'Empresa no disponible' }}</p>
        <p class="text-sm text-rblack/70 mt-2 mb-4">
          {{ Str::limit($oferta->descripcion, 120) }}
        </p>

        {{-- Etiquetas dinámicas --}}
        @if(!empty($oferta->etiquetas))
        @php
        $tags = is_array($oferta->etiquetas) ? $oferta->etiquetas : json_decode($oferta->etiquetas, true);
        @endphp
        <div class="flex flex-wrap gap-2 mb-4">
          @foreach($tags as $tag)
          <span class="badge">{{ trim($tag) }}</span>
          @endforeach
        </div>
        @endif
      </div>

      {{-- Ubicación + botón --}}
      <div class="flex items-center justify-between mt-4">
        <p class="text-sm text-rblack/60">
          <i class="fa-solid fa-location-dot text-primary mr-1"></i>
          {{ $oferta->ubicacion }}
        </p>
        <button onclick="verOferta('{{ $oferta->id }}')" class="btn btn-primary py-2">
          Ver más
        </button>

      </div>
    </div>
    @empty
    <p class="text-center text-rblack/70 col-span-2">No hay ofertas laborales disponibles por el momento.</p>
    @endforelse
  </div>
</section>


{{-- Empresas Aliadas --}}
<section class="bg-cultured py-20" id="empresas">
  <div class="container-app"
    x-data="{
          scrollAmount: 1,
          startAutoScroll() {
            const container = this.$refs.slider;
            setInterval(() => {
              container.scrollLeft += this.scrollAmount;
              if (container.scrollLeft + container.clientWidth >= container.scrollWidth) {
                container.scrollLeft = 0; // reinicia el ciclo
              }
            }, 20);
          }
        }"
    x-init="startAutoScroll()">
    <div class="text-center max-w-2xl mx-auto mb-10">
      <h2 class="text-3xl sm:text-4xl font-poppins font-semibold mb-0">
        Empresas <span class="text-primary">Aliadas</span>
      </h2>
      <p class="mt-3 text-rblack/70">
        Posuere suspendisse mattis, ligula molestie placerat odio leo accumsan nascetur pulvinar magna
        vehicula dignissim vivamus, facilisi velit ut quis donec pellentesque.
      </p>
    </div>

    @if($empresas->count() > 0)
    <div class="relative">
      <div
        x-ref="slider"
        class="flex gap-6 overflow-hidden scroll-smooth">
        @foreach(array_merge($empresas->toArray(), $empresas->toArray()) as $empresa)
        <div
          class="snap-center shrink-0 bg-white rounded-2xl shadow p-8 text-center mx-2 w-[290px] sm:w-[300px] flex flex-col justify-between">

          <div>
            {{-- Logo --}}
            @if(!empty($empresa['logo']))
            <img src="{{ asset('storage/' . $empresa['logo']) }}" alt="{{ $empresa['nombre'] }}" class="h-12 mx-auto mb-4 object-contain">
            @else
            <div class="h-12 flex items-center justify-center text-gray-400 mb-4">
              <i class="fa-solid fa-building text-2xl"></i>
            </div>
            @endif

            {{-- Información --}}
            <div class="flex-1">
              <h3 class="font-semibold">{{ $empresa['nombre'] }}</h3>
              <p class="text-primary text-sm mb-2">{{ $empresa['sector'] ?? 'Sector no especificado' }}</p>
              <p class="text-sm text-rblack/70">
                {{ Str::limit($empresa['descripcion'] ?? '—', 150, '...') }}
              </p>
            </div>
          </div>

          {{-- Botón --}}
          <div class="flex justify-center mt-4 shrink-0">
            <a
              href="{{ $empresa['url'] }}"
              target="_blank"
              class="btn btn-primary mt-2"
              data-track
              data-module="laboral"
              data-action="visitar_empresa"
              data-type="empresa"
              data-id="{{ $empresa['id'] ?? '' }}"
              data-title="{{ $empresa['nombre'] ?? 'Empresa sin nombre' }}">
              Visitar <i class="fa-solid fa-arrow-up-right-from-square ml-2"></i>
            </a>

          </div>
        </div>
        @endforeach
      </div>
    </div>
    @else
    <p class="text-center text-rblack/70">Aún no hay empresas registradas.</p>
    @endif
  </div>
</section>

<x-laboral.modal-oferta />
@endsection