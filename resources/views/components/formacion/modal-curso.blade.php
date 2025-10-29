{{-- =============================== --}}
{{-- MODAL DETALLES DE FORMACIÓN --}}
{{-- =============================== --}}
<div id="modal-curso" class="fixed inset-0 bg-black/60 z-50 hidden items-center justify-center">
    <div class="bg-white rounded-2xl shadow-lg max-w-2xl w-full mx-4 p-8 relative">

        {{-- Botón cerrar --}}
        <button id="close-modal-curso"
            class="absolute top-4 right-4 text-gray-400 hover:text-primary transition-colors duration-200">
            <i class="fa-solid fa-xmark text-xl"></i>
        </button>

        {{-- Contenedor del contenido dinámico --}}
        <div id="curso-contenido" class="text-left space-y-5"></div>
    </div>
</div>

{{-- ========================= --}}
{{-- SCRIPT DEL MODAL --}}
{{-- ========================= --}}
<script>
    async function verCurso(id) {
        try {
            const res = await fetch(`/api/formacion/${id}`);
            if (!res.ok) throw new Error('Error al obtener los datos del curso');

            const data = await res.json();
            const fechaInicio = data.fecha_inicio ? new Date(data.fecha_inicio).toLocaleDateString('es-CO', {
                day: '2-digit',
                month: 'short',
                year: 'numeric'
            }) : '—';
            const fechaFin = data.fecha_fin ? new Date(data.fecha_fin).toLocaleDateString('es-CO', {
                day: '2-digit',
                month: 'short',
                year: 'numeric'
            }) : '—';

            // Render dinámico del contenido
            document.getElementById('curso-contenido').innerHTML = `
      <h2 class="text-2xl font-poppins font-semibold text-rblack">${data.titulo ?? '—'}</h2>
      
      ${data.empresa ? `
        <p class="text-sm text-gray-500 flex items-center gap-1">
          <i class="fa-solid fa-building text-primary"></i>
          ${data.empresa.nombre}
        </p>` : ''}

      <div class="flex items-center gap-2 text-primary font-medium text-sm">
        <i class="fa-solid fa-graduation-cap"></i>
        <span>${data.modalidad ?? ''}</span>
        <span class="text-gray-400">|</span>
        <span>${data.tipo ?? ''}</span>
      </div>

      <p class="text-sm text-rblack/70 leading-relaxed border-t border-gray-100 pt-3">
        ${data.descripcion ?? 'Sin descripción disponible'}
      </p>

      <div class="grid sm:grid-cols-2 gap-3 mt-4 text-sm text-rblack/70">
        <div class="flex items-center gap-2">
          <i class="fa-solid fa-calendar-days text-primary"></i>
          <span><strong>Inicio:</strong> ${fechaInicio}</span>
        </div>
        <div class="flex items-center gap-2">
          <i class="fa-solid fa-calendar-check text-primary"></i>
          <span><strong>Fin:</strong> ${fechaFin}</span>
        </div>
        <div class="flex items-center gap-2">
          <i class="fa-solid fa-clock text-primary"></i>
          <span><strong>Duración:</strong> ${data.duracion ? data.duracion + ' horas' : '—'}</span>
        </div>
        <div class="flex items-center gap-2">
          <i class="fa-solid fa-money-bill-wave text-primary"></i>
          <span><strong>Costo:</strong> $${data.costo ? parseInt(data.costo).toLocaleString('es-CO') : '—'}</span>
        </div>
      </div>

      <div class="pt-6 flex justify-end">
        <a 
          href="${data.url_externa ?? '#'}"
          target="_blank"
          class="btn btn-primary px-6"
          data-track
          data-module="formacion"
          data-action="inscribirse"
          data-type="curso"
          data-id="${data.id}"
          data-title="${data.titulo ?? 'Curso sin título'}"
        >
          Inscribirme <i class="fa-solid fa-arrow-up-right-from-square ml-2"></i>
        </a>
      </div>
    `;

            // Mostrar modal
            const modal = document.getElementById('modal-curso');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.body.style.overflow = 'hidden';
        } catch (error) {
            console.error('Error mostrando el curso:', error);
        }
    }

    // Cerrar modal
    document.getElementById('close-modal-curso').addEventListener('click', () => {
        const modal = document.getElementById('modal-curso');
        modal.classList.remove('flex');
        modal.classList.add('hidden');
        document.body.style.overflow = 'auto';
    });
</script>