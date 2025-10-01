<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Panel Admin — Egresados 360')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 font-inter text-rblack">
    <div class="min-h-screen flex">

        {{-- Sidebar --}}
        <aside class="w-64 bg-gunmetal text-white flex flex-col">
            <div class="px-6 py-4 text-2xl font-poppins font-bold border-b border-white/10">
                Admin FET
            </div>
            <nav class="flex-1 px-4 py-6 space-y-2">
                <a href="{{ route('dashboard') }}" class="block px-3 py-2 rounded hover:bg-primary">Dashboard</a>
                <a href="{{ route('laboral.index') }}" class="block px-3 py-2 rounded hover:bg-primary">Ofertas Laborales</a>
                <a href="#" class="block px-3 py-2 rounded hover:bg-primary">Formación</a>
                <a href="#" class="block px-3 py-2 rounded hover:bg-primary">Bienestar</a>
            </nav>
            <div class="px-4 py-6 border-t border-white/10">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-left px-3 py-2 rounded hover:bg-red-600">
                        Cerrar sesión
                    </button>
                </form>
            </div>
        </aside>

        {{-- Contenido principal --}}
        <main class="flex-1 flex flex-col">
            {{-- Header --}}
            <header class="bg-white shadow px-6 py-4 flex justify-between items-center">
                <h1 class="text-lg font-semibold">@yield('header', 'Panel de Administración')</h1>
                <span class="text-sm text-gray-600">Usuario: {{ Auth::user()->name ?? 'Invitado' }}</span>
            </header>

            {{-- Contenido dinámico --}}
            <div class="p-6 flex-1">
                @yield('content')
            </div>
        </main>
    </div>
</body>
</html>
