{{-- ========================= --}}
{{-- MODAL DETALLES SERVICIO --}}
{{-- ========================= --}}
<div id="modal-servicio" class="fixed inset-0 bg-black/50 z-50 hidden items-center justify-center">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-lg relative overflow-hidden">

        {{-- Botón cerrar --}}
        <button id="close-modal-servicio"
            class="absolute top-3 right-3 text-gray-400 hover:text-primary text-xl transition">
            <i class="fa-solid fa-xmark"></i>
        </button>

        {{-- Encabezado --}}
        <div class="p-6 pb-4 border-b border-gray-200">
            <h2 id="servicio-titulo" class="text-2xl font-semibold text-primary mb-1">Título del servicio</h2>
            <p id="servicio-tipo" class="text-sm text-gray-500">Tipo de servicio</p>
        </div>

        {{-- Contenido con scroll automático --}}
        <div class="px-6 py-4 max-h-[65vh] overflow-y-auto space-y-4 text-justify">

            {{-- Imagen o logo del servicio --}}
            <div id="servicio-logo-container" class="w-full flex justify-center">
                <a id="servicio-logo-link" href="#" target="_blank" rel="noopener noreferrer">
                    <img id="servicio-logo" src=""
                        alt="Logo del servicio"
                        class="max-h-20 object-contain rounded-lg border border-gray-100 shadow-sm hover:opacity-90 transition cursor-pointer" />
                </a>
            </div>

            {{-- Descripción --}}
            <p id="servicio-descripcion" class="text-gray-700 text-sm leading-relaxed border-t border-gray-100 pt-3">
                Sin descripción disponible.
            </p>

            {{-- Información adicional --}}
            <div class="text-sm text-gray-600 space-y-2 border-t border-gray-100 pt-3">
                <p><i class="fa-solid fa-location-dot text-primary mr-2"></i> <span id="servicio-ubicacion"></span></p>
                <p><i class="fa-solid fa-phone text-primary mr-2"></i> <span id="servicio-contacto"></span></p>
            </div>

            {{-- Enlace externo --}}
            <div class="flex justify-end pt-4">
                <a
                    id="servicio-url"
                    href="#"
                    target="_blank"
                    class="btn btn-primary px-4 py-2 hidden"
                    data-track
                    data-module="bienestar"
                    data-action="visitar_servicio"
                    data-type="servicio"
                    data-id=""
                    data-title="">
                    <i class="fa-solid fa-link mr-2"></i> Visitar enlace
                </a>
            </div>
        </div>
    </div>
</div>

{{-- ========================= --}}
{{-- SCRIPT DEL MODAL --}}
{{-- ========================= --}}
<script>
    async function verServicio(id) {
        const modal = document.getElementById('modal-servicio');
        const logoContainer = document.getElementById('servicio-logo-container');
        const logoImg = document.getElementById('servicio-logo');
        const logoLink = document.getElementById('servicio-logo-link');

        try {
            const response = await fetch(`/bienestar/servicio/${id}`);
            const data = await response.json();

            // Asignar datos principales
            document.getElementById('servicio-titulo').textContent = data.nombre ?? '—';
            document.getElementById('servicio-tipo').textContent = data.tipo ?? '—';
            document.getElementById('servicio-descripcion').textContent =
                data.descripcion ?? 'Sin descripción disponible';
            document.getElementById('servicio-ubicacion').textContent = data.ubicacion ?? 'Ubicación no especificada';
            document.getElementById('servicio-contacto').textContent = data.contacto ?? 'No disponible';

            // Imagen o logo del servicio (clicable en tamaño real)
            if (data.logo) {
                const fullUrl = `${window.location.origin}/storage/${data.logo}`;
                logoImg.src = fullUrl;
                logoLink.href = fullUrl;
                logoContainer.classList.remove('hidden');
            } else {
                logoImg.src = '';
                logoLink.href = '#';
                logoContainer.classList.add('hidden');
            }

            // Enlace externo
            const urlBtn = document.getElementById('servicio-url');
            if (data.url) {
                urlBtn.href = data.url;
                urlBtn.classList.remove('hidden');
                urlBtn.dataset.id = data.id ?? '';
                urlBtn.dataset.title = data.nombre ?? 'Servicio sin título';
            } else {
                urlBtn.classList.add('hidden');
            }

            // Mostrar modal
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.body.style.overflow = 'hidden';

        } catch (error) {
            console.error('Error al cargar el servicio:', error);
        }
    }

    // Cerrar modal
    document.getElementById('close-modal-servicio').addEventListener('click', () => {
        const modal = document.getElementById('modal-servicio');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        document.body.style.overflow = 'auto';
    });
</script>