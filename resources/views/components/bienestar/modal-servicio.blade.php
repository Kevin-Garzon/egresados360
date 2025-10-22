{{-- ========================= --}}
{{-- COMPONENTE: MODAL SERVICIO --}}
{{-- ========================= --}}
<div id="modal-servicio" class="fixed inset-0 bg-black/50 z-50 hidden items-center justify-center">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-lg relative overflow-hidden">
        {{-- Cerrar --}}
        <button id="close-modal-servicio"
            class="absolute top-3 right-3 text-gray-400 hover:text-primary text-xl transition">
            <i class="fa-solid fa-xmark"></i>
        </button>

        {{-- HEADER --}}
        <div class="p-6 pb-4 border-b border-gray-200">
            <h2 id="servicio-titulo" class="text-xl font-semibold text-[#09B451] mb-1">Título del servicio</h2>
            <p id="servicio-tipo" class="text-sm text-gray-500">Tipo de servicio</p>
        </div>

        {{-- BODY --}}
        <div class="px-6 py-4 max-h-[60vh] overflow-y-auto space-y-4">
            <p id="servicio-descripcion" class="text-gray-700 text-sm"></p>

            <div class="text-sm text-gray-600 space-y-2">
                <p><i class="fa-solid fa-location-dot text-primary mr-2"></i> <span id="servicio-ubicacion"></span></p>
                <p><i class="fa-solid fa-phone text-primary mr-2"></i> <span id="servicio-contacto"></span></p>
            </div>

            <div class="flex justify-end pt-4">
                <a id="servicio-url" href="#" target="_blank"
                   class="btn btn-primary px-4 py-2 hidden">
                    <i class="fa-solid fa-link mr-2"></i> Visitar enlace
                </a>
            </div>
        </div>
    </div>
</div>

<script>
async function verServicio(id) {
    const modal = document.getElementById('modal-servicio');

    try {
        const response = await fetch(`/bienestar/servicio/${id}`);
        const data = await response.json();

        document.getElementById('servicio-titulo').textContent = data.nombre ?? '—';
        document.getElementById('servicio-tipo').textContent = data.tipo ?? '—';
        document.getElementById('servicio-descripcion').textContent = data.descripcion ?? 'Sin descripción disponible';
        document.getElementById('servicio-ubicacion').textContent = data.ubicacion ?? 'Ubicación no especificada';
        document.getElementById('servicio-contacto').textContent = data.contacto ?? 'No disponible';

        const urlBtn = document.getElementById('servicio-url');
        if (data.url) {
            urlBtn.href = data.url;
            urlBtn.classList.remove('hidden');
        } else {
            urlBtn.classList.add('hidden');
        }

        modal.classList.remove('hidden');
        modal.classList.add('flex');
        document.body.style.overflow = 'hidden';
    } catch (error) {
        console.error('Error al cargar el servicio:', error);
    }
}

document.getElementById('close-modal-servicio').addEventListener('click', () => {
    const modal = document.getElementById('modal-servicio');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
    document.body.style.overflow = 'auto';
});
</script>
