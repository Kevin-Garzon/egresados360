{{-- resources/views/layouts/app.blade.php --}}
<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <title>@yield('title', 'Egresados 360')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
    {{-- <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}"> --}}

    {{-- Tipografías (Poppins + Inter) --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Poppins:wght@600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>

<body class="bg-white text-rblack font-inter flex flex-col min-h-dvh">

    {{-- Topbar institucional --}}
    <div class="w-full bg-rblack text-white text-sm">
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

    {{-- Scripts Livewire --}}
    @livewireScripts

    {{-- Formulario de perfil del egresado (modal global) --}}
    @livewire('public.perfil-egresado-form')


    <script>
        document.addEventListener('perfil-guardado', e => {
            localStorage.setItem('perfil_id', e.detail.id);
        });
    </script>

    <script>
        // Reanudar clic pendiente cuando se haya guardado el perfil
        document.addEventListener('perfil-guardado', (e) => {
            // ya guardas perfil_id arriba, aquí reanudamos la acción
            const raw = localStorage.getItem('pendiente_click');
            if (!raw) return;

            const data = JSON.parse(raw);
            data.perfil_id = e.detail.id; // asegura que va el nuevo id

            // Enviar interacción al backend de métricas
            fetch('/api/track/interaction', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify(data)
            }).catch(() => {}).finally(() => {
                // Si esa acción era abrir un enlace, ábrelo ahora
                if (data.url) window.open(data.url, '_blank');
                localStorage.removeItem('pendiente_click');
            });
        });
    </script>



    <script>
        document.addEventListener('DOMContentLoaded', async () => {
            const fechaHoy = new Date().toISOString().split('T')[0];
            const ultimaVisita = localStorage.getItem('ultima_visita');

            // Si no hay registro o la fecha cambió (nuevo día o sesión nueva)
            if (!ultimaVisita || ultimaVisita !== fechaHoy) {
                try {
                    await fetch('/api/registrar-visita', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        }
                    });
                    localStorage.setItem('ultima_visita', fechaHoy);
                    console.log(' Visita registrada');
                } catch (error) {
                    console.error(' Error al registrar la visita:', error);
                }
            } else {
                console.log('Visita ya registrada hoy');
            }
        });
    </script>



</body>

</html>