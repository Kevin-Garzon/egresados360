<div class="space-y-4">

    {{-- Encabezado y filtros --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <h4 class="text-lg font-poppins font-semibold text-rblack">Interacciones registradas</h4>

        <div class="flex flex-wrap gap-3">
            <select wire:model.live="filtroModulo" class="border border-gray-300 rounded-lg px-3 py-1.5 text-sm focus:ring-2 focus:ring-primary/40 focus:border-primary transition">
                <option value="">Todos</option>
                <option value="laboral">Laboral</option>
                <option value="formacion">Formación</option>
                <option value="bienestar">Bienestar</option>
            </select>

            <select wire:model.live="filtroIdentificacion" class="border border-gray-300 rounded-lg px-3 py-1.5 text-sm focus:ring-2 focus:ring-primary/40 focus:border-primary transition">
                <option value="">Todos</option>
                <option value="identificado">Identificados</option>
                <option value="anonimo">Anónimos</option>
            </select>
        </div>
    </div>

    {{-- Tabla --}}
    <div class="overflow-x-auto rounded-2xl border border-gray-200 shadow-sm">
        <table class="min-w-full text-sm">
            <thead class="bg-gray-50 text-gray-700 font-semibold uppercase text-xs tracking-wide">
                <tr>
                    <th class="px-4 py-3 text-left">Fecha</th>
                    <th class="px-4 py-3 text-left">Módulo</th>
                    <th class="px-4 py-3 text-left">Acción</th>
                    <th class="px-4 py-3 text-left">Ítem</th>
                    <th class="px-4 py-3 text-left">Egresado</th>
                    <th class="px-4 py-3 text-left">Correo</th>
                    <th class="px-4 py-3 text-left">Teléfono</th>
                    <th class="px-4 py-3 text-left">Programa</th>
                    <th class="px-4 py-3 text-left">Año</th>
                    <th class="px-4 py-3 text-left">Estado</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse ($interacciones as $i)
                    <tr class="hover:bg-primary/5 transition-colors">
                        <td class="px-4 py-2 text-gray-600">{{ $i->created_at->setTimezone('America/Bogota')->format('d/m/Y H:i') }}</td>
                        <td class="px-4 py-2 capitalize">{{ $i->module }}</td>
                        <td class="px-4 py-2">{{ $i->action }}</td>
                        <td class="px-4 py-2">{{ $i->item_title ?? '—' }}</td>
                        <td class="px-4 py-2">{{ $i->perfil->nombre ?? '—' }}</td>
                        <td class="px-4 py-2">{{ $i->perfil->correo ?? '—' }}</td>
                        <td class="px-4 py-2">{{ $i->perfil->celular ?? '—' }}</td>
                        <td class="px-4 py-2">{{ $i->perfil->programa ?? '—' }}</td>
                        <td class="px-4 py-2">{{ $i->perfil->anio_egreso ?? '—' }}</td>
                        <td class="px-4 py-2">
                            @if ($i->perfil_id)
                                <span class="px-2 py-1 text-xs font-medium rounded-full bg-green-100 text-green-700">Identificado</span>
                            @else
                                <span class="px-2 py-1 text-xs font-medium rounded-full bg-gray-100 text-gray-600">Anónimo</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10" class="text-center text-gray-500 py-5">No hay interacciones registradas.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Paginación --}}
    <div class="mt-3">
        {{ $interacciones->links('pagination::simple-tailwind', ['pageName' => 'interaccionesPage']) }}
    </div>


</div>
