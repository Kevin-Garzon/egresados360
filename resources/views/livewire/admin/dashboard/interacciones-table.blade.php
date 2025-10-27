<div class="bg-white rounded-2xl shadow p-6 mt-8">

    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-4 gap-3">
        <h4 class="text-lg font-semibold text-rblack">Interacciones registradas</h4>

        {{-- Filtros --}}
        <div class="flex flex-wrap gap-3">
            <select wire:model.live="filtroModulo" class="border-gray-300 rounded-md text-sm">
                <option value="">Todos los módulos</option>
                <option value="laboral">Laboral</option>
                <option value="formacion">Formación</option>
                <option value="bienestar">Bienestar</option>
            </select>

            <select wire:model.live="filtroIdentificacion" class="border-gray-300 rounded-md text-sm">
                <option value="">Todos</option>
                <option value="identificado">Identificados</option>
                <option value="anonimo">Anónimos</option>
            </select>
        </div>
    </div>

    {{-- Tabla --}}
    <div class="overflow-x-auto">
        <table class="min-w-full text-sm border border-gray-200 rounded-lg">
            <thead class="bg-gray-100 text-gray-700 font-semibold">
                <tr>
                    <th class="px-3 py-2 text-left">Fecha</th>
                    <th class="px-3 py-2 text-left">Módulo</th>
                    <th class="px-3 py-2 text-left">Acción</th>
                    <th class="px-3 py-2 text-left">Ítem</th>
                    <th class="px-3 py-2 text-left">Egresado</th>
                    <th class="px-3 py-2 text-left">Correo</th>
                    <th class="px-3 py-2 text-left">Teléfono</th>
                    <th class="px-3 py-2 text-left">Programa</th>
                    <th class="px-3 py-2 text-left">Año</th>
                    <th class="px-3 py-2 text-left">Estado</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($interacciones as $i)
                    <tr class="border-t hover:bg-gray-50">
                        <td class="px-3 py-2 text-gray-600">
                            {{ $i->created_at->format('d/m/Y H:i') }}
                        </td>
                        <td class="px-3 py-2 capitalize">{{ $i->module }}</td>
                        <td class="px-3 py-2">{{ $i->action }}</td>
                        <td class="px-3 py-2">{{ $i->item_title ?? '—' }}</td>
                        <td class="px-3 py-2">{{ $i->perfil->nombre ?? '—' }}</td>
                        <td class="px-3 py-2">{{ $i->perfil->correo ?? '—' }}</td>
                        <td class="px-3 py-2">{{ $i->perfil->celular ?? '—' }}</td>
                        <td class="px-3 py-2">{{ $i->perfil->programa ?? '—' }}</td>
                        <td class="px-3 py-2">{{ $i->perfil->anio_egreso ?? '—' }}</td>
                        <td class="px-3 py-2">
                            @if ($i->perfil_id)
                                <span class="text-green-600 font-medium">Identificado</span>
                            @else
                                <span class="text-gray-500">Anónimo</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="text-center text-gray-500 py-4">No hay interacciones registradas.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Paginación --}}
    <div class="mt-4">
        {{ $interacciones->links() }}
    </div>

</div>
