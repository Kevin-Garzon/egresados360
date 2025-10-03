@extends('layouts.admin')

@section('title', 'Perfil - Admin')
@section('header', 'Mi Perfil')

@section('content')
<div class="max-w-2xl mx-auto bg-white shadow rounded-lg p-6">
    {{-- Alerta de éxito --}}
    @if (session('status') === 'profile-updated')
    <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">
        Datos actualizados correctamente.
    </div>
    @endif

    {{-- Alerta de error (validaciones) --}}
    @if ($errors->any())
    <div class="mb-4 p-3 bg-red-100 text-red-800 rounded">
        <ul class="list-disc list-inside text-sm">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    {{-- Formulario de nombre --}}
    <form method="POST" action="{{ route('profile.update') }}" class="space-y-6">
        @csrf
        @method('PATCH')

        <div>
            <label for="name" class="block text-sm font-medium text-gray-700">Nombre</label>
            <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}"
                class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm p-2 focus:ring-primary focus:border-primary">
            @error('name')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="email" class="block text-sm font-medium text-gray-700">Correo</label>
            <input id="email" name="email" type="email" value="{{ $user->email }}" readonly
                class="mt-1 block w-full border border-gray-200 bg-gray-100 rounded-lg shadow-sm p-2 text-gray-500">
        </div>

        {{-- Formulario de contraseña --}}
        <div>
            <label for="password" class="block text-sm font-medium text-gray-700">Nueva contraseña</label>
            <input id="password" name="password" type="password"
                class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm p-2 focus:ring-primary focus:border-primary">
            @error('password')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirmar contraseña</label>
            <input id="password_confirmation" name="password_confirmation" type="password"
                class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm p-2 focus:ring-primary focus:border-primary">
        </div>

        <div>
            <button type="submit" class="btn btn-primary w-40 mx-auto block">Guardar</button>
        </div>
    </form>
</div>
@endsection