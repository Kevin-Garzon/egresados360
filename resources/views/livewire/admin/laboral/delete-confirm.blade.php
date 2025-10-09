<div wire:ignore.self>
    @if($isOpen)
        <div class="fixed inset-0 bg-black/40 z-40"></div>

        <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div class="bg-white rounded-2xl shadow-lg max-w-md w-full overflow-hidden">
                <div class="px-6 py-5 text-center space-y-4">
                    <div class="text-4xl text-red-500">
                        <i class="fa-solid fa-triangle-exclamation"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800">
                        Confirmar eliminación
                    </h3>
                    <p class="text-gray-600">
                        ¿Seguro que deseas eliminar la oferta
                        <span class="font-semibold text-gray-800">"{{ $titulo }}"</span>?
                    </p>
                </div>

                <div class="px-6 py-4 bg-gray-50 border-b border-gray-100  flex justify-center gap-3">
                    <button wire:click="close" type="button"
                        class="px-4 py-2 rounded-lg bg-gray-200 hover:bg-gray-300 text-gray-700">
                        Cancelar
                    </button>

                    <button wire:click="delete" type="button"
                        class="px-4 py-2 rounded-lg bg-red-600 text-white hover:bg-red-700">
                        Eliminar
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
