{{-- ==================== --}}
{{-- MODAL DETALLES EVENTO --}}
{{-- ==================== --}}
<div id="modal-evento" class="fixed inset-0 bg-black/50 z-50 hidden items-center justify-center">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-lg relative overflow-hidden">

        {{-- Botón cerrar --}}
        <button id="close-modal-evento"
            class="absolute top-3 right-3 text-gray-400 hover:text-primary text-xl transition">
            <i class="fa-solid fa-xmark"></i>
        </button>

        {{-- Header --}}
        <div class="p-6 pb-3 border-b border-gray-200">
            <h2 id="evento-titulo" class="text-xl font-poppins font-semibold text-[#09B451] mb-1">Título del evento</h2>
            <p id="evento-sub" class="text-sm text-gray-500">Modalidad • Tipo</p>
        </div>

        {{-- Body --}}
        <div class="px-6 py-5 space-y-5 max-h-[70vh] overflow-y-auto">
            {{-- Imagen --}}
            <div class="rounded-xl overflow-hidden border border-gray-200">
                <img id="evento-imagen" src="https://via.placeholder.com/400x250?text=Sin+Imagen"
                    class="w-full h-52 object-cover" alt="Evento">
            </div>

            {{-- Descripción --}}
            <p id="evento-descripcion" class="text-gray-700 text-sm leading-relaxed"></p>

            {{-- Info general --}}
            <div class="grid sm:grid-cols-2 gap-4 text-sm text-gray-700">
                <div class="flex items-center gap-2">
                    <i class="fa-regular fa-calendar text-primary"></i>
                    <span><strong>Inicio:</strong> <span id="evento-fecha-inicio">—</span></span>
                </div>
                <div class="flex items-center gap-2">
                    <i class="fa-regular fa-calendar-check text-primary"></i>
                    <span><strong>Fin:</strong> <span id="evento-fecha-fin">—</span></span>
                </div>
                <div class="flex items-center gap-2">
                    <i class="fa-regular fa-clock text-primary"></i>
                    <span><strong>Hora:</strong> <span id="evento-hora">—</span></span>
                </div>
                <div class="flex items-center gap-2">
                    <i class="fa-solid fa-location-dot text-primary"></i>
                    <span><strong>Lugar:</strong> <span id="evento-ubicacion">—</span></span>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Script --}}
<script>
    function formatearFecha(fechaISO) {
        if (!fechaISO) return '—';
        try {
            const fecha = new Date(fechaISO);
            return fecha.toLocaleDateString('es-ES', { day: '2-digit', month: 'short', year: 'numeric' });
        } catch {
            return fechaISO;
        }
    }

    function formatearHora(hora) {
        if (!hora) return '—';
        try {
            const [h, m] = hora.split(':');
            const fecha = new Date();
            fecha.setHours(h, m);
            return fecha.toLocaleTimeString('es-ES', { hour: '2-digit', minute: '2-digit' });
        } catch {
            return hora;
        }
    }

    async function verEvento(id) {
        try {
            const res = await fetch(`/bienestar/evento/${id}`);
            const data = await res.json();

            document.getElementById('evento-titulo').textContent = data.titulo || '—';
            document.getElementById('evento-sub').textContent = `${data.modalidad ?? '—'} • ${data.estado_label ?? '—'}`;
            document.getElementById('evento-descripcion').textContent = data.descripcion ?? 'Sin descripción disponible';
            document.getElementById('evento-ubicacion').textContent = data.ubicacion ?? '—';
            document.getElementById('evento-fecha-inicio').textContent = formatearFecha(data.fecha_inicio);
            document.getElementById('evento-fecha-fin').textContent = formatearFecha(data.fecha_fin);
            document.getElementById('evento-hora').textContent = formatearHora(data.hora_inicio);
            document.getElementById('evento-imagen').src = data.imagen_url ?? 'https://via.placeholder.com/400x250?text=Sin+Imagen';

            const modal = document.getElementById('modal-evento');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.body.style.overflow = 'hidden';
        } catch (error) {
            console.error('Error al cargar el evento:', error);
        }
    }

    document.getElementById('close-modal-evento').addEventListener('click', () => {
        const modal = document.getElementById('modal-evento');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        document.body.style.overflow = 'auto';
    });
</script>
