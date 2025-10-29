<header x-data="{ open: false }" class="sticky top-0 z-50 bg-primary text-white backdrop-blur border-b border-silver">
    <nav class="container-app flex items-center justify-between py-3">
        <a href="{{ url('/') }}" class="flex items-center gap-2 font-poppins text-xl text-gunmetal">
            <span class="inline-block w-2.5 h-6 bg-primary rounded"></span>
            <span class="font-bold">Egresados <span class="text-white">360</span></span>
        </a>

        {{-- Menú principal (desktop) --}}
        <ul class="hidden md:flex items-center gap-6 text-white">
            <li>
                <a href="{{ url('/') }}"
                    class="relative px-1 transition font-medium
                    @if(request()->is('/')) font-bold text-white after:absolute after:left-0 after:-bottom-1 after:w-full after:h-0.5 after:bg-white after:rounded-full @else after:w-0 @endif
                    after:transition-all after:duration-300
                    hover:font-bold hover:text-white
                    hover:after:w-full hover:after:absolute hover:after:left-0 hover:after:-bottom-1 hover:after:h-0.5 hover:after:bg-white hover:after:rounded-full">
                    Inicio
                </a>
            </li>
            <li>
                <a href="{{ url('/laboral') }}"
                    class="relative px-1 transition font-medium
                    @if(request()->is('laboral')) font-bold text-white after:absolute after:left-0 after:-bottom-1 after:w-full after:h-0.5 after:bg-white after:rounded-full @else after:w-0 @endif
                    after:transition-all after:duration-300
                    hover:font-bold hover:text-white
                    hover:after:w-full hover:after:absolute hover:after:left-0 hover:after:-bottom-1 hover:after:h-0.5 hover:after:bg-white hover:after:rounded-full">
                    Ofertas Laborales
                </a>
            </li>
            <li>
                <a href="{{ url('/formacion') }}"
                    class="relative px-1 transition font-medium
                    @if(request()->is('formacion')) font-bold text-white after:absolute after:left-0 after:-bottom-1 after:w-full after:h-0.5 after:bg-white after:rounded-full @else after:w-0 @endif
                    after:transition-all after:duration-300
                    hover:font-bold hover:text-white
                    hover:after:w-full hover:after:absolute hover:after:left-0 hover:after:-bottom-1 hover:after:h-0.5 hover:after:bg-white hover:after:rounded-full">
                    Formación
                </a>
            </li>
            <li>
                <a href="{{ url('/bienestar') }}"
                    class="relative px-1 transition font-medium
                    @if(request()->is('bienestar')) font-bold text-white after:absolute after:left-0 after:-bottom-1 after:w-full after:h-0.5 after:bg-white after:rounded-full @else after:w-0 @endif
                    after:transition-all after:duration-300
                    hover:font-bold hover:text-white
                    hover:after:w-full hover:after:absolute hover:after:left-0 hover:after:-bottom-1 hover:after:h-0.5 hover:after:bg-white hover:after:rounded-full">
                    Bienestar
                </a>
            </li>
            <li>
                <a class="btn btn-tertiary py-2" href="{{ url('/login') }}">Administrador</a>
            </li>
        </ul>

        {{-- Botón móvil --}}
        <button @click="open = !open" type="button"
            class="md:hidden inline-flex items-center justify-center w-10 h-10 rounded-xl bg-white text-gunmetal shadow-soft border border-silver"
            aria-label="Abrir menú">
            <svg x-show="!open" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                class="w-6 h-6">
                <path fill-rule="evenodd"
                    d="M3.75 5.25h16.5M3.75 12h16.5M3.75 18.75h16.5"
                    stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
            </svg>
            <svg x-show="open" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </nav>

    {{-- Menú móvil --}}
    <div x-show="open"
        x-transition:enter="transition ease-out duration-700"
        x-transition:enter-start="opacity-0 -translate-y-5"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-600"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 -translate-y-5"
        class="absolute top-full left-0 w-full bg-white text-gunmetal border-t border-silver shadow-lg md:hidden">
        <ul class="flex flex-col space-y-2 py-3 px-5">
            <li><a href="{{ url('/') }}" class="block py-2 font-medium hover:text-primary transition">Inicio</a></li>
            <li><a href="{{ url('/laboral') }}" class="block py-2 font-medium hover:text-primary transition">Ofertas Laborales</a></li>
            <li><a href="{{ url('/formacion') }}" class="block py-2 font-medium hover:text-primary transition">Formación</a></li>
            <li><a href="{{ url('/bienestar') }}" class="block py-2 font-medium hover:text-primary transition">Bienestar</a></li>
            <li><a href="{{ url('/login') }}" class="block py-2 font-medium hover:text-primary transition">Administrador</a></li>
        </ul>
    </div>
</header>
