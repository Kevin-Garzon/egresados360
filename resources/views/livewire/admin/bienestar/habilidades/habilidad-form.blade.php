<div>
    @if($isOpen)
    <div class="fixed inset-0 flex items-center justify-center bg-black/50 z-50">
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-lg relative overflow-hidden">

            <button wire:click="close"
                class="absolute top-3 right-3 text-gray-400 hover:text-primary text-xl transition">
                <i class="fa-solid fa-xmark"></i>
            </button>

            <div class="p-6 pb-4">
                <h2 class="text-xl font-semibold text-[#09B451] mb-1">
                    {{ $isEdit ? 'Editar Habilidad' : 'Nueva Habilidad' }}
                </h2>
                <p class="text-sm text-gray-500">
                    Completa los campos para registrar una habilidad para la vida.
                </p>
                <hr class="border-t border-gray-200 mt-4">
            </div>

            <div class="px-6 pb-4 max-h-[60vh] overflow-y-auto">
                <div class="space-y-4">
                    <div>
                        <label class="text-sm font-medium text-gray-600">Título *</label>
                        <input type="text" wire:model.defer="titulo"
                            class="w-full mt-1 border-gray-300 rounded-lg text-sm focus:ring-primary focus:border-primary" />
                        @error('titulo') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="text-sm font-medium text-gray-600">Tema *</label>
                        <input type="text" wire:model.defer="tema" required 
                            class="w-full mt-1 border-gray-300 rounded-lg text-sm focus:ring-primary focus:border-primary" />
                    </div>

                    <div>
                        <label class="text-sm font-medium text-gray-600">Modalidad</label>
                        <select wire:model.defer="modalidad"
                            class="w-full mt-1 border-gray-300 rounded-lg text-sm focus:ring-primary focus:border-primary">
                            <option value="">Seleccionar</option>
                            <option>Virtual</option>
                            <option>Presencial</option>
                            <option>Mixta</option>
                        </select>
                    </div>

                    <div>
                        <label class="text-sm font-medium text-gray-600">Fecha</label>
                        <input type="date" wire:model.defer="fecha"
                            class="w-full mt-1 border-gray-300 rounded-lg text-sm focus:ring-primary focus:border-primary" />
                    </div>

                    <div>
                        <label class="text-sm font-medium text-gray-600">Descripción</label>
                        <textarea wire:model.defer="descripcion" rows="3"
                            class="w-full mt-1 border-gray-300 rounded-lg text-sm focus:ring-primary focus:border-primary"></textarea>
                    </div>

                    <div>
                        <label class="text-sm font-medium text-gray-600">Imagen</label>
                        <input type="file" wire:model="imagen"
                            class="w-full mt-1 text-sm border-gray-300 rounded-lg focus:ring-primary focus:border-primary" accept="image/*">
                        <div class="mt-2">
                            @if ($imagen)
                            <img src="{{ $imagen->temporaryUrl() }}" class="h-32 rounded-lg object-cover border border-gray-200">
                            @elseif ($existingImage)
                            <img src="{{ asset('storage/'.$existingImage) }}" class="h-32 rounded-lg object-cover border border-gray-200">
                            @endif
                        </div>
                    </div>

                    <div class="flex items-center mt-2">
                        <label class="flex items-center space-x-2">
                            <input type="checkbox" wire:model.defer="activo"
                                class="rounded text-primary focus:ring-primary">
                            <span class="text-sm text-gray-700">Activo</span>
                        </label>
                    </div>
                </div>
            </div>

            <div class="px-6 py-4 border-t border-gray-200 flex justify-end gap-3">
                <button wire:click="close" type="button"
                    class="px-4 py-2 rounded-lg border border-gray-300 text-gray-600 hover:bg-gray-100 transition">
                    Cancelar
                </button>
                <button wire:click="save" type="button"
                    class="px-4 py-2 rounded-lg bg-[#09B451] text-white shadow hover:opacity-90 transition">
                    {{ $isEdit ? 'Actualizar' : 'Guardar' }}
                </button>
            </div>

        </div>
    </div>
    @endif
</div>