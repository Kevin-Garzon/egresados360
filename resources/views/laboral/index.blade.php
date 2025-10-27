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
          onclick="openOfertaModal('{{ $oferta->id }}')"
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
            <a href="{{ $empresa['url'] }}" target="_blank" class="btn btn-primary mt-2">Visitar</a>
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
          onclick="registrarInteraccion(event)"
          data-id="">
          Ir a aplicar <i class="fa-solid fa-arrow-up-right-from-square ml-2"></i>
        </a>
      </div>
    </div>
  </div>
</div>

<script>
  // Nueva versión usando fetch() para obtener la información del modal
  async function openOfertaModal(id) {
    try {
      window.currentOfertaId = id; // mantiene la oferta actual para registrar interacción

      const res = await fetch(`/api/oferta/${id}`);
      if (!res.ok) throw new Error('Error al obtener los datos de la oferta');
      const oferta = await res.json();

      document.getElementById('modalTitulo').innerText = oferta.titulo;
      document.getElementById('modalEmpresa').innerText = oferta.empresa?.nombre ?? 'Empresa no disponible';
      document.getElementById('modalDescripcion').innerText = oferta.descripcion ?? '';
      document.getElementById('modalUbicacion').innerText = oferta.ubicacion ?? 'Ubicación no especificada';
      document.getElementById('modalFecha').innerText = oferta.publicada_en ?? '—';
      document.getElementById('modalLink').href = oferta.url_externa ?? '#';
      document.getElementById('modalLink').setAttribute('data-id', oferta.id);

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
    } catch (error) {
      console.error('Error mostrando la oferta:', error);
    }
  }

  function closeOfertaModal() {
    document.getElementById('ofertaModal').classList.add('hidden');
  }

  function registrarInteraccion(event) {
    event.preventDefault();

    const link = event.currentTarget.getAttribute('href');
    const id = event.currentTarget.getAttribute('data-id') || window.currentOfertaId;

    if (!id) {
      window.open(link, '_blank');
      return;
    }

    const perfilId = localStorage.getItem('perfil_id');

    // Si NO hay perfil -> abrir modal y guardar clic pendiente
    if (!perfilId) {
      const pendiente = {
        module: 'laboral',
        action: 'aplicar',
        item_type: 'oferta',
        item_id: id,
        item_title: document.getElementById('modalTitulo')?.innerText || 'Oferta sin título',
        url: link
      };
      localStorage.setItem('pendiente_click', JSON.stringify(pendiente));
      // Abrir el modal Livewire
      if (window.Livewire && typeof window.Livewire.dispatch === 'function') {
        window.Livewire.dispatch('abrirFormularioPerfil');
      } else if (window.Livewire && typeof window.Livewire.emit === 'function') {
        // compatibilidad Livewire v2
        window.Livewire.emit('abrirFormularioPerfil');
      } else {
        console.warn('⚠️ No se pudo emitir evento Livewire, Livewire no está disponible aún.');
      }

      return; // no continuamos, esperamos a que guarde el perfil
    }

    // 1) Legacy (tu registro actual - opcional si quieres conservarlo)
    fetch(`/ofertas/${id}/interaccion`, {
      method: 'POST',
      headers: {
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
        'Content-Type': 'application/json',
      },
    }).catch(() => {});

    // 2) Nuevo tracking (dashboard)
    const nuevaData = {
      module: 'laboral',
      action: 'aplicar',
      item_type: 'oferta',
      item_id: id,
      item_title: document.getElementById('modalTitulo')?.innerText || 'Oferta sin título',
      perfil_id: perfilId
    };

    fetch('/api/track/interaction', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
      },
      body: JSON.stringify(nuevaData)
    }).catch(() => {}).finally(() => {
      window.open(link, '_blank');
    });
  }
</script>