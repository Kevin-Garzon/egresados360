{{-- =============================== --}}
{{-- MODAL DETALLE OFERTA LABORAL --}}
{{-- =============================== --}}
<div id="ofertaModal" class="hidden fixed inset-0 bg-black/60 flex items-center justify-center z-50">
    <div class="bg-white rounded-2xl shadow-card max-w-2xl w-full p-6 relative">

        {{-- Botón cerrar --}}
        <button id="close-modal-oferta"
            class="absolute top-3 right-3 text-gray-500 hover:text-primary text-2xl transition">
            &times;
        </button>

        <div id="ofertaContent">

            {{-- Título --}}
            <h3 class="text-2xl font-semibold text-primary mb-2" id="modalTitulo"></h3>

            {{-- Empresa --}}
            <p class="text-sm text-gray-500 mb-4">
                <i class="fa-solid fa-building text-primary mr-1"></i>
                <span id="modalEmpresa"></span>
            </p>

            {{-- Flyer --}}
            <div id="modalFlyerContainer" class="mb-4 hidden">
                <a id="modalFlyerLink" href="#" target="_blank">
                    <img id="modalFlyer"
                        src=""
                        alt="Flyer de la oferta"
                        class="w-full rounded-xl shadow-sm object-contain max-h-[280px] hover:opacity-90 transition" />
                </a>
            </div>

            {{-- Descripción --}}
            <p class="text-gray-700 leading-relaxed mb-4" id="modalDescripcion"></p>

            {{-- Etiquetas --}}
            <div id="modalEtiquetas" class="flex flex-wrap gap-2 mb-4"></div>

            {{-- Info adicional --}}
            <div class="flex items-center justify-between mt-4 text-sm text-gray-600">
                <p><i class="fa-solid fa-location-dot text-primary mr-1"></i>
                    <span id="modalUbicacion"></span>
                </p>
                <p><i class="fa-regular fa-calendar text-primary mr-1"></i>
                    Publicada: <span id="modalFecha"></span>
                </p>
            </div>

            {{-- Botón de acción --}}
            <div class="pt-6 text-right">
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