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
        <button
          onclick="openOfertaModal(<?php echo json_encode($oferta->id); ?>)"
          class="btn btn-primary py-2">
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
  <div class="container-app">
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
    <div class="grid gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
      @foreach($empresas as $empresa)
      <div class="card text-center p-8 flex flex-col justify-between">
        {{-- Logo --}}
        @if(!empty($empresa->logo))
        <img src="{{ asset('storage/' . $empresa->logo) }}"
          alt="{{ $empresa->nombre }}" class="h-12 mx-auto mb-4 object-contain">
        @else
        <div class="h-12 flex items-center justify-center text-gray-400 mb-4">
          <i class="fa-solid fa-building text-2xl"></i>
        </div>
        @endif

        {{-- Información --}}
        <div>
          <h3 class="font-semibold">{{ $empresa->nombre }}</h3>
          <p class="text-primary text-sm mb-2">{{ $empresa->sector ?? 'Sector no especificado' }}</p>
          <p class="text-sm text-rblack/70">{{ $empresa->descripcion ?? '—' }}</p>
        </div>

        {{-- Botón --}}
        <div class="flex justify-center">
          <a href="{{ $empresa->sitio_web }}" target="_blank" class="btn btn-primary mt-4">Visitar</a>
        </div>
      </div>
      @endforeach
    </div>
    @else
    <p class="text-center text-rblack/70">Aún no hay empresas registradas.</p>
    @endif
  </div>
</section>



@endsection

{{-- Modal de Detalle de Oferta Laboral --}}
<div id="ofertaModal" class="hidden fixed inset-0 bg-black/60 flex items-center justify-center z-50">
  <div class="bg-white rounded-2xl shadow-card max-w-2xl w-full p-6 relative">
    <button onclick="closeOfertaModal()"
      class="absolute top-3 right-3 text-gray-500 hover:text-primary text-2xl">&times;</button>

    <div id="ofertaContent">
      <h3 class="text-2xl font-semibold text-primary mb-2" id="modalTitulo"></h3>
      <p class="text-sm text-gray-500 mb-4">
        <i class="fa-solid fa-building text-primary mr-1"></i>
        <span id="modalEmpresa"></span>
      </p>

      {{-- Flyer (si existe) --}}
      <div id="modalFlyerContainer" class="mb-4 hidden">
        <a id="modalFlyerLink" href="#" target="_blank">
          <img id="modalFlyer"
            src=""
            alt="Flyer de la oferta"
            class="w-full rounded-xl shadow-sm object-contain max-h-[280px] hover:opacity-90 transition">
        </a>
      </div>

      <p class="text-gray-700 leading-relaxed mb-4" id="modalDescripcion"></p>

      <div id="modalEtiquetas" class="flex flex-wrap gap-2 mb-4"></div>

      <div class="flex items-center justify-between mt-4 text-sm text-gray-600">
        <p><i class="fa-solid fa-location-dot text-primary mr-1"></i> <span id="modalUbicacion"></span></p>
        <p><i class="fa-regular fa-calendar text-primary mr-1"></i> Publicada: <span id="modalFecha"></span></p>
      </div>

      <div class="pt-6 text-right">
        <a id="modalLink"
          href="#"
          target="_blank"
          class="btn btn-primary"
          onclick="registrarInteraccion(event)">
          Ir a aplicar <i class="fa-solid fa-arrow-up-right-from-square ml-2"></i>
        </a>

      </div>
    </div>
  </div>
</div>

<script>
  const ofertas = <?php echo json_encode($ofertas); ?>;

  function openOfertaModal(id) {
    window.currentOfertaId = id;

    const oferta = ofertas.find(o => o.id == id);
    if (!oferta) return;

    document.getElementById('modalTitulo').innerText = oferta.titulo;
    document.getElementById('modalEmpresa').innerText = oferta.empresa?.nombre ?? 'Empresa no disponible';
    document.getElementById('modalDescripcion').innerText = oferta.descripcion ?? '';
    document.getElementById('modalUbicacion').innerText = oferta.ubicacion ?? 'Ubicación no especificada';
    document.getElementById('modalFecha').innerText = oferta.publicada_en ?? '—';
    document.getElementById('modalLink').href = oferta.url_externa ?? '#';

    const flyerContainer = document.getElementById('modalFlyerContainer');
    const flyerImg = document.getElementById('modalFlyer');
    const flyerLink = document.getElementById('modalFlyerLink');

    if (oferta.flyer) {
      flyerContainer.classList.remove('hidden');
      flyerImg.src = `/storage/${oferta.flyer}`;
      flyerLink.href = `/storage/${oferta.flyer}`;
    } else {
      flyerContainer.classList.add('hidden');
      flyerImg.src = '';
      flyerLink.href = '#';
    }

    // Etiquetas
    const etiquetasContainer = document.getElementById('modalEtiquetas');
    etiquetasContainer.innerHTML = '';
    let etiquetas = oferta.etiquetas;
    if (typeof etiquetas === 'string') {
      try {
        etiquetas = JSON.parse(etiquetas);
      } catch {}
    }
    if (Array.isArray(etiquetas)) {
      etiquetas.forEach(tag => {
        const span = document.createElement('span');
        span.className = 'bg-gray-100 text-gray-700 text-xs px-3 py-1 rounded-full';
        span.innerText = tag.trim();
        etiquetasContainer.appendChild(span);
      });
    }

    document.getElementById('ofertaModal').classList.remove('hidden');
  }

  function closeOfertaModal() {
    document.getElementById('ofertaModal').classList.add('hidden');
  }

  function registrarInteraccion(event) {
    event.preventDefault(); // Evita que el link se abra inmediatamente

    const link = event.currentTarget.getAttribute('href');
    const id = event.currentTarget.getAttribute('data-id') || window.currentOfertaId;

    if (!id) {
      window.open(link, '_blank'); // por si falla, igual abre el link
      return;
    }

    fetch(`/ofertas/${id}/interaccion`, {
        method: 'POST',
        headers: {
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
          'Content-Type': 'application/json',
        },
      })
      .then(res => res.json())
      .then(data => {
        console.log('✅ Interacción registrada', data);
        window.open(link, '_blank'); // ahora sí abre el enlace
      })
      .catch(err => {
        console.error('⚠️ Error registrando interacción:', err);
        window.open(link, '_blank'); // fallback
      });
  }
</script>