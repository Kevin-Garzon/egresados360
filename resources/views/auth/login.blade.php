@extends('layouts.guest')

@section('title', 'Iniciar Sesión Administrador')

@section('content')
<div class="w-full max-w-md bg-white p-8 rounded-2xl shadow-card">
    <h2 class="text-center text-2xl font-poppins font-semibold text-primary mb-6">
        Iniciar Sesión <br> <span class="text-gunmetal">Administrador</span>
    </h2>

    {{-- Formulario de login --}}
    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        {{-- Usuario --}}
        <div>
            <label for="email" class="block text-sm font-medium text-gunmetal mb-1">Usuario administrador</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                class="w-full border border-gray-300 rounded-xl p-3 focus:ring-2 focus:ring-primary focus:outline-none">
        </div>

        {{-- Contraseña --}}
        <div>
            <label for="password" class="block text-sm font-medium text-gunmetal mb-1">Contraseña</label>
            <input id="password" type="password" name="password" required
                class="w-full border border-gray-300 rounded-xl p-3 focus:ring-2 focus:ring-primary focus:outline-none">
        </div>

        {{-- Botón --}}
        <div>
            <button type="submit"
                class="w-full btn btn-primary justify-center">
                Iniciar sesión
            </button>
        </div>
    </form>

    {{-- Ayuda --}}
    <div class="mt-6 text-center text-sm text-gray-600">
        ¿Tienes preguntas? <br>
        <a href="mailto:egresados@fet.edu.co" class="text-primary hover:underline">
            egresados@fet.edu.co
        </a>
    </div>
</div>
@endsection
