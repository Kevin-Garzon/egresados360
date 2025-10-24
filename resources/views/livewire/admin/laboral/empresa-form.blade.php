<div wire:ignore.self>
    @if($isOpen)
    <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
        {{-- Backdrop --}}
        <div class="fixed inset-0 bg-black/40 z-40" wire:click="close"></div>

        {{-- Modal --}}
        <div class="relative z-50 bg-white rounded-lg shadow-xl w-full max-w-lg max-h-[80vh] overflow-hidden flex flex-col">
            {{-- Header --}}
            <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                <div>
                    <h3 class="text-2xl font-semibold text-primary">
                        {{ $isEdit ? 'Editar Empresa' : 'Agregar Empresa' }}
                    </h3>
                    <p class="text-sm text-gray-500">Complete los campos para registrar la empresa</p>
                </div>
                <button type="button" class="text-gray-400 hover:text-gray-600" wire:click="close">
                    <i class="fa-solid fa-xmark text-xl"></i>
                </button>
            </div>

            {{-- Formulario --}}
            <form wire:key="empresa-form-{{ $isEdit ? $empresa_id : 'new' }}" wire:submit.prevent="save" class="px-6 py-4 overflow-y-auto flex-1 space-y-4">
                {{-- Nombre --}}
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Nombre</label>
                    <input type="text" wire:model.defer="nombre"
                        class="w-full rounded-lg border-gray-300 focus:border-primary focus:ring-primary">
                    @error('nombre') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                {{-- Sector --}}
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Sector</label>
                    <input type="text" wire:model.defer="sector"
                        class="w-full rounded-lg border-gray-300 focus:border-primary focus:ring-primary">
                    @error('sector') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                {{-- URL --}}
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Sitio web</label>
                    <input type="url" wire:model.defer="url" placeholder="https://empresa.com"
                        class="w-full rounded-lg border-gray-300 focus:border-primary focus:ring-primary">
                    @error('url') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                {{-- Descripción --}}
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Descripción</label>
                    <textarea rows="3" wire:model.defer="descripcion"
                        class="w-full rounded-lg border-gray-300 focus:border-primary focus:ring-primary"></textarea>
                    @error('descripcion') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                {{-- Logo --}}
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Logo (opcional)</label>
                    <input type="file" wire:model="logo" accept="image/*"
                        class="w-full rounded-lg border-gray-300 focus:border-primary focus:ring-primary">
                    @error('logo') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror

                    {{-- Mostrar logo existente --}}
                    @if ($existingLogo && !$logo)
                    <p class="text-xs text-gray-500 mt-1 truncate">
                        Archivo actual: {{ basename($existingLogo) }}
                    </p>
                    @endif

                    {{-- Vista previa si se carga uno nuevo --}}
                    @if ($logo)
                    <div class="mt-2">
                        <p class="text-xs text-gray-500 mb-1">Vista previa:</p>
                        <img src="{{ $logo->temporaryUrl() }}" class="h-12 mt-1 object-contain ring-1 ring-gray-200 rounded bg-white">
                    </div>
                    @endif
                </div>


                {{-- Botones --}}
                <div class="pt-4 border-t border-gray-200 flex justify-center gap-4">
                    <button type="submit" class="px-4 py-2 rounded-lg bg-primary text-white hover:bg-primary/90">
                        {{ $isEdit ? 'Actualizar' : 'Guardar' }}
                    </button>
                    <button type="button" wire:click="close"
                        class="px-4 py-2 rounded-lg bg-gray-200 hover:bg-gray-300 text-gray-700">
                        Cancelar
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endif
</div>