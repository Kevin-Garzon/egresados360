@extends('layouts.admin')

@section('content')
<div class="p-6 space-y-8">
    <header>
        <h1 class="text-2xl font-semibold text-[#232323]">Módulo - Bienestar del Egresado</h1>
    </header>

    {{-- Tarjetas rápidas --}}
    <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white rounded-2xl shadow p-4 flex items-center">
            <div class="w-12 h-12 flex items-center justify-center rounded-full bg-primary/10 text-primary text-2xl mr-4">
                <i class="fa-solid fa-layer-group"></i>
            </div>
            <div class="flex flex-col">
                <div class="text-sm text-gray-500 mb-1">Total de Habilidades</div>
                <div class="text-2xl font-semibold">{{ $totalHabilidades }}</div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow p-4 flex items-center">
            <div class="w-12 h-12 flex items-center justify-center rounded-full bg-primary/10 text-primary text-2xl mr-4">
                <i class="fa-solid fa-circle-check"></i>
            </div>
            <div class="flex flex-col">
                <div class="text-sm text-gray-500 mb-1">Activas</div>
                <div class="text-2xl font-semibold">{{ $activas }}</div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow p-4 flex items-center">
            <div class="w-12 h-12 flex items-center justify-center rounded-full bg-primary/10 text-primary text-2xl mr-4">
                <i class="fa-solid fa-circle-xmark"></i>
            </div>
            <div class="flex flex-col">
                <div class="text-sm text-gray-500 mb-1">Inactivas</div>
                <div class="text-2xl font-semibold">{{ $inactivas }}</div>
            </div>
        </div>
    </section>

    {{-- Gestión de Habilidades --}}
    <section class="space-y-4">
        <div class="flex items-center justify-between">
            <h2 class="text-lg font-semibold text-[#263238]">Gestión de Habilidades para la Vida</h2>
            <button
                class="px-4 py-2 rounded-lg bg-[#09B451] text-white shadow hover:opacity-90 transition"
                x-data
                @click="$dispatch('open-create-habilidad')">
                <i class="fa-solid fa-plus mr-2"></i> Agregar Habilidad
            </button>
        </div>

        <div class="bg-white rounded-2xl shadow p-4">
            <livewire:admin.bienestar.habilidades.habilidades-table />
        </div>

        <livewire:admin.bienestar.habilidades.habilidad-form />
    </section>
</div>
@endsection
