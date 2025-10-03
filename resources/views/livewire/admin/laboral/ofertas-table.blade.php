<div class="overflow-x-auto">
    <p>Ofertas cargadas: {{ $ofertas->count() }}</p>

    <table class="min-w-full text-sm">
        <thead>
            <tr class="text-left text-gray-500 border-b">
                <th class="py-3 pr-4">Título</th>
                <th class="py-3 pr-4">Empresa</th>
                <th class="py-3 pr-4">Ubicación</th>
                <th class="py-3 pr-4">Publicada</th>
                <th class="py-3 pr-4">Estado</th>
                <th class="py-3 pr-4">Acciones</th>
            </tr>
        </thead>
        <tbody class="divide-y">
            @forelse($ofertas as $oferta)
                <tr>
                    <td>{{ $oferta->titulo }}</td>
                    <td>{{ optional($oferta->empresa)->nombre ?? '—' }}</td>
                    <td>{{ $oferta->ubicacion ?? '—' }}</td>
                    <td>{{ optional($oferta->publicada_en)->format('Y-m-d') ?? '—' }}</td>
                    <td>{{ $oferta->activo ? 'Activa' : 'Inactiva' }}</td>
                    <td>
                        <button class="text-green-600">Editar</button>
                        <button class="text-red-600">Eliminar</button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">Aún no hay ofertas registradas.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="mt-4">
        {{ $ofertas->links() }}
    </div>
</div>
