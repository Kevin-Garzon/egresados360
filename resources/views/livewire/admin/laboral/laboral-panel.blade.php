@extends('layouts.admin')

@section('content')
<div class="p-6 space-y-8">
    <header>
        <h1 class="text-2xl font-semibold text-[#232323]">Módulo - Laboral</h1>
    </header>

    {{-- Tarjetas rápidas --}}
    <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white rounded-2xl shadow p-4 flex items-center">
            <div class="w-12 h-12 flex items-center justify-center rounded-full bg-primary/10 text-primary text-2xl mr-4">
                <i class="fa-solid fa-building"></i>
            </div>
            <div class="flex flex-col">
                <div class="text-sm text-gray-500 mb-1">Empresas</div>
                <div class="text-2xl font-semibold">{{ $empresasCount }}</div>
            </div>
        </div>
        <div class="bg-white rounded-2xl shadow p-4 flex items-center">
            <div class="w-12 h-12 flex items-center justify-center rounded-full bg-primary/10 text-primary text-2xl mr-4">
                <i class="fa-solid fa-list"></i>
            </div>
            <div class="flex flex-col">
                <div class="text-sm text-gray-500 mb-1">Ofertas totales</div>
                <div class="text-2xl font-semibold">{{ $ofertasTotales }}</div>
            </div>
        </div>
        <div class="bg-white rounded-2xl shadow p-4 flex items-center">
            <div class="w-12 h-12 flex items-center justify-center rounded-full bg-primary/10 text-primary text-2xl mr-4">
                <i class="fa-solid fa-briefcase"></i>
            </div>
            <div class="flex flex-col">
                <div class="text-sm text-gray-500 mb-1">Ofertas activas</div>
                <div class="text-2xl font-semibold">{{ $ofertasActivas }}</div>
            </div>
        </div>


    </section>

    {{-- Gestión de Oportunidades Laborales --}}
    <section class="space-y-4">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <h2 class="text-lg font-semibold text-[#263238]">
                Gestión de Oportunidades Laborales
            </h2>

            <div class="flex items-center gap-3">
                {{-- Botón para Importar Excel --}}
                <button
                    class="px-4 py-2 rounded-lg bg-primary text-white shadow hover:opacity-90 transition text-sm sm:text-base whitespace-nowrap"
                    x-data
                    @click="$dispatch('open-importar-excel')">
                    <i class="fa-solid fa-file-import mr-2"></i> Importar Excel
                </button>

                {{-- Botón para Crear Oferta --}}
                <button
                    class="px-4 py-2 rounded-lg bg-[#09B451] text-white shadow hover:opacity-90 transition text-sm sm:text-base whitespace-nowrap"
                    x-data
                    @click="$dispatch('open-create-oferta')">
                    <i class="fa-solid fa-plus mr-2"></i> Agregar Empleo
                </button>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow p-4">
            <livewire:admin.laboral.ofertas-table />
        </div>

        <livewire:admin.laboral.importar-excel />
        <livewire:admin.laboral.oferta-form />
        <livewire:admin.laboral.delete-confirm />
    </section>

    {{-- Directorio de Empresas (tabla) --}}
    <section class="space-y-4">
        <div class="flex items-center justify-between">
            <h2 class="text-lg font-semibold text-[#263238]">Directorio de Empresas Aliadas</h2>
            <button
                class="px-4 py-2 rounded-lg bg-[#09B451] text-white shadow hover:opacity-90 transition text-sm sm:text-base whitespace-nowrap"
                x-data
                @click="$dispatch('open-create-empresa')">
                <i class="fa-solid fa-plus mr-2"></i> Agregar Empresa
            </button>
        </div>

        <div class="bg-white rounded-2xl shadow p-4">
            <livewire:admin.laboral.empresas-table />
        </div>

        <livewire:admin.laboral.empresa-form />
        <livewire:admin.laboral.delete-empresa />
    </section>

</div>


@endsection