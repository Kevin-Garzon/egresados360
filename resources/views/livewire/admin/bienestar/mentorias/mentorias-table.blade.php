<div class="space-y-4">
    {{-- BUSCADOR --}}
    <div class="flex items-center justify-between">
        <div class="relative w-full sm:w-1/3">
            <i class="fa-solid fa-magnifying-glass text-gray-400 absolute left-3 top-2.5"></i>
            <input type="text" wire:model.live="search"
                placeholder="Buscar mentoría por título o descripción..."
                class="w-full pl-9 pr-3 py-2 rounded-lg border border-gray-300 text-sm focus:ring-primary focus:border-primary" />
        </div>
    </div>

    {{-- TABLA --}}
    <div class="overflow-x-auto">
        <table class="min-w-full text-sm text-gray-700 border border-gray-200 rounded-2xl overflow-hidden">
            <thead class="bg-gray-100 text-gray-600 uppercase text-xs">
                <tr>
                    <th class="px-5 py-3 text-left font-semibold">Título</th>
                    <th class="px-5 py-3 text-left font-semibold">Descripción</th>
                    <th class="px-5 py-3 text-left font-semibold">Icono</th>
                    <th class="px-5 py-3 text-center font-semibold">Estado</th>
                    <th class="px-5 py-3 text-right font-semibold">Acciones</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-100 bg-white">
                @forelse ($mentorias as $m)
                <tr class="hover:bg-gray-50 transition-colors duration-150">
                    <td class="px-5 py-3 font-medium text-gray-800">{{ $m->titulo }}</td>
                    <td class="px-5 py-3 text-gray-600 truncate max-w-xs">{{ $m->descripcion ?? '—' }}</td>
                    <td class="px-5 py-3 text-primary"><i class="fa-solid {{ $m->icono }}"></i></td>
                    <td class="px-5 py-3 text-center">
                        @if ($m->activo)
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
                        <button wire:click="openEdit({{ $m->id }})"
                            class="text-[#09B451] hover:text-green-700 font-medium transition">
                            Editar
                        </button>
                        <span class="mx-1 text-gray-400">|</span>
                        <button wire:click="delete({{ $m->id }})"
                            class="text-red-500 hover:text-red-700 font-medium transition">
                            Eliminar
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-5 py-4 text-center text-gray-500">No hay mentorías registradas.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- PAGINACIÓN --}}
    <div class="pt-4">
        {{ $mentorias->links() }}
    </div>
</div>
