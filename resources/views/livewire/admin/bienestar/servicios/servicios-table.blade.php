<div class="space-y-4">
    <div class="flex items-center justify-between mb-3">

        {{-- Buscador --}}
        <div class="relative w-full sm:w-1/3">
            <i class="fa-solid fa-magnifying-glass text-gray-400 absolute left-3 top-2.5"></i>
            <input
                type="text"
                wire:model.live="search"
                placeholder="Buscar por nombre o tipo..."
                class="w-full pl-9 pr-3 py-2 rounded-lg border border-gray-300 text-sm focus:ring-primary focus:border-primary" />
        </div>

        {{-- Botón de exportar servicios --}}
        <a href="{{ route('exportar.servicios') }}"
            class="inline-flex items-center gap-2 px-4 py-2 bg-primary text-white text-sm font-medium rounded-lg shadow-sm hover:bg-green-700 focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition">
            <i class="fa-solid fa-file-arrow-down"></i> Exportar
        </a>
    </div>


    {{-- Tabla --}}
    <div class="overflow-x-auto">
        <table class="min-w-full text-sm text-gray-700 border border-gray-200 rounded-2xl overflow-hidden">
            <thead class="bg-gray-100 text-gray-600 uppercase text-xs">
                <tr>
                    <th class="px-5 py-3 text-left font-semibold cursor-pointer" wire:click="sortBy('nombre')">Nombre</th>
                    <th class="px-5 py-3 text-left font-semibold cursor-pointer" wire:click="sortBy('tipo')">Tipo</th>
                    <th class="px-5 py-3 text-left font-semibold">Contacto</th>
                    <th class="px-5 py-3 text-left font-semibold">Ubicación</th>
                    <th class="px-5 py-3 text-center font-semibold">Estado</th>
                    <th class="px-5 py-3 text-right font-semibold">Acciones</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-100 bg-white">
                @forelse ($servicios as $s)
                <tr class="hover:bg-gray-50 transition-colors duration-150">
                    <td class="px-5 py-3 font-medium text-gray-800">{{ $s->nombre }}</td>
                    <td class="px-5 py-3">{{ $s->tipo ?? '—' }}</td>
                    <td class="px-5 py-3">{{ $s->contacto ?? '—' }}</td>
                    <td class="px-5 py-3">{{ $s->ubicacion ?? '—' }}</td>
                    <td class="px-5 py-3 text-center">
                        @if ($s->activo)
                        <span class="inline-flex items-center px-2 py-1 text-xs font-medium text-green-700 bg-green-100 rounded-full">
                            Activo
                        </span>
                        @else
                        <span class="inline-flex items-center px-2 py-1 text-xs font-medium text-red-700 bg-red-100 rounded-full">
                            Inactivo
                        </span>
                        @endif
                    </td>
                    <td class="px-5 py-3 whitespace-nowrap text-right">
                        <button wire:click="openEdit({{ $s->id }})"
                            class="text-[#09B451] hover:text-green-700 font-medium transition">
                            Editar
                        </button>
                        <span class="mx-1 text-gray-400">|</span>
                        <button wire:click="delete({{ $s->id }})"
                            class="text-red-500 hover:text-red-700 font-medium transition">
                            Eliminar
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-5 py-4 text-center text-gray-500">
                        No hay servicios registrados.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Paginación --}}
    <div class="pt-4">
        {{ $servicios->links() }}
    </div>
</div>