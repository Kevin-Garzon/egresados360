<div class="space-y-4">

    {{-- Encabezado y filtro --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <h4 class="text-lg font-poppins font-semibold text-rblack">Egresados registrados</h4>

        <div>
            <select wire:model.live="filtroPrograma" class="border border-gray-300 rounded-lg px-3 py-1.5 text-sm focus:ring-2 focus:ring-primary/40 focus:border-primary transition">
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
                    <tr class="hover:bg-primary/5 transition-colors">
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
</div>
