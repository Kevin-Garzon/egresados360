<div class="p-6 space-y-6">
    <h2 class="text-2xl font-poppins font-semibold text-gunmetal">
        <i class="fa-solid fa-robot mr-2 text-primary"></i> Informe Inteligente
    </h2>

    <p class="text-gray-600">
        Este módulo genera un informe automatizado sobre la actividad del portal,
        utilizando inteligencia artificial.
    </p>

    <div class="flex flex-col md:flex-row items-center gap-4">
        {{-- Filtro de periodo --}}
        <div class="relative">
            <select
                wire:model="periodo"
                class="appearance-none bg-white border border-gray-300 text-gray-700 rounded-lg px-5 py-2.5 text-sm font-medium shadow-sm hover:border-primary focus:ring-2 focus:ring-primary/40 focus:border-primary transition w-48 cursor-pointer">
                <option value="general">Informe General</option>
                <option value="mes">Último mes</option>
                <option value="semana">Última semana</option>
                <option value="dia">Último día</option>
            </select>
        </div>

        {{-- Botones --}}
        <div class="flex gap-4">
            <button
                wire:click="generarInforme"
                class="btn btn-primary flex items-center gap-2"
                wire:loading.attr="disabled">
                <i class="fa-solid fa-bolt"></i>
                <span wire:loading.remove>Generar Informe</span>
                <span wire:loading>Generando...</span>
            </button>

            @if($informe)
                <button
                    wire:click="descargarPDF"
                    class="btn bg-gray-700 text-white hover:bg-gray-800 flex items-center gap-2">
                    <i class="fa-solid fa-file-pdf"></i> Descargar PDF
                </button>
            @endif
        </div>
    </div>

    {{-- Contenedor del informe generado --}}
    @if($informe)
        <div class="bg-white border border-gray-200 rounded-2xl shadow-md px-10 py-8 mt-6 overflow-y-auto max-h-[75vh]">
            <h3 class="font-semibold text-lg mb-5 text-primary">Informe generado</h3>

            <div class="prose max-w-none text-gray-800 prose-headings:text-gunmetal prose-headings:font-semibold prose-h1:text-[1.5rem] prose-h2:text-[1.1rem] prose-p:leading-relaxed prose-p:text-[0.95rem] prose-li:text-[0.95rem] prose-h2:mt-8 prose-h3:mt-6">
                {!! $informe !!}
            </div>
        </div>
    @endif
</div>



@push('scripts')
<script>
    document.addEventListener('livewire:initialized', () => {
        window.Livewire.on('abrir-descarga', (data) => {
            if (data?.url) {
                window.open(data.url, '_blank');
            } else {
                console.error('No se recibió una URL para descargar el informe.');
            }
        });
    });
</script>
@endpush