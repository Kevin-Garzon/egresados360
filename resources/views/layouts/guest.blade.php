<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Egresados 360 - Administrador')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-silver font-inter text-rblack flex flex-col min-h-screen">

    {{-- NAV --}}
    @include('partials.nav')

    {{-- CONTENIDO PRINCIPAL --}}
    <main class="flex-1 flex items-center justify-center py-12">
        @yield('content')
    </main>

    {{-- FOOTER --}}
    @include('partials.footer')

</body>
</html>
