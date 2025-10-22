<div>
    @if($isOpen)
    <div class="fixed inset-0 flex items-center justify-center bg-black/50 z-50">
        {{-- Caja del modal --}}
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-lg relative overflow-hidden">

            {{-- Botón cerrar --}}
            <button wire:click="close"
                class="absolute top-3 right-3 text-gray-400 hover:text-primary text-xl transition">
                <i class="fa-solid fa-xmark"></i>
            </button>

            {{-- HEADER --}}
            <div class="p-6 pb-4">
                <h2 class="text-xl font-semibold text-[#09B451] mb-1">
                    {{ $isEdit ? 'Editar Servicio o Beneficio' : 'Nuevo Servicio o Beneficio' }}
                </h2>
                <p class="text-sm text-gray-500">
                    Completa los campos para registrar o actualizar un servicio de bienestar.
                </p>
                <hr class="border-t border-gray-200 mt-4">
            </div>

            {{-- BODY --}}
            <div class="px-6 pb-4 max-h-[60vh] overflow-y-auto space-y-4">
                <div>
                    <label class="text-sm font-medium text-gray-600">Nombre *</label>
                    <input type="text" wire:model.defer="nombre"
                        class="w-full mt-1 border-gray-300 rounded-lg text-sm focus:ring-primary focus:border-primary" />
                    @error('nombre') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="text-sm font-medium text-gray-600">Descripción</label>
                    <textarea wire:model.defer="descripcion" rows="3"
                        class="w-full mt-1 border-gray-300 rounded-lg text-sm focus:ring-primary focus:border-primary"></textarea>
                    @error('descripcion') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="text-sm font-medium text-gray-600">Tipo</label>
                    <select wire:model.defer="tipo"
                        class="w-full mt-1 border-gray-300 rounded-lg text-sm focus:ring-primary focus:border-primary">
                        <option value="">Seleccionar</option>
                        <option>Salud</option>
                        <option>Recreación</option>
                        <option>Educativo</option>
                        <option>Financiero</option>
                        <option>Otro</option>
                    </select>
                </div>

                <div class="grid sm:grid-cols-2 gap-3">
                    <div>
                        <label class="text-sm font-medium text-gray-600">Contacto</label>
                        <input type="text" wire:model.defer="contacto"
                            class="w-full mt-1 border-gray-300 rounded-lg text-sm focus:ring-primary focus:border-primary" />
                    </div>

                    <div>
                        <label class="text-sm font-medium text-gray-600">Ubicación</label>
                        <input type="text" wire:model.defer="ubicacion"
                            class="w-full mt-1 border-gray-300 rounded-lg text-sm focus:ring-primary focus:border-primary" />
                    </div>
                </div>

                <div>
                    <label class="text-sm font-medium text-gray-600">URL / Enlace</label>
                    <input type="url" wire:model.defer="url"
                        class="w-full mt-1 border-gray-300 rounded-lg text-sm focus:ring-primary focus:border-primary" />
                    @error('url') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div class="flex items-center mt-2">
                    <label class="flex items-center space-x-2">
                        <input type="checkbox" wire:model.defer="activo"
                            class="rounded text-primary focus:ring-primary">
                        <span class="text-sm text-gray-700">Activo</span>
                    </label>
                </div>
            </div>

            {{-- FOOTER --}}
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
