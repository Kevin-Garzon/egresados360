@extends('layouts.admin')

@section('content')
<div class="p-6 space-y-8">
    {{-- HEADER --}}
    <header>
        <h1 class="text-2xl font-semibold text-[#232323]">Módulo - Mentorías del Egresado</h1>
    </header>

    {{-- TARJETAS RESUMEN --}}
    <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white rounded-2xl shadow p-4 flex items-center">
            <div class="w-12 h-12 flex items-center justify-center rounded-full bg-primary/10 text-primary text-2xl mr-4">
                <i class="fa-solid fa-chalkboard-user"></i>
            </div>
            <div>
                <div class="text-sm text-gray-500 mb-1">Total de Mentorías</div>
                <div class="text-2xl font-semibold">{{ $totalMentorias }}</div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow p-4 flex items-center">
            <div class="w-12 h-12 flex items-center justify-center rounded-full bg-green-100 text-green-700 text-2xl mr-4">
                <i class="fa-solid fa-toggle-on"></i>
            </div>
            <div>
                <div class="text-sm text-gray-500 mb-1">Activas</div>
                <div class="text-2xl font-semibold">{{ $activas }}</div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow p-4 flex items-center">
            <div class="w-12 h-12 flex items-center justify-center rounded-full bg-red-100 text-red-700 text-2xl mr-4">
                <i class="fa-solid fa-toggle-off"></i>
            </div>
            <div>
                <div class="text-sm text-gray-500 mb-1">Inactivas</div>
                <div class="text-2xl font-semibold">{{ $inactivas }}</div>
            </div>
        </div>
    </section>

    {{-- GESTIÓN DE MENTORÍAS --}}
    <section class="space-y-4">
        <div class="flex items-center justify-between">
            <h2 class="text-lg font-semibold text-[#263238]">Gestión de Áreas de Mentoría</h2>
            <button
                class="px-4 py-2 rounded-lg bg-[#09B451] text-white shadow hover:opacity-90 transition text-sm sm:text-base whitespace-nowrap"
                x-data
                @click="$dispatch('open-create-mentoria')">
                <i class="fa-solid fa-plus mr-2"></i> Nueva Mentoría
            </button>
        </div>

        <div class="bg-white rounded-2xl shadow p-4">
            <livewire:admin.bienestar.mentorias.mentorias-table />
        </div>

        <livewire:admin.bienestar.mentorias.mentoria-form />
    </section>
</div>
@endsection
