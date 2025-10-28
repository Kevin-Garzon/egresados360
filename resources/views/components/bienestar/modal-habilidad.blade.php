{{-- ========================= --}}
{{-- MODAL DETALLES HABILIDAD --}}
{{-- ========================= --}}
<div id="modal-habilidad" class="fixed inset-0 bg-black/60 z-50 hidden items-center justify-center">
    <div class="bg-white rounded-2xl shadow-lg max-w-2xl w-full mx-4 relative overflow-hidden">
        
        {{-- Botón cerrar --}}
        <button id="close-modal-habilidad"
            class="absolute top-4 right-4 text-gray-400 hover:text-primary text-xl transition">
            <i class="fa-solid fa-xmark"></i>
        </button>

        {{-- HEADER --}}
        <div class="p-8 pb-5 border-b border-gray-200">
            <h2 id="modal-titulo" class="text-2xl font-poppins font-semibold text-rblack mb-1">Título de habilidad</h2>
            <p id="modal-tema" class="text-sm text-gray-500 font-medium">Tema / modalidad</p>
        </div>

        {{-- BODY --}}
        <div class="px-8 py-6 max-h-[65vh] overflow-y-auto">
            <div class="space-y-5 text-sm text-rblack/80">
                
                {{-- Imagen principal --}}
                <div class="w-full">
                    <img id="modal-imagen" src="" 
                        class="w-full h-56 object-cover rounded-xl border border-gray-100 shadow-sm" 
                        alt="Imagen habilidad">
                </div>

                {{-- Descripción --}}
                <p id="modal-descripcion" class="leading-relaxed text-gray-700 border-t border-gray-100 pt-4">
                    Aquí va la descripción de la habilidad.
                </p>

                {{-- Información adicional (fecha y lugar) --}}
                <div class="grid sm:grid-cols-2 gap-3 mt-3">
                    <div class="flex items-center gap-2">
                        <i class="fa-solid fa-calendar-days text-primary"></i>
                        <span><strong>Fecha:</strong> <span id="modal-fecha">—</span></span>
                    </div>
                    <div class="flex items-center gap-2">
                        <i class="fa-solid fa-location-dot text-primary"></i>
                        <span><strong>Lugar:</strong> Campus FET</span>
                    </div>
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

    try {
        const response = await fetch(`/bienestar/habilidad/${id}`);
        const data = await response.json();

        titulo.textContent = data.titulo || '—';
        tema.textContent = `${data.tema ?? 'Sin tema'} • ${data.modalidad ?? '—'}`;
        descripcion.textContent = data.descripcion ?? 'Sin descripción disponible';
        imagen.src = data.imagen_url ?? 'https://via.placeholder.com/400x250?text=Sin+Imagen';
        fecha.textContent = data.fecha
            ? new Date(data.fecha).toLocaleDateString('es-CO', { day: '2-digit', month: 'short', year: 'numeric' })
            : '—';

        modal.classList.remove('hidden');
        modal.classList.add('flex');
        document.body.style.overflow = 'hidden';
    } catch (error) {
        console.error('Error al cargar la habilidad:', error);
    }
}

document.getElementById('close-modal-habilidad').addEventListener('click', () => {
    const modal = document.getElementById('modal-habilidad');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
    document.body.style.overflow = 'auto';
});
</script>
