<div class="space-y-4">
    {{-- Buscador --}}
    <div class="flex items-center justify-between">
        <div class="relative w-full sm:w-1/3">
            <i class="fa-solid fa-magnifying-glass text-gray-400 absolute left-3 top-2.5"></i>
            <input
                type="text"
                wire:model.live="search"
                placeholder="Buscar por nombre, tipo o descripción..."
                class="w-full pl-9 pr-3 py-2 rounded-lg border border-gray-300 text-sm focus:ring-primary focus:border-primary" />
        </div>
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
