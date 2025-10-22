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
                <i class="fa-solid fa-hand-holding-heart"></i>
            </div>
            <div class="flex flex-col">
                <div class="text-sm text-gray-500 mb-1">Total de Servicios</div>
                <div class="text-2xl font-semibold">{{ $totalServicios }}</div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow p-4 flex items-center">
            <div class="w-12 h-12 flex items-center justify-center rounded-full bg-primary/10 text-primary text-2xl mr-4">
                <i class="fa-solid fa-circle-check"></i>
            </div>
            <div class="flex flex-col">
                <div class="text-sm text-gray-500 mb-1">Activos</div>
                <div class="text-2xl font-semibold">{{ $activos }}</div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow p-4 flex items-center">
            <div class="w-12 h-12 flex items-center justify-center rounded-full bg-primary/10 text-primary text-2xl mr-4">
                <i class="fa-solid fa-circle-xmark"></i>
            </div>
            <div class="flex flex-col">
                <div class="text-sm text-gray-500 mb-1">Inactivos</div>
                <div class="text-2xl font-semibold">{{ $inactivos }}</div>
            </div>
        </div>
    </section>

    {{-- Gestión de Servicios y Beneficios --}}
    <section class="space-y-4">
        <div class="flex items-center justify-between">
            <h2 class="text-lg font-semibold text-[#263238]">Gestión de Servicios y Beneficios</h2>
            <button
                class="px-4 py-2 rounded-lg bg-[#09B451] text-white shadow hover:opacity-90 transition"
                x-data
                @click="$dispatch('open-create-servicio')">
                Agregar Servicio
            </button>
        </div>

        <div class="bg-white rounded-2xl shadow p-4">
            <livewire:admin.bienestar.servicios.servicios-table />
        </div>

        <livewire:admin.bienestar.servicios.servicio-form />
    </section>
</div>
@endsection
