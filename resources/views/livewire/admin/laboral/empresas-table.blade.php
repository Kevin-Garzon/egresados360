<div class="space-y-2">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-3">

        {{-- Buscador --}}
        <div class="relative w-full sm:w-1/3">
            <i class="fa-solid fa-magnifying-glass text-gray-400 absolute left-3 top-2.5"></i>
            <input
                type="text"
                wire:model.live="search"
                placeholder="Buscar por nombre o sector..."
                class="w-full pl-9 pr-3 py-2 rounded-lg border border-gray-300 text-sm focus:ring-primary focus:border-primary" />
        </div>

        {{-- Botón de exportar empresas --}}
        <a href="{{ route('exportar.empresas') }}"
            class="inline-flex items-center gap-2 px-4 py-2 bg-primary text-white text-sm font-medium rounded-lg shadow-sm hover:bg-green-700 focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition w-auto self-start sm:self-auto">
            <i class="fa-solid fa-file-arrow-down"></i> Exportar
        </a>
    </div>


    {{-- Tabla --}}
    <div class="overflow-x-auto">
        <table class="min-w-full text-sm text-gray-700 border border-gray-200 rounded-2xl overflow-hidden">
            <thead class="bg-gray-100 text-gray-600 uppercase text-xs">
                <tr>
                    <th class="px-5 py-3 text-left font-semibold">Empresa</th>
                    <th class="px-5 py-3 text-left font-semibold">Sector</th>
                    <th class="px-5 py-3 text-left font-semibold">Sitio web</th>
                    <th class="px-5 py-3 text-center font-semibold">Ofertas</th>
                    <th class="px-5 py-3 text-right font-semibold">Acciones</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-100 bg-white">
                @forelse ($empresas as $empresa)
                <tr class="hover:bg-gray-50 transition-colors duration-150">
                    {{-- Empresa (logo + nombre) --}}
                    <td class="px-5 py-3 whitespace-nowrap font-medium text-gray-800">
                        <div class="flex items-center gap-3">
                            @if(!empty($empresa->logo))
                            <img
                                src="{{ asset('storage/' . $empresa->logo) }}"
                                alt="{{ $empresa->nombre }}"
                                class="h-8 w-8 rounded object-contain ring-1 ring-gray-200 bg-white">
                            @else
                            <div class="h-8 w-8 flex items-center justify-center rounded bg-gray-100 text-gray-400">
                                <i class="fa-solid fa-building"></i>
                            </div>
                            @endif
                            <span>{{ $empresa->nombre }}</span>
                        </div>
                    </td>

                    {{-- Sector --}}
                    <td class="px-5 py-3 whitespace-nowrap">
                        {{ $empresa->sector ?? '—' }}
                    </td>

                    {{-- Sitio web (muestra host si hay URL) --}}
                    <td class="px-5 py-3 whitespace-nowrap">
                        @php
                        $url = $empresa->url ?? ($empresa->sitio_web ?? null);
                        $host = $url ? parse_url($url, PHP_URL_HOST) : null;
                        @endphp
                        @if($url)
                        <a href="{{ $url }}" target="_blank" class="text-primary hover:underline">
                            {{ $host ?: $url }}
                        </a>
                        @else
                        —
                        @endif
                    </td>

                    {{-- Ofertas: activas / total --}}
                    <td class="px-5 py-3 text-center whitespace-nowrap">
                        <span class="inline-flex items-center px-2 py-1 text-xs font-medium text-green-700 bg-green-100 rounded-full">
                            {{ $empresa->ofertas_activas_count ?? 0 }} activas
                        </span>
                        <span class="mx-1 text-gray-400">/</span>
                        <span class="inline-flex items-center px-2 py-1 text-xs font-medium text-gray-700 bg-gray-100 rounded-full">
                            {{ $empresa->ofertas_count ?? 0 }} total
                        </span>
                    </td>

                    {{-- Acciones (se conectarán a modales en el siguiente paso) --}}
                    <td class="px-5 py-3 whitespace-nowrap text-right">
                        <button wire:click="edit({{ $empresa->id }})"
                            class="text-[#09B451] hover:text-green-700 font-medium transition">
                            Editar
                        </button>
                        <span class="mx-1 text-gray-400">|</span>
                        <button wire:click="confirmDelete({{ $empresa->id }})"
                            class="text-red-500 hover:text-red-700 font-medium transition">
                            Eliminar
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-5 py-4 text-center text-gray-500">
                        No hay empresas registradas.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Paginación --}}
    <div class="pt-4">
        {{ $empresas->links() }}
    </div>
</div>