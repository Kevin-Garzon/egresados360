<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Panel Admin — Egresados 360')</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>

<body class="bg-gray-100 font-inter text-rblack">
    <div class="h-screen flex overflow-hidden">

        {{-- Sidebar --}}
        <aside class="w-64 bg-primary text-white flex flex-col">
            {{-- Logo / título --}}
            <div class="px-6 py-4 text-2xl font-poppins font-bold border-b border-white/10">
                Egresados 360
                <span class="block text-sm font-normal text-white/80">Administrador</span>
            </div>

            {{-- Navegación --}}
            <nav class="flex-1 px-3 py-6 space-y-1">
                {{-- Dashboard --}}
                <a href="{{ route('dashboard') }}"
                    class="group flex items-center gap-3 px-3 py-2 rounded-lg transition
                {{ request()->routeIs('dashboard') 
                        ? 'bg-white text-primary font-semibold shadow-sm' 
                        : 'text-white/95 hover:bg-white hover:text-primary' }}">
                    <i class="fa-solid fa-gauge-high w-5 text-inherit"></i>
                    <span>Dashboard</span>
                </a>

                {{-- Laboral --}}
                <a href="{{ route('admin.laboral.panel') }}"
                    class="group flex items-center gap-3 px-3 py-2 rounded-lg transition
                {{ request()->routeIs('admin.laboral.*') ? 'bg-white text-primary font-semibold shadow-sm' : 'text-white/95 hover:bg-white hover:text-primary' }}">
                    <i class="fa-solid fa-briefcase w-5 text-inherit"></i>
                    <span>Laboral</span>
                </a>


                {{-- Formación --}}
                <a href="{{ route('admin.formacion.panel') }}"
                    class="group flex items-center gap-3 px-3 py-2 rounded-lg transition
                {{ request()->routeIs('admin.formacion.*') ? 'bg-white text-primary font-semibold shadow-sm' : 'text-white/95 hover:bg-white hover:text-primary' }}">
                    <i class="fa-solid fa-graduation-cap w-5 text-inherit"></i>
                    <span>Formación</span>
                </a>

                {{-- Bienestar (con submenú desplegable) --}}
                <div x-data="{ open: {{ request()->routeIs('admin.bienestar.*') ? 'true' : 'false' }} }" class="relative">
                    <button @click="open = !open"
                        class="flex items-center gap-3 px-3 py-2 rounded-lg w-full text-left transition
        {{ request()->routeIs('admin.bienestar.*') 
            ? 'bg-white text-primary font-semibold shadow-sm' 
            : 'text-white/95 hover:bg-white hover:text-primary' }}">
                        <i class="fa-solid fa-heart w-5 text-inherit"></i>
                        <span>Bienestar</span>
                        <i :class="open ? 'fa-chevron-up' : 'fa-chevron-down'" class="fa-solid text-xs ml-auto"></i>
                    </button>

                    {{-- Submenú --}}
                    <div x-show="open" x-transition class="mt-1 ml-8 space-y-1 overflow-hidden">

                        {{-- Habilidades --}}
                        <a href="{{ route('admin.bienestar.habilidades.panel') }}"
                            class="flex items-center gap-2 px-3 py-2 rounded-lg transition
            {{ request()->routeIs('admin.bienestar.habilidades.*') 
                ? 'bg-white text-primary font-semibold shadow-sm' 
                : 'text-white/90 hover:bg-white hover:text-primary' }}">
                            <i class="fa-solid fa-star w-4"></i>
                            <span>Habilidades</span>
                        </a>

                        {{-- Servicios y Beneficios --}}
                        <a href="{{ route('admin.bienestar.servicios.panel') }}"
                            class="flex items-center gap-2 px-3 py-2 rounded-lg transition
            {{ request()->routeIs('admin.bienestar.servicios.*') 
                ? 'bg-white text-primary font-semibold shadow-sm' 
                : 'text-white/90 hover:bg-white hover:text-primary' }}">
                            <i class="fa-solid fa-hand-holding-heart w-4"></i>
                            <span>Servicios</span>
                        </a>

                        {{-- Nuevo: Eventos --}}
                        <a href="{{ route('admin.bienestar.eventos.panel') }}"
                            class="flex items-center gap-3 px-3 py-2 rounded-lg transition
            {{ request()->routeIs('admin.bienestar.eventos.*') 
                ? 'bg-white text-primary font-semibold shadow-sm' 
                : 'text-white/90 hover:bg-white hover:text-primary' }}">
                            <i class="fa-solid fa-calendar-days w-4"></i>
                            <span>Eventos</span>
                        </a>

                        {{-- Nuevo: Mentorías --}}
                        <a href="{{ route('admin.bienestar.mentorias.panel') }}"
                            class="flex items-center gap-3 px-3 py-2 rounded-lg transition
            {{ request()->routeIs('admin.bienestar.mentorias.*') 
                ? 'bg-white text-primary font-semibold shadow-sm' 
                : 'text-white/90 hover:bg-white hover:text-primary' }}">
                            <i class="fa-solid fa-chalkboard-user w-4"></i>
                            <span>Mentorías</span>
                        </a>

                    </div>
                </div>

            </nav>

            {{-- Logout --}}
            <div class="px-3 py-6 border-t border-white/10">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="group flex items-center gap-3 w-full text-left px-3 py-2 rounded-lg transition hover:bg-white hover:text-primary">
                        <i class="fa-solid fa-right-from-bracket w-5 text-inherit"></i>
                        <span>Cerrar sesión</span>
                    </button>
                </form>
            </div>
        </aside>



        {{-- Contenido principal --}}
        <main class="flex-1 flex flex-col overflow-y-auto">
            {{-- Header --}}
            <header class="bg-white shadow-sm px-6 py-4 flex justify-between items-center">
                {{-- Título dinámico --}}
                <h1 class="text-xl font-poppins font-semibold text-gunmetal">
                    @yield('header', 'Panel de Administración')
                </h1>

                {{-- Acciones del usuario --}}
                <div class="flex items-center gap-6">
                    {{-- Notificaciones --}}
                    <!-- <button class="relative text-gray-600 hover:text-primary">
                        <i class="fa-solid fa-bell text-lg"></i>
                        {{-- Indicador (simulación de notificaciones) --}}
                        <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs w-4 h-4 flex items-center justify-center rounded-full">3</span>
                    </button> -->

                    {{-- Usuario --}}
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 flex items-center justify-center rounded-full bg-primary text-white font-semibold">
                            {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
                        </div>
                        <a href="{{ route('profile.edit') }}" class="text-sm font-medium text-gray-700 hover:text-primary">
                            {{ Auth::user()->name }}
                        </a>

                    </div>
                </div>
            </header>


            {{-- Contenido dinámico --}}
            <div class="p-6 flex-1">
                @yield('content')
            </div>
        </main>
    </div>

    @livewireScripts
</body>

</html>