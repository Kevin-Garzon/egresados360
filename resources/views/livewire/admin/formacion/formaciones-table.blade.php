<div class="space-y-4">
    {{-- Buscador --}}
    <div class="flex items-center justify-between">
        <div class="relative w-full sm:w-1/3">
            <i class="fa-solid fa-magnifying-glass text-gray-400 absolute left-3 top-2.5"></i>
            <input
                type="text"
                wire:model.live="search"
                placeholder="Buscar por título, programa o modalidad..."
                class="w-full pl-9 pr-3 py-2 rounded-lg border border-gray-300 text-sm focus:ring-primary focus:border-primary" />
        </div>
    </div>

    {{-- Tabla --}}
    <div class="overflow-x-auto">
        <table class="min-w-full text-sm text-gray-700 border border-gray-200 rounded-2xl overflow-hidden">
            <thead class="bg-gray-100 text-gray-600 uppercase text-xs">
                <tr>
                    <th class="px-5 py-3 text-left font-semibold">Título</th>
                    <th class="px-5 py-3 text-left font-semibold">Entidad</th>
                    <th class="px-5 py-3 text-left font-semibold">Programa</th>
                    <th class="px-5 py-3 text-left font-semibold">Modalidad</th>
                    <th class="px-5 py-3 text-left font-semibold">Tipo</th>
                    <th class="px-5 py-3 text-left font-semibold">Inicio</th>
                    <th class="px-5 py-3 text-left font-semibold">Fin</th>
                    <th class="px-5 py-3 text-left font-semibold">Costo</th>
                    <th class="px-5 py-3 text-center font-semibold">Estado</th>
                    {{-- NUEVA COLUMNA --}}
                    <th class="px-5 py-3 text-center font-semibold">Interacciones</th>
                    <th class="px-5 py-3 text-right font-semibold">Acciones</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-100 bg-white">
                @forelse ($formaciones as $f)
                <tr class="hover:bg-gray-50 transition-colors duration-150">
                    <td class="px-5 py-3 whitespace-nowrap font-medium text-gray-800">
                        {{ $f->titulo }}
                    </td>
                    <td class="px-5 py-3 whitespace-nowrap">
                        {{ $f->empresa ? $f->empresa->nombre : '—' }}
                    </td>
                    <td class="px-5 py-3 whitespace-nowrap">
                        {{ $f->programa ?? '—' }}
                    </td>
                    <td class="px-5 py-3 whitespace-nowrap">
                        {{ $f->modalidad ?? '—' }}
                    </td>
                    <td class="px-5 py-3 whitespace-nowrap">
                        {{ $f->tipo ?? '—' }}
                    </td>
                    <td class="px-5 py-3 whitespace-nowrap text-gray-600">
                        {{ $f->fecha_inicio ? \Carbon\Carbon::parse($f->fecha_inicio)->format('Y-m-d') : '—' }}
                    </td>
                    <td class="px-5 py-3 whitespace-nowrap text-gray-600">
                        {{ $f->fecha_fin ? \Carbon\Carbon::parse($f->fecha_fin)->format('Y-m-d') : '—' }}
                    </td>
                    <td class="px-5 py-3 whitespace-nowrap text-gray-700">
                        @if(!is_null($f->costo))
                        ${{ number_format($f->costo, 0, ',', '.') }}
                        @else
                        —
                        @endif
                    </td>
                    <td class="px-5 py-3 text-center">
                        @if ($f->activo)
                        <span class="inline-flex items-center px-2 py-1 text-xs font-medium text-green-700 bg-green-100 rounded-full">
                            Activo
                        </span>
                        @else
                        <span class="inline-flex items-center px-2 py-1 text-xs font-medium text-red-700 bg-red-100 rounded-full">
                            Inactivo
                        </span>
                        @endif
                    </td>
                    {{-- NUEVA CELDA --}}
                    <td class="px-5 py-3 text-center text-gray-700">
                        {{ $f->interacciones ?? 0 }}
                    </td>
                    <td class="px-5 py-3 whitespace-nowrap text-right">
                        <button wire:click="openEdit({{ $f->id }})"
                            class="text-[#09B451] hover:text-green-700 font-medium transition">
                            Editar
                        </button>
                        <span class="mx-1 text-gray-400">|</span>
                        <button wire:click="$dispatch('confirm-delete-formacion', { id: {{ $f->id }} })"
                            class="text-red-500 hover:text-red-700 font-medium transition">
                            Eliminar
                        </button>

                    </td>
                </tr>
                @empty
                <tr>
                    {{-- ajusta el colspan de 9 -> 10 por la nueva columna --}}
                    <td colspan="10" class="px-5 py-4 text-center text-gray-500">
                        No hay programas registrados.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Paginación --}}
    <div class="pt-4">
        {{ $formaciones->links() }}
    </div>
</div>