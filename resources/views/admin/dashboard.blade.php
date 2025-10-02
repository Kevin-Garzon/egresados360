@extends('layouts.admin')

@section('title', 'Dashboard — Egresados 360')

@section('header', 'Dashboard')

@section('content')
    <div class="bg-white p-6 rounded shadow">
        <h2 class="text-xl font-poppins font-semibold mb-4">Bienvenido, {{ Auth::user()->name }}</h2>
        <p class="text-gray-600">Este es el panel de administración. Desde aquí se gestionan las ofertas laborales, formación y bienestar.</p>
    </div>
@endsection