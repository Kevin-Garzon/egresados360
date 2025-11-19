<div x-data="{ open: @entangle('open') }" @open-importar-excel.window="open = true">

    {{-- Modal --}}
    <template x-if="open">
        <div class="fixed inset-0 bg-black/40 backdrop-blur-sm z-[200] flex items-center justify-center">
            <div class="bg-white rounded-xl shadow-lg w-full max-w-md p-6">

                <h2 class="text-lg font-semibold text-[#263238] mb-4">
                    Importar ofertas desde Excel
                </h2>

                <input type="file"
                       wire:model="archivo"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-primary focus:border-primary">

                <p class="text-xs text-gray-500 mt-1">
                    Formatos permitidos: <strong>.xls, .xlsx</strong> — Máx: 10MB
                </p>

                @error('archivo')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror

                @if(session('error'))
                    <p class="text-sm text-red-600 mt-2">{{ session('error') }}</p>
                @endif
                @if(session('status'))
                    <p class="text-sm text-emerald-600 mt-2">{{ session('status') }}</p>
                @endif

                <div class="flex justify-end gap-2 mt-6">
                    <button
                        @click="open = false"
                        class="px-4 py-2 rounded-lg bg-gray-200 text-gray-700 hover:bg-gray-300 text-sm">
                        Cancelar
                    </button>

                    <button
                        wire:click="importar"
                        class="px-4 py-2 rounded-lg bg-green-600 text-white hover:bg-green-700 text-sm shadow">
                        Importar
                    </button>
                </div>

            </div>
        </div>
    </template>

</div>
