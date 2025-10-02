<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Panel Admin — Egresados 360')</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 font-inter text-rblack">
    <div class="min-h-screen flex">

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
                <a href="{{ route('laboral.index') }}"
                    class="group flex items-center gap-3 px-3 py-2 rounded-lg transition
                  {{ request()->routeIs('laboral.*') 
                        ? 'bg-white text-primary font-semibold shadow-sm' 
                        : 'text-white/95 hover:bg-white hover:text-primary' }}">
                    <i class="fa-solid fa-briefcase w-5 text-inherit"></i>
                    <span>Laboral</span>
                </a>

                {{-- Formación --}}
                <a href="#"
                    class="group flex items-center gap-3 px-3 py-2 rounded-lg transition text-white/95 hover:bg-white hover:text-primary">
                    <i class="fa-solid fa-graduation-cap w-5 text-inherit"></i>
                    <span>Formación</span>
                </a>

                {{-- Bienestar --}}
                <a href="#"
                    class="group flex items-center gap-3 px-3 py-2 rounded-lg transition text-white/95 hover:bg-white hover:text-primary">
                    <i class="fa-solid fa-heart w-5 text-inherit"></i>
                    <span>Bienestar</span>
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



        {{-- Contenido principal --}}
        <main class="flex-1 flex flex-col">
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
                        <span class="text-sm font-medium text-gray-700">
                            {{ Auth::user()->name ?? 'Invitado' }}
                        </span>
                    </div>
                </div>
            </header>


            {{-- Contenido dinámico --}}
            <div class="p-6 flex-1">
                @yield('content')
            </div>
        </main>
    </div>
</body>

</html>