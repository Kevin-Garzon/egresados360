<div class="card p-4">
    {{-- Filtros / búsqueda --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-4">
        <input type="text" wire:model.live="search" placeholder="Buscar por título, descripción o tema"
               class="card px-3 py-2 w-full sm:max-w-sm">

        <div class="flex items-center gap-2">
            <select wire:model.live="estado" class="card px-3 py-2">
                <option value="todas">Todas</option>
                <option value="activas">Activas</option>
                <option value="inactivas">Inactivas</option>
            </select>
            <select wire:model.live="orden" class="card px-3 py-2">
                <option value="fecha_desc">Fecha ↓</option>
                <option value="fecha_asc">Fecha ↑</option>
                <option value="titulo_asc">Título A–Z</option>
            </select>
        </div>
    </div>

    {{-- Tabla --}}
    <div class="overflow-x-auto">
        <table class="min-w-full">
            <thead class="text-left text-sm text-rblack/60">
                <tr>
                    <th class="py-2 pr-3">Título</th>
                    <th class="py-2 pr-3">Tema</th>
                    <th class="py-2 pr-3">Modalidad</th>
                    <th class="py-2 pr-3">Fecha</th>
                    <th class="py-2 pr-3">Estado</th>
                    <th class="py-2 pr-3 text-right">Acciones</th>
                </tr>
            </thead>
            <tbody class="text-sm">
                @forelse($habilidades as $h)
                <tr class="border-t border-gray-100">
                    <td class="py-3 pr-3 font-medium">{{ $h->titulo }}</td>
                    <td class="py-3 pr-3">{{ $h->tema ?? '—' }}</td>
                    <td class="py-3 pr-3">{{ $h->modalidad ?? '—' }}</td>
                    <td class="py-3 pr-3">{{ optional($h->fecha)->format('d M Y') ?? '—' }}</td>
                    <td class="py-3 pr-3">
                        @if($h->activo)
                            <span class="badge">Publicado</span>
                        @else
                            <span class="badge">Borrador</span>
                        @endif
                    </td>
                    <td class="py-3 pr-3">
                        <div class="flex items-center justify-end gap-2">
                            <button class="btn px-3 py-1"
                                    wire:click="$dispatch('editar-habilidad', { id: {{ $h->id }} })">
                                <i class="fa-solid fa-pen mr-1"></i> Editar
                            </button>
                            <button class="btn px-3 py-1"
                                    wire:click="$dispatch('eliminar-habilidad', { id: {{ $h->id }} })">
                                <i class="fa-solid fa-trash mr-1"></i> Eliminar
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr class="border-t border-gray-100">
                    <td colspan="6" class="py-6 text-center text-rblack/60">Sin registros.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $habilidades->links() }}
    </div>
</div>
