<div class="space-y-2">

    {{-- Tabla sin contenedor adicional --}}
    <div class="overflow-x-auto">
        <table class="min-w-full text-sm text-gray-700 border border-gray-200 rounded-2xl overflow-hidden">
            <thead class="bg-gray-100 text-gray-600 uppercase text-xs">
                <tr>
                    <th class="px-5 py-3 text-left font-semibold">Título</th>
                    <th class="px-5 py-3 text-left font-semibold">Empresa</th>
                    <th class="px-5 py-3 text-left font-semibold">Ubicación</th>
                    <th class="px-5 py-3 text-left font-semibold">Publicada</th>
                    <th class="px-5 py-3 text-center font-semibold">Estado</th>
                    <th class="px-5 py-3 text-right font-semibold">Acciones</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-100 bg-white">
                @forelse ($ofertas as $oferta)
                    <tr class="hover:bg-gray-50 transition-colors duration-150">
                        <td class="px-5 py-3 whitespace-nowrap font-medium text-gray-800">
                            {{ $oferta->titulo }}
                        </td>
                        <td class="px-5 py-3 whitespace-nowrap">
                            {{ optional($oferta->empresa)->nombre ?? '—' }}
                        </td>
                        <td class="px-5 py-3 whitespace-nowrap">
                            {{ $oferta->ubicacion ?? '—' }}
                        </td>
                        <td class="px-5 py-3 whitespace-nowrap text-gray-600">
                            {{ optional($oferta->publicada_en)->format('Y-m-d') ?? '—' }}
                        </td>
                        <td class="px-5 py-3 text-center">
                            @if ($oferta->activo)
                                <span class="inline-flex items-center px-2 py-1 text-xs font-medium text-green-700 bg-green-100 rounded-full">
                                    Activa
                                </span>
                            @else
                                <span class="inline-flex items-center px-2 py-1 text-xs font-medium text-red-700 bg-red-100 rounded-full">
                                    Inactiva
                                </span>
                            @endif
                        </td>
                        <td class="px-5 py-3 whitespace-nowrap text-right">
                            <button wire:click="edit({{ $oferta->id }})"
                                class="text-[#09B451] hover:text-green-700 font-medium transition">
                                Editar
                            </button>
                            <span class="mx-1 text-gray-400">|</span>
                            <button wire:click="confirmDelete({{ $oferta->id }})"
                                class="text-red-500 hover:text-red-700 font-medium transition">
                                Eliminar
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-5 py-4 text-center text-gray-500">
                            No hay ofertas registradas.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Paginación --}}
    <div class="pt-4">
        {{ $ofertas->links() }}
    </div>
</div>
