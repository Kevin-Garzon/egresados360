{{-- ========================= --}}
{{-- MODAL DETALLES HABILIDAD --}}
{{-- ========================= --}}
<div id="modal-habilidad" class="fixed inset-0 bg-black/60 z-50 hidden items-center justify-center">
    <div class="bg-white rounded-2xl shadow-lg max-w-2xl w-full mx-4 relative overflow-hidden">

        {{-- Botón cerrar --}}
        <button id="close-modal-habilidad"
            class="absolute top-4 right-4 text-gray-400 hover:text-primary text-3xl font-light transition">
            &times;
        </button>

        {{-- Contenedor con scroll automático --}}
        <div class="max-h-[85vh] overflow-y-auto p-8 space-y-6">

            {{-- Encabezado --}}
            <header class="border-b border-gray-200 pb-4">
                <h2 id="modal-titulo" class="text-3xl font-semibold text-primary leading-tight mb-1">
                    Título de habilidad
                </h2>
                <p id="modal-tema" class="text-sm text-gray-500 font-medium">
                    Tema / modalidad
                </p>
            </header>

            {{-- Imagen principal --}}
            <div id="modal-imagen-container" class="w-full">
                <a id="modal-imagen-link" href="#" target="_blank" rel="noopener noreferrer">
                    <img id="modal-imagen"
                        src=""
                        alt="Imagen habilidad"
                        class="w-full rounded-xl shadow-sm object-cover max-h-[280px] hover:opacity-90 transition border border-gray-100 cursor-pointer">
                </a>
            </div>


            {{-- Descripción --}}
            <section>
                <p id="modal-descripcion"
                    class="text-sm text-rblack/80 leading-relaxed text-justify border-t border-gray-100 pt-4">
                    Aquí va la descripción de la habilidad.
                </p>
            </section>

            {{-- Información adicional --}}
            <div class="grid sm:grid-cols-2 gap-4 text-sm text-rblack/80 border-t border-gray-100 pt-4">
                <div class="flex items-center gap-2">
                    <i class="fa-solid fa-calendar-days text-primary text-lg"></i>
                    <span><strong>Fecha:</strong> <span id="modal-fecha">—</span></span>
                </div>
                <div class="flex items-center gap-2">
                    <i class="fa-solid fa-location-dot text-primary text-lg"></i>
                    <span><strong>Lugar:</strong> Campus FET</span>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    async function verHabilidad(id) {
        const modal = document.getElementById('modal-habilidad');
        const titulo = document.getElementById('modal-titulo');
        const tema = document.getElementById('modal-tema');
        const descripcion = document.getElementById('modal-descripcion');
        const imagen = document.getElementById('modal-imagen');
        const fecha = document.getElementById('modal-fecha');
        const imagenLink = document.getElementById('modal-imagen-link'); 
        const imagenContainer = document.getElementById('modal-imagen-container'); 

        try {
            const response = await fetch(`/bienestar/habilidad/${id}`);
            const data = await response.json();

            // Asignar valores básicos
            titulo.textContent = data.titulo || '—';
            tema.textContent = `${data.tema ?? 'Sin tema'} • ${data.modalidad ?? '—'}`;
            descripcion.textContent = data.descripcion ?? 'Sin descripción disponible';
            fecha.textContent = data.fecha ?
                new Date(data.fecha).toLocaleDateString('es-CO', {
                    day: '2-digit',
                    month: 'short',
                    year: 'numeric'
                }) :
                '—';

            if (data.imagen_url) {
                const fullUrl = data.imagen_url.startsWith('http') ?
                    data.imagen_url :
                    `${window.location.origin}${data.imagen_url}`;

                imagen.src = fullUrl;
                imagenLink.href = fullUrl;
                imagenContainer.classList.remove('hidden');
            } else {
                imagen.src = 'https://via.placeholder.com/400x250?text=Sin+Imagen';
                imagenLink.href = '#';
                imagenContainer.classList.add('hidden');
            }

            // Mostrar modal
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.body.style.overflow = 'hidden';
        } catch (error) {
            console.error('Error al cargar la habilidad:', error);
        }
    }

    // Cerrar modal
    document.getElementById('close-modal-habilidad').addEventListener('click', () => {
        const modal = document.getElementById('modal-habilidad');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        document.body.style.overflow = 'auto';
    });
</script>