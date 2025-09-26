{{-- resources/views/layouts/app.blade.php --}}
<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <title>@yield('title', 'Egresados 360')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />

    {{-- Tipografías (Poppins + Inter) --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Poppins:wght@600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-silver text-rblack font-inter flex flex-col min-h-dvh">

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

    {{-- 🔹 Navbar principal --}}
    <header class="sticky top-0 z-40 bg-primary text-white backdrop-blur border-b border-silver">
        <nav class="container-app flex items-center justify-between py-3">
            <a href="{{ url('/') }}" class="flex items-center gap-2 font-poppins text-xl text-gunmetal">
                <span class="inline-block w-2.5 h-6 bg-primary rounded"></span>
                <span class="font-bold">Egresados <span class="text-white">360</span></span>
            </a>
            <ul class="hidden md:flex items-center gap-6 text-white">
                <li><a class="hover:text-gunmetal" href="{{ url('/') }}">Inicio</a></li>
                <li><a class="hover:text-gunmetal" href="{{ url('/laboral') }}">Ofertas Laborales</a></li>
                <li><a class="hover:text-gunmetal" href="{{ url('/formacion') }}">Formación</a></li>
                <li><a class="hover:text-gunmetal" href="{{ url('/bienestar') }}">Bienestar</a></li>
                <li>
                    <a class="btn btn-tertiary py-2" href="{{ url('/admin/login') }}">Administrador</a>
                </li>
            </ul>
            {{-- Botón móvil --}}
            <button type="button" class="md:hidden inline-flex items-center justify-center w-10 h-10 rounded-xl bg-white shadow-soft border border-silver" aria-label="Abrir menú">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                    <path fill-rule="evenodd" d="M3.75 5.25a.75.75 0 01.75-.75h15a.75.75 0 010 1.5H4.5a.75.75 0 01-.75-.75zm0 6a.75.75 0 01.75-.75h15a.75.75 0 010 1.5H4.5a.75.75 0 01-.75-.75zm0 6a.75.75 0 01.75-.75h15a.75.75 0 010 1.5H4.5a.75.75 0 01-.75-.75z" clip-rule="evenodd" />
                </svg>
            </button>
        </nav>
    </header>

    {{-- 🔹 Hero (solo mostrar si estamos en Inicio) --}}
    @hasSection('hero')
    @yield('hero')
    @endif

    {{-- 🔹 Contenido dinámico --}}
    <main class="flex-1">
        @yield('content')
    </main>

    {{-- 🔹 Footer institucional --}}
    <footer class="mt-16 border-t border-silver bg-primary text-white">
        <div class="container-app py-10 grid gap-8 md:grid-cols-4">
            <div>
                <div class="flex items-center gap-2 mb-3">
                    <!-- <span class="inline-block w-2.5 h-6 bg-primary rounded"></span> -->
                    <span class="font-poppins text-lg font-bold text-gunmetal text-white">Egresados 360</span>
                </div>
                <p class="text-sm text-white">Portal de egresados de la FET. Información, formación, empleabilidad y bienestar.</p>
            </div>
            <div>
                <h3 class="font-poppins font-semibold text-gunmetal mb-3 text-white">Campus FET</h3>
                <ul class="space-y-1 text-sm">
                    <li>Dirección: Kilometro 12 <br> Neiva - Rivera</li>
                    <li>Email: <a class="underline" href="mailto:comunicaciones@fet.edu.co">comunicaciones@fet.edu.co</a></li>
                    <li>WhatsApp: <a class="underline" href="#">+57 (XXX) XXX XXXX</a></li>
                </ul>
            </div>
            <div>
                <h3 class="font-poppins font-semibold text-gunmetal mb-3 text-white">Enlaces</h3>
                <ul class="space-y-2 text-sm">
                    <li><a class="hover:underline" href="{{ url('/laboral') }}">Ofertas Laborales</a></li>
                    <li><a class="hover:underline" href="{{ url('/formacion') }}">Formación Continua</a></li>
                    <li><a class="hover:underline" href="{{ url('/bienestar') }}">Bienestar del Egresado</a></li>
                </ul>
            </div>
            <div>
                <h3 class="font-poppins font-semibold mb-3 text-white">Síguenos</h3>
                <ul class="space-y-2 text-sm">
                    <li>
                        <a href="https://twitter.com/tu_usuario" target="_blank" class="flex items-center gap-2 hover:underline text-white">
                            <i class="fab fa-twitter text-white"></i> Twitter
                        </a>
                    </li>
                    <li>
                        <a href="https://facebook.com/tu_usuario" target="_blank" class="flex items-center gap-2 hover:underline text-white">
                            <i class="fab fa-facebook-f text-white"></i> Facebook
                        </a>
                    </li>
                    <li>
                        <a href="https://tiktok.com/@tu_usuario" target="_blank" class="flex items-center gap-2 hover:underline text-white">
                            <i class="fab fa-tiktok text-white"></i> TikTok
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="border-t border-silver/70 py-4 text-center text-xs text-white">
            © {{ date('Y') }} FET. Todos los derechos reservados — Egresados 360
        </div>
    </footer>
</body>

</html>