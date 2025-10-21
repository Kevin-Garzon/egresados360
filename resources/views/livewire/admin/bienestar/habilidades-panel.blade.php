{{-- Panel Bienestar > Habilidades --}}
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-poppins font-semibold">Habilidades para la vida</h1>
        {{-- Botón creará el modal/form en el siguiente paso --}}
        <button class="btn btn-primary py-2 px-4" wire:click="$dispatch('abrir-form-habilidad')">
            <i class="fa-solid fa-plus mr-2"></i> Nueva habilidad
        </button>
    </div>

    {{-- Métricas simples (placeholder, se llenan luego si hace falta) --}}
    <div class="grid gap-4 sm:grid-cols-3">
        <div class="card p-4">
            <p class="text-sm text-rblack/60">Publicadas</p>
            <p class="text-2xl font-semibold">—</p>
        </div>
        <div class="card p-4">
            <p class="text-sm text-rblack/60">Próximas</p>
            <p class="text-2xl font-semibold">—</p>
        </div>
        <div class="card p-4">
            <p class="text-sm text-rblack/60">Inactivas</p>
            <p class="text-2xl font-semibold">—</p>
        </div>
    </div>

    {{-- Tabla (componente separado, como en Formación) --}}
    <livewire:admin.bienestar.habilidades-table />
</div>
