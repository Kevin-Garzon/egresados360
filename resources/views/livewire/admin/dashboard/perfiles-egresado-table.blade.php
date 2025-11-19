<div class="space-y-4">

    {{-- Encabezado y filtros --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <h4 class="text-lg font-poppins font-semibold text-rblack">Egresados registrados</h4>

        <div class="flex flex-col sm:flex-row sm:items-center gap-3">
            {{-- Buscador --}}
            <input
                type="text"
                wire:model.live="buscar"
                placeholder="Buscar por nombre o correo..."
                class="border border-gray-300 rounded-lg px-3 py-1.5 text-sm w-60 focus:ring-2 focus:ring-primary/40 focus:border-primary transition" />

            {{-- Filtro por programa --}}
            <select wire:model.live="filtroPrograma"
                class="border border-gray-300 rounded-lg px-3 py-1.5 text-sm focus:ring-2 focus:ring-primary/40 focus:border-primary transition">
                <option value="">Todos los programas</option>
                <option value="Ingeniería de Software">Ingeniería de Software</option>
                <option value="Ingeniería de Alimentos">Ingeniería de Alimentos</option>
                <option value="Ingeniería Eléctrica">Ingeniería Eléctrica</option>
                <option value="Ingeniería Ambiental">Ingeniería Ambiental</option>
                <option value="Salud Ocupacional">Salud Ocupacional</option>
                <option value="Administración de Negocios">Administración de Negocios</option>
            </select>
        </div>
    </div>

    {{-- Tabla --}}
    <div class="overflow-x-auto rounded-2xl border border-gray-200 shadow-sm">
        <table class="min-w-full text-sm">
            <thead class="bg-gray-50 text-gray-700 font-semibold uppercase text-xs tracking-wide">
                <tr>
                    <th class="px-4 py-3 text-left">Nombre</th>
                    <th class="px-4 py-3 text-left">Correo</th>
                    <th class="px-4 py-3 text-left">Celular</th>
                    <th class="px-4 py-3 text-left">Programa</th>
                    <th class="px-4 py-3 text-left">Año</th>
                    <th class="px-4 py-3 text-left">Registrado en</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse ($perfiles as $perfil)
                <tr class="hover:bg-primary/5 cursor-pointer transition-colors"
                    wire:click="verHistorial('{{ $perfil->correo }}')">
                    <td class="px-4 py-2">{{ $perfil->nombre }}</td>
                    <td class="px-4 py-2">{{ $perfil->correo }}</td>
                    <td class="px-4 py-2">{{ $perfil->celular ?? '—' }}</td>
                    <td class="px-4 py-2">{{ $perfil->programa ?? '—' }}</td>
                    <td class="px-4 py-2">{{ $perfil->anio_egreso ?? '—' }}</td>
                    <td class="px-4 py-2 text-gray-600">
                        {{ \Carbon\Carbon::parse($perfil->created_at)->setTimezone('America/Bogota')->format('d/m/Y H:i') }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-gray-500 py-5">No hay egresados registrados aún.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Paginación --}}
    <div class="mt-3">
        {{ $perfiles->links('pagination::simple-tailwind') }}
    </div>

    {{-- Modal de historial --}}
    @if($mostrarHistorial && $egresadoSeleccionado)
    <div
        class="fixed inset-0 bg-black/50 backdrop-blur-sm z-[9999] flex items-center justify-center"
        style="position: fixed !important;">
        {{-- Contenedor principal del modal --}}
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-3xl p-6 max-h-[85vh] overflow-hidden flex flex-col">

            {{-- TÍTULO --}}
            <div class="flex justify-between items-start mb-4">
                <div>
                    <h2 class="text-xl font-semibold text-gray-800">
                        Historial de interacciones de
                        <span class="text-primary">{{ $egresadoSeleccionado->nombre }}</span>
                    </h2>

                    <p class="text-gray-600">
                        Correo: <strong>{{ $egresadoSeleccionado->correo }}</strong>
                    </p>
                </div>

                {{-- Cerrar --}}
                <button
                    wire:click="$set('mostrarHistorial', false)"
                    class="text-gray-500 hover:text-gray-700 text-xl">
                    ✕
                </button>
            </div>

            {{-- CONTENIDO SCROLLEABLE (tablas, etc.) --}}
            <div class="overflow-y-auto pr-2" style="max-height: 70vh;">
                <table class="w-full text-sm border border-gray-200 rounded-lg">
                    <thead class="bg-gray-100 text-gray-700 uppercase text-xs">
                        <tr>
                            <th class="px-3 py-2 text-left">Fecha</th>
                            <th class="px-3 py-2 text-left">Módulo</th>
                            <th class="px-3 py-2 text-left">Acción</th>
                            <th class="px-3 py-2 text-left">Ítem</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-200">
                        @forelse($historial as $h)
                        <tr>
                            <td class="px-3 py-2">
                                {{ $h->created_at->setTimezone('America/Bogota')->format('d/m/Y H:i') }}
                            </td>
                            <td class="px-3 py-2 capitalize">{{ $h->module }}</td>
                            <td class="px-3 py-2">{{ $h->action }}</td>
                            <td class="px-3 py-2">{{ $h->item_title ?? '—' }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center text-gray-500 py-4">
                                No tiene interacciones registradas.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- BOTÓN CERRAR --}}
            <div class="flex justify-end mt-4">
                <button
                    wire:click="$set('mostrarHistorial', false)"
                    class="px-4 py-2 bg-gray-200 rounded-lg text-gray-700 hover:bg-gray-300">
                    Cerrar
                </button>
            </div>
        </div>
    </div>
    @endif


</div>