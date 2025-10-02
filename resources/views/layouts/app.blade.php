{{-- resources/views/layouts/app.blade.php --}}
<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <title>@yield('title', 'Egresados 360')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
    <!-- <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}"> -->


    {{-- Tipografías (Poppins + Inter) --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Poppins:wght@600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-white text-rblack font-inter flex flex-col min-h-dvh">

    {{-- 🔹 Topbar institucional --}}
    <div class="w-full bg-gunmetal text-white text-sm">
        <div class="container-app flex items-center justify-between py-2">
            <div class="flex items-center gap-4">
                <span class="hidden sm:inline">Egresados 360</span>
                <span class="opacity-70">Campus FET</span>
            </div>
            <div class="flex items-center gap-4">
                <a href="#" class="hover:underline">Atención</a>
                <a href="#" class="hover:underline">Síguenos</a>
            </div>
        </div>
    </div>

    {{-- Navbar principal --}}
    @include('partials.nav')

    {{-- Hero (solo mostrar si estamos en Inicio) --}}
    @hasSection('hero')
    @yield('hero')
    @endif

    {{-- Contenido dinámico --}}
    <main class="flex-1">
        @yield('content')
    </main>

    {{-- Footer institucional --}}
    @include('partials.footer')

</body>

</html>