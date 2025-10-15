<header class="sticky top-0 z-40 bg-primary text-white backdrop-blur border-b border-silver">
    <nav class="container-app flex items-center justify-between py-3">
        <a href="{{ url('/') }}" class="flex items-center gap-2 font-poppins text-xl text-gunmetal">
            <span class="inline-block w-2.5 h-6 bg-primary rounded"></span>
            <span class="font-bold">Egresados <span class="text-white">360</span></span>
        </a>
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
        <button type="button" class="md:hidden inline-flex items-center justify-center w-10 h-10 rounded-xl bg-white shadow-soft border border-silver" aria-label="Abrir menú">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                <path fill-rule="evenodd" d="M3.75 5.25a.75.75 0 01.75-.75h15a.75.75 0 010 1.5H4.5a.75.75 0 01-.75-.75zm0 6a.75.75 0 01.75-.75h15a.75.75 0 010 1.5H4.5a.75.75 0 01-.75-.75zm0 6a.75.75 0 01.75-.75h15a.75.75 0 010 1.5H4.5a.75.75 0 01-.75-.75z" clip-rule="evenodd" />
            </svg>
        </button>
    </nav>
</header>