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
    <button onclick="filtrar('todos')" class="filtro-btn activo px-5 py-2 rounded-full border-2 border-primary text-primary hover:bg-primary hover:text-white transition">
      Todos
    </button>
    @foreach($categorias as $categoria)
    <button onclick="filtrar('{{ strtolower($categoria) }}')" class="filtro-btn px-5 py-2 rounded-full border-2 border-primary text-primary hover:bg-primary hover:text-white transition">
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

        <button class="btn btn-primary py-2" onclick="mostrarDetalle('{{ $formacion->id }}')">Detalles</button>

      </div>
    </div>
    @empty
    <p class="text-center text-rblack/60 col-span-full">No hay programas disponibles actualmente.</p>
    @endforelse
  </div>
</section>

{{-- Modal de detalles --}}
<div id="modal-detalle" class="fixed inset-0 bg-black/60 hidden items-center justify-center z-50">
  <div class="bg-white rounded-2xl shadow-lg max-w-2xl w-full mx-4 p-8 relative">
    {{-- Botón cerrar --}}
    <button onclick="cerrarModal()"
      class="absolute top-4 right-4 text-gray-400 hover:text-primary transition-colors duration-200">
      <i class="fa-solid fa-xmark text-xl"></i>
    </button>

    {{-- Contenedor de contenido dinámico --}}
    <div id="detalle-contenido" class="text-left space-y-5">
      {{-- Aquí se inyectará el contenido desde JS --}}
    </div>
  </div>
</div>

{{-- JS simple para filtros y modal --}}
<script>
  function filtrar(categoria) {
    document.querySelectorAll('.filtro-btn').forEach(btn => btn.classList.remove('activo', 'bg-primary', 'text-white'));
    event.target.classList.add('activo', 'bg-primary', 'text-white');
    document.querySelectorAll('.curso-item').forEach(item => {
      if (categoria === 'todos' || item.dataset.categoria === categoria) {
        item.classList.remove('hidden');
      } else {
        item.classList.add('hidden');
      }
    });
  }

  function mostrarDetalle(id) {
    fetch(`/api/formacion/${id}`)
      .then(res => res.json())
      .then(data => {
        const fechaInicio = data.fecha_inicio ? new Date(data.fecha_inicio).toLocaleDateString('es-CO') : '';
        const fechaFin = data.fecha_fin ? new Date(data.fecha_fin).toLocaleDateString('es-CO') : '';

        document.getElementById('detalle-contenido').innerHTML = `
        <h2 class="text-2xl font-poppins font-semibold text-rblack">${data.titulo}</h2>
        
        <div class="flex items-center gap-2 text-primary font-medium text-sm">
          <i class="fa-solid fa-graduation-cap"></i>
          <span>${data.modalidad ?? ''}</span>
          <span class="text-gray-400">|</span>
          <span>${data.tipo ?? ''}</span>
        </div>

        <p class="text-sm text-rblack/70 leading-relaxed border-t border-gray-100 pt-3">
          ${data.descripcion ?? ''}
        </p>

        <div class="grid sm:grid-cols-2 gap-3 mt-4 text-sm text-rblack/70">
          <div class="flex items-center gap-2">
            <i class="fa-solid fa-calendar-days text-primary"></i>
            <span><strong>Inicio:</strong> ${fechaInicio || '—'}</span>
          </div>
          <div class="flex items-center gap-2">
            <i class="fa-solid fa-calendar-check text-primary"></i>
            <span><strong>Fin:</strong> ${fechaFin || '—'}</span>
          </div>
          <div class="flex items-center gap-2">
            <i class="fa-solid fa-clock text-primary"></i>
            <span><strong>Duración:</strong> ${data.duracion ?? '—'}</span>
          </div>
          <div class="flex items-center gap-2">
            <i class="fa-solid fa-money-bill-wave text-primary"></i>
            <span><strong>Costo:</strong> $${parseInt(data.costo).toLocaleString('es-CO')}</span>
          </div>
        </div>

        <div class="pt-6 flex justify-end">
          <a href="${data.url_externa ?? '#'}"
             target="_blank"
             onclick="registrarInteraccion(${id}, '${data.url_externa ?? '#'}')"
             class="btn btn-primary px-6">
            Inscribirme
          </a>
        </div>
      `;

        document.getElementById('modal-detalle').classList.remove('hidden');
        document.getElementById('modal-detalle').classList.add('flex');
      });
  }


  function cerrarModal() {
    document.getElementById('modal-detalle').classList.remove('flex');
    document.getElementById('modal-detalle').classList.add('hidden');
  }

  function registrarInteraccion(id, link) {
    event.preventDefault();

    fetch(`/formaciones/${id}/interaccion`, {
        method: 'POST',
        headers: {
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
          'Content-Type': 'application/json',
        },
      })
      .then(res => res.json())
      .then(data => {
        console.log('Interacción registrada correctamente', data);
        window.open(link, '_blank'); // Abre el enlace después de registrar
      })
      .catch(err => {
        console.error('Error registrando interacción:', err);
        window.open(link, '_blank'); // fallback por si falla el fetch
      });
  }
</script>

@endsection