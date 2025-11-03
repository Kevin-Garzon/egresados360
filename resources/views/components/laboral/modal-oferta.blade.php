{{-- =============================== --}}
{{-- MODAL DETALLE OFERTA LABORAL --}}
{{-- =============================== --}}
<div id="ofertaModal" class="hidden fixed inset-0 bg-black/60 flex items-center justify-center z-50">
  <div class="bg-white rounded-2xl shadow-card max-w-2xl w-full relative overflow-hidden">

    {{-- Botón cerrar --}}
    <button id="close-modal-oferta"
      class="absolute top-4 right-4 text-gray-500 hover:text-primary text-3xl font-light transition">
      &times;
    </button>

    {{-- Contenido desplazable --}}
    <div class="max-h-[85vh] overflow-y-auto p-8 space-y-6">

      {{-- Cabecera --}}
      <header>
        <h3 class="text-3xl font-semibold text-primary leading-tight" id="modalTitulo"></h3>
        <p class="text-sm text-gray-500 mt-1 flex items-center gap-2">
          <i class="fa-solid fa-building text-primary"></i>
          <span id="modalEmpresa" class="font-medium"></span>
        </p>
      </header>

      {{-- Flyer --}}
      <div id="modalFlyerContainer" class="hidden">
        <a id="modalFlyerLink" href="#" target="_blank">
          <img id="modalFlyer"
            src=""
            alt="Flyer de la oferta"
            class="w-full rounded-xl object-cover shadow-md max-h-[280px] hover:opacity-90 transition" />
        </a>
      </div>

      {{-- Descripción --}}
      <section id="modalDescripcion"
        class="text-gray-700 leading-relaxed text-justify whitespace-pre-line"></section>

      {{-- Etiquetas --}}
      <div id="modalEtiquetas" class="flex flex-wrap gap-2">
        <!-- etiquetas dinámicas -->
      </div>

      {{-- Info adicional --}}
      <div class="border-t border-gray-100 pt-4 flex flex-col sm:flex-row sm:items-center sm:justify-between text-gray-700 text-[15px] gap-3">
        <p class="flex items-center gap-2">
          <i class="fa-solid fa-location-dot text-primary text-lg"></i>
          <span id="modalUbicacion" class="font-medium"></span>
        </p>
        <p class="flex items-center gap-2">
          <i class="fa-regular fa-calendar text-primary text-lg"></i>
          <span class="font-medium">Publicada:</span>
          <span id="modalFecha"></span>
        </p>
      </div>

      {{-- Botón --}}
      <div class="text-right pt-4">
        <a id="modalLink"
          href="#"
          target="_blank"
          class="btn btn-primary"
          data-track
          data-module="laboral"
          data-action="aplicar"
          data-type="oferta"
          data-id=""
          data-title="">
          Ir a aplicar <i class="fa-solid fa-arrow-up-right-from-square ml-2"></i>
        </a>
      </div>

    </div>
  </div>
</div>


{{-- ========================= --}}
{{-- SCRIPT DEL MODAL --}}
{{-- ========================= --}}
<script>
  async function verOferta(id) {
    try {
      window.currentOfertaId = id;

      const res = await fetch(`/api/oferta/${id}`);
      if (!res.ok) throw new Error('Error al obtener los datos de la oferta');
      const oferta = await res.json();

      // Asignar datos
      document.getElementById('modalTitulo').innerText = oferta.titulo ?? '—';
      document.getElementById('modalEmpresa').innerText = oferta.empresa?.nombre ?? 'Empresa no disponible';
      document.getElementById('modalDescripcion').innerText = oferta.descripcion ?? '';
      document.getElementById('modalUbicacion').innerText = oferta.ubicacion ?? 'Ubicación no especificada';

      // Fecha formateada
      let fechaFormateada = '—';
      if (oferta.publicada_en) {
        const fecha = new Date(oferta.publicada_en);
        fechaFormateada = fecha.toLocaleDateString('es-CO', {
          day: '2-digit',
          month: 'short',
          year: 'numeric'
        });
      }
      document.getElementById('modalFecha').innerText = fechaFormateada;

      // Enlace de acción
      const modalLink = document.getElementById('modalLink');
      modalLink.href = oferta.url_externa ?? '#';
      modalLink.setAttribute('data-id', oferta.id);
      modalLink.setAttribute('data-title', oferta.titulo ?? 'Oferta sin título');

      // Flyer (si existe)
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

      // Etiquetas dinámicas
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

      // Mostrar modal
      document.getElementById('ofertaModal').classList.remove('hidden');
      document.body.style.overflow = 'hidden';
    } catch (error) {
      console.error('Error mostrando la oferta:', error);
    }
  }

  document.getElementById('close-modal-oferta').addEventListener('click', () => {
    document.getElementById('ofertaModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
  });
</script>