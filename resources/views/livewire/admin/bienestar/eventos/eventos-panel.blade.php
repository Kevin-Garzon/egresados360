@extends('layouts.admin')

@section('content')
<div class="p-6 space-y-8">
    {{-- HEADER --}}
    <header>
        <h1 class="text-2xl font-semibold text-[#232323]">Módulo - Eventos Institucionales</h1>
    </header>

    {{-- TARJETAS RESUMEN --}}
    <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white rounded-2xl shadow p-4 flex items-center">
            <div class="w-12 h-12 flex items-center justify-center rounded-full bg-primary/10 text-primary text-2xl mr-4">
                <i class="fa-solid fa-calendar-days"></i>
            </div>
            <div>
                <div class="text-sm text-gray-500 mb-1">Total de Eventos</div>
                <div class="text-2xl font-semibold">{{ $totalEventos }}</div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow p-4 flex items-center">
            <div class="w-12 h-12 flex items-center justify-center rounded-full bg-primary/10 text-primary text-2xl mr-4">
                <i class="fa-solid fa-hourglass-start"></i>
            </div>
            <div>
                <div class="text-sm text-gray-500 mb-1">Próximos</div>
                <div class="text-2xl font-semibold">{{ $proximos }}</div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow p-4 flex items-center">
            <div class="w-12 h-12 flex items-center justify-center rounded-full bg-primary/10 text-primary text-2xl mr-4">
                <i class="fa-solid fa-flag-checkered"></i>
            </div>
            <div>
                <div class="text-sm text-gray-500 mb-1">Finalizados</div>
                <div class="text-2xl font-semibold">{{ $finalizados }}</div>
            </div>
        </div>
    </section>

    {{-- GESTIÓN DE EVENTOS --}}
    <section class="space-y-4">
        <div class="flex items-center justify-between">
            <h2 class="text-lg font-semibold text-[#263238]">Gestión de Eventos</h2>
            <button
                class="px-4 py-2 rounded-lg bg-[#09B451] text-white shadow hover:opacity-90 transition"
                x-data
                @click="$dispatch('open-create-evento')">
                <i class="fa-solid fa-plus mr-2"></i> Agregar Evento
            </button>
            
        </div>

        <div class="bg-white rounded-2xl shadow p-4">
            <livewire:admin.bienestar.eventos.eventos-table />
        </div>

        <livewire:admin.bienestar.eventos.evento-form />
    </section>
</div>
@endsection
