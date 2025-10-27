<div class="bg-white rounded-2xl shadow p-6 mt-8">

    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-4 gap-3">
        <h4 class="text-lg font-semibold text-rblack">Egresados registrados</h4>

        {{-- Filtro por programa --}}
        <div>
            <select wire:model.live="filtroPrograma" class="border-gray-300 rounded-md text-sm">
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
    <div class="overflow-x-auto">
        <table class="min-w-full text-sm border border-gray-200 rounded-lg">
            <thead class="bg-gray-100 text-gray-700 font-semibold">
                <tr>
                    <th class="px-3 py-2 text-left">Nombre</th>
                    <th class="px-3 py-2 text-left">Correo</th>
                    <th class="px-3 py-2 text-left">Celular</th>
                    <th class="px-3 py-2 text-left">Programa</th>
                    <th class="px-3 py-2 text-left">Año</th>
                    <th class="px-3 py-2 text-left">Registrado en</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($perfiles as $perfil)
                    <tr class="border-t hover:bg-gray-50">
                        <td class="px-3 py-2">{{ $perfil->nombre }}</td>
                        <td class="px-3 py-2">{{ $perfil->correo }}</td>
                        <td class="px-3 py-2">{{ $perfil->celular ?? '—' }}</td>
                        <td class="px-3 py-2">{{ $perfil->programa ?? '—' }}</td>
                        <td class="px-3 py-2">{{ $perfil->anio_egreso ?? '—' }}</td>
                        <td class="px-3 py-2 text-gray-600">
                            {{ \Carbon\Carbon::parse($perfil->created_at)->setTimezone('America/Bogota')->format('d/m/Y H:i') }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-gray-500 py-4">No hay egresados registrados aún.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Paginación --}}
    <div class="mt-4">
        {{ $perfiles->links() }}
    </div>
</div>
