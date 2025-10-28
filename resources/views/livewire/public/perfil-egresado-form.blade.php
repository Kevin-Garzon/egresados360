<div x-data="{ open: @entangle('mostrarModal').live }">
    <div
        x-show="open"
        class="fixed inset-0 bg-black/40 flex items-center justify-center z-50"
        x-cloak>
        <div class="bg-white w-full max-w-md p-6 rounded-2xl shadow-lg">
            <h2 class="text-xl font-poppins font-semibold text-rblack mb-4">Registra tus datos</h2>
            <p class="text-sm text-gray-600 mb-4">
                Estos datos se usarán solo para contactarte con oportunidades o actividades de la FET.
            </p>

            <form wire:submit.prevent="guardarPerfil" class="space-y-3">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Nombre completo</label>
                    <input type="text" wire:model.defer="nombre" class="w-full border-gray-300 rounded-md" required>
                    @error('nombre') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Correo electrónico</label>
                    <input type="email" wire:model.defer="correo" class="w-full border-gray-300 rounded-md" required>
                    @error('correo') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Celular</label>
                    <input type="text" wire:model.defer="celular" class="w-full border-gray-300 rounded-md">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Programa</label>
                    <select wire:model.defer="programa" class="w-full border-gray-300 rounded-md" required>
                        <option value="">Seleccione su programa</option>
                        <option value="Ingeniería de Software">Ingeniería de Software</option>
                        <option value="Ingeniería de Alimentos">Ingeniería de Alimentos</option>
                        <option value="Ingeniería Eléctrica">Ingeniería Eléctrica</option>
                        <option value="Ingeniería Ambiental">Ingeniería Ambiental</option>
                        <option value="Salud Ocupacional">Administración de la SST</option>
                        <option value="Administración de Negocios">Administración de Negocios</option>
                    </select>
                    @error('programa') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>


                <div>
                    <label class="block text-sm font-medium text-gray-700">Año de egreso</label>
                    <input type="number" wire:model.defer="anio_egreso" class="w-full border-gray-300 rounded-md" min="2000" max="{{ date('Y') }}">
                </div>

                <div class="flex justify-end gap-2 mt-4">
                    <button type="button" @click="open = false" class="text-gray-600 hover:text-gray-800">Cancelar</button>
                    <button type="submit" class="bg-primary text-white px-4 py-2 rounded-md hover:bg-primary/90">Guardar</button>
                </div>
            </form>

            <p class="text-xs text-gray-500 mt-4">
                Al continuar, aceptas la
                <a href="{{ route('politica-datos') }}"
                    target="_blank"
                    class="text-primary underline hover:text-green-700 transition">
                    Política de Tratamiento de Datos
                </a>.
            </p>

        </div>
    </div>
</div>