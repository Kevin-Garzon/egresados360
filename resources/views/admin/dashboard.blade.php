@extends('layouts.admin')

@section('title', 'Dashboard - Admin')
@section('header', 'Dashboard')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
    {{-- Empresas --}}
    <div class="p-6 bg-white rounded-xl shadow-card flex items-center gap-4">
        <div class="w-12 h-12 flex items-center justify-center rounded-full bg-primary/10 text-primary text-2xl">
            <i class="fa-solid fa-building"></i>
        </div>
        <div>
            <p class="text-sm text-gray-500">Empresas</p>
            <p class="text-2xl font-semibold text-gunmetal">12</p>
        </div>
    </div>

    {{-- Ofertas laborales --}}
    <div class="p-6 bg-white rounded-xl shadow-card flex items-center gap-4">
        <div class="w-12 h-12 flex items-center justify-center rounded-full bg-primary/10 text-primary text-2xl">
            <i class="fa-solid fa-briefcase"></i>
        </div>
        <div>
            <p class="text-sm text-gray-500">Ofertas activas</p>
            <p class="text-2xl font-semibold text-gunmetal">24</p>
        </div>
    </div>

    {{-- Egresados --}}
    <div class="p-6 bg-white rounded-xl shadow-card flex items-center gap-4">
        <div class="w-12 h-12 flex items-center justify-center rounded-full bg-primary/10 text-primary text-2xl">
            <i class="fa-solid fa-user-graduate"></i>
        </div>
        <div>
            <p class="text-sm text-gray-500">Egresados</p>
            <p class="text-2xl font-semibold text-gunmetal">50</p>
        </div>
    </div>

    {{-- Visitas --}}
    <div class="p-6 bg-white rounded-xl shadow-card flex items-center gap-4">
        <div class="w-12 h-12 flex items-center justify-center rounded-full bg-primary/10 text-primary text-2xl">
            <i class="fa-solid fa-chart-line"></i>
        </div>
        <div>
            <p class="text-sm text-gray-500">Visitas</p>
            <p class="text-2xl font-semibold text-gunmetal">120</p>
        </div>
    </div>
</div>
@endsection