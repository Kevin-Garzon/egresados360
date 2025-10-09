<div>
    @if($isOpen)
    <div class="fixed inset-0 z-50 flex items-center justify-center p-4">

        {{-- Backdrop + modal en un solo root --}}
        <div class="fixed inset-0 bg-black/40 z-40" wire:click="close"></div>

        <div class="relative z-50 bg-white rounded-lg shadow-xl w-full max-w-lg max-h-[80vh] overflow-hidden flex flex-col">

            {{-- Header --}}
            <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                <div>
                    <h3 class="text-2xl font-semibold text-primary">
                        {{ $isEdit ? 'Editar Empleo' : 'Agregar Empleo' }}
                    </h3>
                    <p class="text-sm text-gray-500">Complete los campos para registrar una nueva oferta laboral</p>
                </div>
                <button type="button" class="text-gray-400 hover:text-gray-600" wire:click="close">
                    <i class="fa-solid fa-xmark text-xl"></i>
                </button>
            </div>

            {{-- Formulario --}}
            <form wire:submit.prevent="save" class="px-6 py-4 overflow-y-auto flex-1 space-y-4">
                {{-- Empresa --}}
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Empresa</label>
                    <select wire:model="empresa_id" class="w-full rounded-lg border-gray-300 focus:border-primary focus:ring-primary">
                        <option value="">-- Selecciona una empresa --</option>
                        @foreach($empresas as $empresa)
                        <option value="{{ $empresa->id }}">{{ $empresa->nombre }}</option>
                        @endforeach
                    </select>
                    @error('empresa_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                {{-- Título --}}
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Título</label>
                    <input type="text" wire:model="titulo" class="w-full rounded-lg border-gray-300 focus:border-primary focus:ring-primary">
                    @error('titulo') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                {{-- Descripción --}}
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Descripción</label>
                    <textarea wire:model="descripcion" rows="3" class="w-full rounded-lg border-gray-300 focus:border-primary focus:ring-primary"></textarea>
                </div>

                {{-- Ubicación --}}
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Ubicación</label>
                    <input type="text" wire:model="ubicacion" class="w-full rounded-lg border-gray-300 focus:border-primary focus:ring-primary">
                </div>

                {{-- Etiquetas --}}
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Etiquetas</label>
                    <input type="text" wire:model="etiquetas" placeholder="Ej: Laravel, Remoto, Junior" class="w-full rounded-lg border-gray-300 focus:border-primary focus:ring-primary">
                </div>

                {{-- URL Externa --}}
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">URL Externa</label>
                    <input type="url" wire:model="url_externa" class="w-full rounded-lg border-gray-300 focus:border-primary focus:ring-primary">
                    @error('url_externa') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                {{-- Fechas --}}
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-600 mb-1">Publicación</label>
                        <input type="date" wire:model="publicada_en" class="w-full rounded-lg border-gray-300 focus:border-primary focus:ring-primary">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-600 mb-1">Cierre</label>
                        <input type="date" wire:model="fecha_cierre" class="w-full rounded-lg border-gray-300 focus:border-primary focus:ring-primary">
                    </div>
                </div>

                {{-- Activo --}}
                <div class="flex items-center">
                    <input type="checkbox" wire:model="activo" id="activo" class="rounded text-primary focus:ring-primary">
                    <label for="activo" class="ml-2 text-sm text-gray-600">Oferta activa</label>
                </div>

                {{-- Botones --}}
                <div class="pt-4 border-t border-gray-200 flex justify-center gap-4">
                    <button type="submit" class="px-4 py-2 rounded-lg bg-primary text-white hover:bg-primary/90">
                        {{ $isEdit ? 'Actualizar' : 'Guardar' }}
                    </button>
                    <button type="button"
                        wire:click="close"
                        class="px-4 py-2 rounded-lg bg-gray-200 hover:bg-gray-300 text-gray-700">
                        Cancelar
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endif
</div>