<div>
    @if($isOpen)
    <div class="fixed inset-0 flex items-center justify-center bg-black/50 z-50">
        {{-- Caja del modal: sin scroll aquí, solo borde redondeado y recorte --}}
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-lg relative overflow-hidden">

            {{-- Cerrar --}}
            <button wire:click="close"
                class="absolute top-3 right-3 text-gray-400 hover:text-primary text-xl transition">
                <i class="fa-solid fa-xmark"></i>
            </button>

            {{-- HEADER (fijo) --}}
            <div class="p-6 pb-4">
                <h2 class="text-xl font-semibold text-[#09B451] mb-1">
                    {{ $isEdit ? 'Editar Programa de Formación' : 'Nuevo Programa de Formación' }}
                </h2>
                <p class="text-sm text-gray-500">
                    Completa los campos para registrar un nuevo programa de formación continua.
                </p>
                <hr class="border-t border-gray-200 mt-4">
            </div>

            {{-- BODY (solo aquí hay scroll) --}}
            <div class="px-6 pb-4 max-h-[60vh] overflow-y-auto">
                <div class="space-y-4">
                    <div>
                        <label class="text-sm font-medium text-gray-600">Título *</label>
                        <input type="text" wire:model.defer="titulo"
                            class="w-full mt-1 border-gray-300 rounded-lg text-sm focus:ring-primary focus:border-primary" />
                        @error('titulo') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="text-sm font-medium text-gray-600">Empresa / Entidad Aliada</label>
                        <select wire:model.defer="empresa_id"
                            class="w-full mt-1 border-gray-300 rounded-lg text-sm focus:ring-primary focus:border-primary">
                            <option value="">Seleccionar</option>
                            @foreach(\App\Models\Empresa::orderBy('nombre')->get() as $empresa)
                            <option value="{{ $empresa->id }}">{{ $empresa->nombre }}</option>
                            @endforeach
                        </select>
                    </div>


                    <div>
                        <label class="text-sm font-medium text-gray-600">Programa *</label>
                        <select wire:model.defer="programa"
                            class="w-full mt-1 border-gray-300 rounded-lg text-sm focus:ring-primary focus:border-primary">
                            <option value="">Seleccionar</option>
                            <option>Ingeniería de Software</option>
                            <option>Ingeniería de Alimentos</option>
                            <option>Ingeniería Eléctrica</option>
                            <option>Ingeniería Ambiental</option>
                            <option>Salud Ocupacional</option>
                            <option>Administración de Negocios Internacionales</option>
                        </select>
                        @error('programa') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="text-sm font-medium text-gray-600">Modalidad *</label>
                        <select wire:model.defer="modalidad"
                            class="w-full mt-1 border-gray-300 rounded-lg text-sm focus:ring-primary focus:border-primary">
                            <option value="">Seleccionar</option>
                            <option>Virtual</option>
                            <option>Presencial</option>
                            <option>Mixta</option>
                        </select>
                        @error('modalidad') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="text-sm font-medium text-gray-600">Tipo *</label>
                        <select wire:model.defer="tipo"
                            class="w-full mt-1 border-gray-300 rounded-lg text-sm focus:ring-primary focus:border-primary">
                            <option value="">Seleccionar</option>
                            <option>Curso</option>
                            <option>Seminario</option>
                            <option>Diplomado</option>
                        </select>
                        @error('tipo') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="text-sm font-medium text-gray-600">Costo (COP)</label>
                        <input type="number" wire:model.defer="costo"
                            class="w-full mt-1 border-gray-300 rounded-lg text-sm focus:ring-primary focus:border-primary" />
                    </div>

                    <div>
                        <label class="text-sm font-medium text-gray-600">Duración (Horas)</label>
                        <input type="text" wire:model.defer="duracion"
                            class="w-full mt-1 border-gray-300 rounded-lg text-sm focus:ring-primary focus:border-primary" />
                    </div>

                    <div>
                        <label class="text-sm font-medium text-gray-600">Imagen del Programa</label>
                        <input type="file" wire:model="imagen"
                            class="w-full mt-1 text-sm border-gray-300 rounded-lg focus:ring-primary focus:border-primary" accept="image/*">

                        {{-- Previsualización --}}
                        <div class="mt-2">
                            @if ($imagen)
                            <img src="{{ $imagen->temporaryUrl() }}" class="h-32 rounded-lg object-cover border border-gray-200">
                            @elseif ($existingImage)
                            <img src="{{ asset('storage/'.$existingImage) }}" class="h-32 rounded-lg object-cover border border-gray-200">
                            @endif
                        </div>

                        @error('imagen') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>



                    <div class="flex gap-3">
                        <div class="flex-1">
                            <label class="text-sm font-medium text-gray-600">Fecha Inicio</label>
                            <input type="date" wire:model.defer="fecha_inicio"
                                class="w-full mt-1 border-gray-300 rounded-lg text-sm focus:ring-primary focus:border-primary" />
                        </div>
                        <div class="flex-1">
                            <label class="text-sm font-medium text-gray-600">Fecha Fin</label>
                            <input type="date" wire:model.defer="fecha_fin"
                                class="w-full mt-1 border-gray-300 rounded-lg text-sm focus:ring-primary focus:border-primary" />
                        </div>
                    </div>

                    <div>
                        <label class="text-sm font-medium text-gray-600">Descripción</label>
                        <textarea wire:model.defer="descripcion" rows="3"
                            class="w-full mt-1 border-gray-300 rounded-lg text-sm focus:ring-primary focus:border-primary"></textarea>
                    </div>

                    <div>
                        <label class="text-sm font-medium text-gray-600">URL Externa</label>
                        <input type="url" wire:model.defer="url_externa"
                            class="w-full mt-1 border-gray-300 rounded-lg text-sm focus:ring-primary focus:border-primary" />
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

            {{-- FOOTER (fijo) --}}
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