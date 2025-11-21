<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Panel Admin — Egresados 360')</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
    <link rel="icon" type="image/png" href="{{ asset('fet.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>

<body x-data="{ openSidebar: false }" class="bg-gray-100 font-inter text-rblack">

    {{-- Contenedor general --}}
    <div class="h-screen flex overflow-hidden">

        {{-- Sidebar (colapsable en móvil, fijo en desktop) --}}
        <aside
            :class="openSidebar ? 'translate-x-0' : '-translate-x-full'"
            class="fixed md:static inset-y-0 left-0 z-50 w-64 bg-primary text-white flex flex-col transform transition-transform duration-300 md:translate-x-0">

            {{-- Logo / título --}}
            <div class="px-6 py-4 text-2xl font-poppins font-bold border-b border-white/10 flex justify-between items-center">
                <div>
                    Egresados 360
                    <span class="block text-sm font-normal text-white/80">Administrador</span>
                </div>
                {{-- Botón cerrar en móvil --}}
                <button @click="openSidebar = false" class="md:hidden text-white text-xl">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            {{-- Navegación --}}
            <nav class="flex-1 px-3 py-6 space-y-1 overflow-y-auto">
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
                    {{ request()->routeIs('admin.laboral.*') 
                        ? 'bg-white text-primary font-semibold shadow-sm' 
                        : 'text-white/95 hover:bg-white hover:text-primary' }}">
                    <i class="fa-solid fa-briefcase w-5 text-inherit"></i>
                    <span>Laboral</span>
                </a>

                {{-- Formación --}}
                <a href="{{ route('admin.formacion.panel') }}"
                    class="group flex items-center gap-3 px-3 py-2 rounded-lg transition
                    {{ request()->routeIs('admin.formacion.*') 
                        ? 'bg-white text-primary font-semibold shadow-sm' 
                        : 'text-white/95 hover:bg-white hover:text-primary' }}">
                    <i class="fa-solid fa-graduation-cap w-5 text-inherit"></i>
                    <span>Formación</span>
                </a>

                {{-- Bienestar con submenú --}}
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

                    <div x-show="open" x-transition class="mt-1 ml-8 space-y-1 overflow-hidden">
                        <a href="{{ route('admin.bienestar.habilidades.panel') }}"
                            class="flex items-center gap-2 px-3 py-2 rounded-lg transition
                                {{ request()->routeIs('admin.bienestar.habilidades.*') 
                                    ? 'bg-white text-primary font-semibold shadow-sm' 
                                    : 'text-white/90 hover:bg-white hover:text-primary' }}">
                            <i class="fa-solid fa-star w-4"></i>
                            <span>Habilidades</span>
                        </a>
                        <a href="{{ route('admin.bienestar.servicios.panel') }}"
                            class="flex items-center gap-2 px-3 py-2 rounded-lg transition
                                {{ request()->routeIs('admin.bienestar.servicios.*') 
                                    ? 'bg-white text-primary font-semibold shadow-sm' 
                                    : 'text-white/90 hover:bg-white hover:text-primary' }}">
                            <i class="fa-solid fa-hand-holding-heart w-4"></i>
                            <span>Servicios</span>
                        </a>
                        <a href="{{ route('admin.bienestar.eventos.panel') }}"
                            class="flex items-center gap-3 px-3 py-2 rounded-lg transition
                                {{ request()->routeIs('admin.bienestar.eventos.*') 
                                    ? 'bg-white text-primary font-semibold shadow-sm' 
                                    : 'text-white/90 hover:bg-white hover:text-primary' }}">
                            <i class="fa-solid fa-calendar-days w-4"></i>
                            <span>Eventos</span>
                        </a>
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

                {{-- Informe Inteligente --}}
                <a href="{{ route('admin.informe.panel') }}"
                    class="group flex items-center gap-3 px-3 py-2 rounded-lg transition
                    {{ request()->routeIs('admin.informe.*') 
                        ? 'bg-white text-primary font-semibold shadow-sm' 
                        : 'text-white/95 hover:bg-white hover:text-primary' }}">
                    <i class="fa-solid fa-robot w-5 text-inherit"></i>
                    <span>Informe</span>
                </a>
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

        {{-- Overlay para móvil --}}
        <div
            x-show="openSidebar"
            @click="openSidebar = false"
            class="fixed inset-0 bg-black/40 z-40 md:hidden"
            x-transition.opacity></div>

        {{-- Contenido principal --}}
        <main class="flex-1 flex flex-col overflow-y-auto">
            <header class="bg-white shadow-sm px-4 sm:px-6 py-4 flex justify-between items-center">
                <div class="flex items-center gap-4">
                    {{-- Botón menú hamburguesa (solo móvil) --}}
                    <button @click="openSidebar = true" class="md:hidden text-primary text-2xl">
                        <i class="fa-solid fa-bars"></i>
                    </button>
                    <h1 class="text-xl font-poppins font-semibold text-gunmetal">
                        @yield('header', 'Panel de Administración')
                    </h1>
                </div>

                {{-- Usuario --}}
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 flex items-center justify-center rounded-full bg-primary text-white font-semibold">
                        {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
                    </div>
                    <a href="{{ route('profile.edit') }}" class="text-sm font-medium text-gray-700 hover:text-primary">
                        {{ Auth::user()->name }}
                    </a>
                </div>
            </header>

            <div class="p-4 sm:p-6 flex-1">
                @yield('content')
            </div>
        </main>
    </div>

    @livewireScripts
    @stack('scripts')
</body>


</html>