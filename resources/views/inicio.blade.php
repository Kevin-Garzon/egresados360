@extends('layouts.app')

@section('title', 'Inicio — Egresados 360')

{{-- Hero de bienvenida --}}
@section('hero')
<section class="relative overflow-hidden bg-white">
    <div class="container-app min-h-[calc(100vh-64.8px)] py-16 flex items-center lg:grid lg:grid-cols-2 gap-10">
        <div>
            <span class="badge mb-4">Egresados 360</span>
            <h1 class="text-4xl sm:text-5xl font-poppins font-semibold leading-tight text-gunmetal">
                Bienvenidos <br><span class="text-primary font-bold">Egresados FET</span>
                <span class="block">Orgullo Institucional</span>
            </h1>
            <p class="mt-5 text-lg text-rblack/80 max-w-prose">
                Somos el puente entre la FET y sus egresados: aquí encontrarás oportunidades laborales, formación continua y actividades de bienestar.
            </p>
            <div class="mt-8 flex flex-wrap gap-3">
                <a href="#contacto" class="btn btn-primary"><i class="fa-brands fa-whatsapp" style="color: #ffffff;"></i>Contáctanos</a>
                <a href="#ofertas" class="btn btn-secondary"><i class="fa-solid fa-envelope text-white"></i>Contactanos</a>
            </div>
        </div>
        <div>
            <div class="aspect-[4/3] md:aspect-[16/10] card p-2">
                <img src="https://images.unsplash.com/photo-1541339907198-e08756dedf3f?q=80&w=1400&auto=format&fit=crop"
                    alt="Egresados FET" class="w-full h-full object-cover rounded-2xl" />
            </div>
        </div>
    </div>
</section>
@endsection

{{-- Contenido específico de la página --}}
@section('content')

{{-- Nuestra Oficina de Egresados --}}
<section id="oficina" class="relative py-16">
    {{-- Capa de fondo: imagen + overlay verde (full width) --}}
    <div class="bg-campus-overlay">
        <div class="container-app relative py-10 md:py-14">
            <div class="grid md:grid-cols-2 gap-8 items-center">

                {{-- IMAGEN SALIDA DEL CONTENEDOR --}}
                <figure class="relative z-10 md:-ml-16 -mt-10 md:-mt-16">
                    <img
                        src="https://images.unsplash.com/photo-1523240795612-9a054b0db644?q=80&w=1170&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                        alt="Oficina de Egresados"
                        class="w-[560px] max-w-full rounded-3xl shadow-card">
                </figure>

                {{-- TEXTO + ACCIONES SOBRE EL FONDO VERDE --}}
                <div class="text-white md:pr-6">
                    <h2 class="text-3xl sm:text-4xl font-poppins font-semibold tracking-tight">
                        Nuestra Oficina de
                    </h2>
                    <p class="text-6xl sm:text-6xl font-bold leading-none mt-2">Egresados</p>

                    <p class="mt-6 text-white/90 text-lg leading-8 max-w-prose">
                        Interdum neque lectus sodales torquent congue a potenti mollis. Acompañamos a nuestros
                        graduados con servicios, oportunidades y articulación con aliados para tu crecimiento profesional.
                        Interdum neque lectus sodales torquent congue a potenti mollis. Acompañamos a nuestros graduados con
                        servicios.

                    <div class="mt-8 flex flex-wrap gap-4">
                        <button
                            onclick="document.getElementById('mapModal').classList.remove('hidden')"
                            class="btn btn-secondary px-8">
                            Visítanos
                        </button>
                        <button
                            onclick="document.getElementById('infoModal').classList.remove('hidden')"
                            class="btn btn-light px-8">
                            Leer más
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>


{{-- Modal Google Maps --}}
<div id="mapModal" class="hidden fixed inset-0 bg-black/60 flex items-center justify-center z-50">
    <div class="bg-white rounded-2xl shadow-card max-w-3xl w-full p-4 relative">
        <button onclick="document.getElementById('mapModal').classList.add('hidden')"
            class="absolute top-3 right-3 text-gray-500 hover:text-primary">&times;</button>
        <h3 class="text-lg font-poppins font-semibold mb-4">Ubicación FET</h3>
        <div class="aspect-[16/9]">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d5635.543035503272!2d-75.29116381131806!3d2.836314084387425!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8e3b6d83def774a9%3A0xfb5a162c62ab1bd1!2sFET%20Fundaci%C3%B3n%20Escuela%20Tecnol%C3%B3gica%20De%20Neiva%20%22Jes%C3%BAs%20Oviedo%20Perez%22!5e0!3m2!1ses!2sco!4v1758896254978!5m2!1ses!2sco"
                class="w-full h-full rounded-lg border-0"
                allowfullscreen=""
                loading="lazy"
                referrerpolicy="no-referrer-when-downgrade">
            </iframe>
        </div>
    </div>
</div>

{{-- Modal Leer más --}}
<div id="infoModal" class="hidden fixed inset-0 bg-black/60 flex items-center justify-center z-50">
    <div class="bg-white rounded-2xl shadow-card max-w-2xl w-full p-6 relative">
        <button onclick="document.getElementById('infoModal').classList.add('hidden')"
            class="absolute top-3 right-3 text-gray-500 hover:text-primary">&times;</button>
        <h3 class="text-lg font-poppins font-semibold mb-4">Más sobre la Oficina de Egresados</h3>
        <p class="text-rblack/80 leading-relaxed">
            La Oficina de Egresados de la FET tiene como misión mantener un vínculo activo con nuestra comunidad graduada,
            apoyando su inserción laboral, la formación continua y el acceso a beneficios institucionales.
            <br><br>
            Promovemos alianzas estratégicas, el desarrollo de competencias y la participación en actividades que fortalecen
            el sentido de pertenencia y el impacto social de nuestros profesionales.
        </p>
    </div>
</div>




{{-- Principios Institucionales --}}
<section id="principios" class="container-app py-20">
    {{-- Título --}}
    <div class="text-center max-w-3xl mx-auto">
        <h2 class="text-3xl sm:text-4xl font-poppins font-semibold mb-4">
            Principios <span class="text-primary">Institucionales</span>
        </h2>
        <p class="text-rblack/70">
            Posuere suspendisse mattis, ligula molestie placerat odio leo accumsan nascetur pulvinar magna
            vehicula dignissim vivamus, facilisi velit ut quis donec pellentesque.
        </p>
    </div>

    {{-- Cards --}}
    <div class="mt-14 grid gap-8 md:grid-cols-3">
        {{-- Objetivo --}}
        <div class="card p-8 text-center">
            <div class="w-14 h-14 mx-auto flex items-center justify-center rounded-full bg-primary text-white text-2xl mb-6">
                <i class="fa-solid fa-circle-check"></i>
            </div>
            <h3 class="text-xl font-poppins font-semibold mb-3">Objetivo del Programa</h3>
            <p class="text-rblack/70">
                Otorgar beneficios y reconocimientos a los egresados y a quienes se destaquen en su labor profesional o en su aporte a la Institución.
            </p>
        </div>

        {{-- Misión --}}
        <div class="card p-8 text-center">
            <div class="w-14 h-14 mx-auto flex items-center justify-center rounded-full bg-gunmetal text-white text-2xl mb-6">
                <i class="fa-solid fa-leaf"></i>
            </div>
            <h3 class="text-xl font-poppins font-semibold mb-3">Misión del Programa</h3>
            <p class="text-rblack/70">
                La oficina de egresados de la Fundación Escuela Tecnológica de Neiva “Jesús Oviedo Pérez” busca afianzar y mantener la unión entre los egresados y la institución, fomentando su participación por medio de procesos de formación y capacitación académica continua, creando estrategias de vinculación y los canales necesarios para la comunicación asertiva con ellos.
            </p>
        </div>

        {{-- Visión --}}
        <div class="card p-8 text-center">
            <div class="w-14 h-14 mx-auto flex items-center justify-center rounded-full bg-primary text-white text-2xl mb-6">
                <i class="fa-solid fa-users"></i>
            </div>
            <h3 class="text-xl font-poppins font-semibold mb-3">Visión del Programa</h3>
            <p class="text-rblack/70">
                En el año 2020, la oficina de Egresados de la Fundación Escuela Tecnológica de Neiva “Jesús Oviedo Pérez” tendrá fortalecida la relación entre los egresados, la institución y el entorno social, para asegurar la calidad en la formación integral y mantener una comunicación asertiva con la comunidad de egresados.
            </p>
        </div>
    </div>
</section>





{{-- Nuestros Egresados FET --}}
<section id="egresados-fet" class="container-app py-20 bg-silver">
    <div class="grid md:grid-cols-2 gap-12 items-center">

        {{-- Imagen --}}
        <div>
            <img src="https://images.pexels.com/photos/3184292/pexels-photo-3184292.jpeg"
                alt="Egresados FET"
                class="w-full h-full object-cover rounded-lg shadow-card">
        </div>

        {{-- Texto y datos --}}
        <div>
            <h2 class="text-3xl sm:text-4xl font-poppins font-bold mb-5">
                Nuestros <span class="text-primary">Egresados FET</span>
            </h2>
            <p class="text-rblack/70 leading-relaxed mb-10">
                Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
            </p>

            {{-- Datos destacados --}}
            <div class="grid sm:grid-cols-2 gap-8">
                <div class="flex items-start gap-4">
                    <div class="w-10 h-10 flex items-center justify-center rounded-full bg-primary text-white text-lg shrink-0">
                        <i class="fa-solid fa-plus"></i>
                    </div>
                    <div>
                        <h3 class="font-semibold text-lg">Dato 1</h3>
                        <p class="text-sm text-rblack/70">
                            With lots of unique blocks, you can easily build a page without.
                        </p>
                    </div>
                </div>

                <div class="flex items-start gap-4">
                    <div class="w-10 h-10 flex items-center justify-center rounded-full bg-primary text-white text-lg shrink-0">
                        <i class="fa-solid fa-plus"></i>
                    </div>
                    <div>
                        <h3 class="font-semibold text-lg">Dato 2</h3>
                        <p class="text-sm text-rblack/70">
                            With lots of unique blocks, you can easily build a page without.
                        </p>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>






{{-- Nuestro Equipo --}}
<section id="equipo" class="container-app py-20 bg-white">
    {{-- Título --}}
    <div class="text-center max-w-2xl mx-auto mb-14">
        <h2 class="text-3xl sm:text-4xl font-poppins font-semibold">
            Nuestro <span class="text-primary">Equipo</span>
        </h2>
        <p class="mt-3 text-rblack/70">
            Conoce a las personas que hacen parte de la Oficina de Egresados de la FET.
        </p>
    </div>

    {{-- Grid de integrantes --}}
    <div class="grid gap-10 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">

        {{-- Miembro 1 --}}
        <div>
            <img src="https://randomuser.me/api/portraits/women/44.jpg"
                alt="Ana Cardozo"
                class="w-full h-72 object-cover rounded-lg">
            <div class="mt-4">
                <h3 class="font-poppins font-semibold text-lg">Ana Cardozo</h3>
                <p class="text-primary font-medium">Cargo de Ana</p>
                <p class="mt-2 text-sm text-rblack/70 leading-relaxed">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed euismod nunc nec lorem cursus, a bibendum urna tristique.
                </p>
            </div>
        </div>

        {{-- Miembro 2 --}}
        <div>
            <img src="https://randomuser.me/api/portraits/men/32.jpg"
                alt="Carlos Rodríguez"
                class="w-full h-72 object-cover rounded-lg">
            <div class="mt-4">
                <h3 class="font-poppins font-semibold text-lg">Carlos Rodríguez</h3>
                <p class="text-primary font-medium">Cargo de Carlos</p>
                <p class="mt-2 text-sm text-rblack/70 leading-relaxed">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed euismod nunc nec lorem cursus, a bibendum urna tristique.
                </p>
            </div>
        </div>

        {{-- Miembro 3 --}}
        <div>
            <img src="https://randomuser.me/api/portraits/women/65.jpg"
                alt="Ana Torres"
                class="w-full h-72 object-cover rounded-lg">
            <div class="mt-4">
                <h3 class="font-poppins font-semibold text-lg">Ana Torres</h3>
                <p class="text-primary font-medium">Cargo de Ana</p>
                <p class="mt-2 text-sm text-rblack/70 leading-relaxed">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed euismod nunc nec lorem cursus, a bibendum urna tristique.
                </p>
            </div>
        </div>

        {{-- Miembro 4 --}}
        <div>
            <img src="https://randomuser.me/api/portraits/men/71.jpg"
                alt="Luis Martínez"
                class="w-full h-72 object-cover rounded-lg">
            <div class="mt-4">
                <h3 class="font-poppins font-semibold text-lg">Luis Martínez</h3>
                <p class="text-primary font-medium">Cargo de Luis</p>
                <p class="mt-2 text-sm text-rblack/70 leading-relaxed">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed euismod nunc nec lorem cursus, a bibendum urna tristique.
                </p>
            </div>
        </div>

    </div>
</section>





{{-- Carnetización de Egresados --}}
<section id="carnetizacion" class="bg-cultured py-20">
    <div class="container-app grid md:grid-cols-2 gap-12 items-center">

        {{-- Texto --}}
        <div>
            <h2 class="text-3xl sm:text-4xl font-poppins font-bold mb-6 relative inline-block">
                <span class="relative z-10">Carnetización de <span class="text-primary">Egresados</span></span>
                {{-- Círculo decorativo detrás de "Carnetización" --}}
                <span class="absolute -left-4 top-1 w-10 h-10 bg-primary rounded-full -z-0"></span>
            </h2>

            <p class="text-rblack/70 leading-relaxed mb-8">
                La carnetización de egresados de la FET es un proceso que permite a nuestros graduados
                acceder a beneficios, servicios y reconocimiento institucional mediante un documento
                oficial que los identifica como parte activa de nuestra comunidad universitaria.
            </p>

            <button
                onclick="document.getElementById('carnetModal').classList.remove('hidden')"
                class="btn btn-primary">
                Leer más
            </button>
        </div>

        {{-- Imagen con decoraciones --}}
        <div class="relative inline-block mx-auto">
            {{-- Esquina superior izquierda decorativa --}}
            <span class="absolute -top-4 -left-4 w-10 h-10 bg-gunmetal rounded-lg"></span>
            {{-- Esquina inferior derecha decorativa --}}
            <span class="absolute -bottom-4 -right-4 w-10 h-10 bg-primary rounded-lg"></span>

            <img src="https://images.pexels.com/photos/1216589/pexels-photo-1216589.jpeg"
                alt="Carnetización de Egresados"
                class="max-w-xs md:max-w-sm lg:max-w-md rounded-2xl shadow-card relative z-10">
        </div>

        {{-- Modal Carnetización --}}
        <div id="carnetModal" class="hidden fixed inset-0 bg-black/60 flex items-center justify-center z-50">
            <div class="bg-white rounded-2xl shadow-card max-w-2xl w-full p-6 relative">
                {{-- Botón cerrar --}}
                <button
                    onclick="document.getElementById('carnetModal').classList.add('hidden')"
                    class="absolute top-3 right-3 text-gray-500 hover:text-primary text-2xl leading-none">
                    &times;
                </button>

                <h3 class="text-lg font-poppins font-semibold mb-4">Más sobre Carnetización de Egresados</h3>
                <p class="text-rblack/80 leading-relaxed">
                    El carné institucional es un documento que identifica a los egresados como miembros activos de la comunidad FET.
                    Además de servir como medio de identificación, brinda acceso a beneficios, convenios y servicios
                    tanto internos como externos de la universidad.
                    <br><br>
                    Para obtener el carné, el egresado debe realizar el proceso de solicitud en la Oficina de Egresados,
                    cumpliendo con los requisitos establecidos y actualizando su información en la base de datos institucional.
                </p>
            </div>
        </div>

    </div>
</section>




{{-- Resoluciones y Normas --}}
<section id="resoluciones" class="container-app py-20">
    {{-- Título --}}
    <div class="text-center max-w-2xl mx-auto mb-14">
        <h2 class="text-3xl sm:text-4xl font-poppins font-semibold">
            Resoluciones y <span class="text-primary">Normas</span>
        </h2>
        <p class="mt-3 text-rblack/70">
            Consulta aquí las resoluciones y normas institucionales vigentes relacionadas con los egresados de la FET.
        </p>
    </div>

    {{-- Grid de documentos --}}
    <div class="grid gap-8 sm:grid-cols-2 md:grid-cols-3">

        {{-- Documento 1 --}}
        <div class="card p-8 text-center">
            <div class="w-14 h-14 mx-auto flex items-center justify-center rounded-full bg-primary text-white text-2xl mb-6">
                <i class="fa-solid fa-file-pdf"></i>
            </div>
            <h3 class="text-lg font-poppins font-semibold">Resolución 001-2024</h3>
            <p class="text-primary font-medium mb-2">Sobre los egresados</p>
            <p class="text-sm text-rblack/70 mb-6">
                Política Institucional de Egresados y Servicios de Acompañamiento.
            </p>
            <a href="{{ asset('pdfs/politica_de_egresados.pdf') }}" target="_blank"
                class="btn btn-primary">
                Ver PDF
            </a>
        </div>

        {{-- Documento 2 --}}
        <div class="card p-8 text-center">
            <div class="w-14 h-14 mx-auto flex items-center justify-center rounded-full bg-gunmetal text-white text-2xl mb-6">
                <i class="fa-solid fa-file-pdf"></i>
            </div>
            <h3 class="text-lg font-poppins font-semibold">Resolución 002-2024</h3>
            <p class="text-primary font-medium mb-2">Normas académicas</p>
            <p class="text-sm text-rblack/70 mb-6">
                Reglamento general de egresados y disposiciones académicas institucionales.
            </p>
            <a href="{{ asset('pdfs/resolucion-002-2024.pdf') }}" target="_blank"
                class="btn btn-primary">
                Ver PDF
            </a>
        </div>

        {{-- Documento 3 --}}
        <div class="card p-8 text-center">
            <div class="w-14 h-14 mx-auto flex items-center justify-center rounded-full bg-primary text-white text-2xl mb-6">
                <i class="fa-solid fa-file-pdf"></i>
            </div>
            <h3 class="text-lg font-poppins font-semibold">Resolución 003-2024</h3>
            <p class="text-primary font-medium mb-2">Servicios institucionales</p>
            <p class="text-sm text-rblack/70 mb-6">
                Normas de acceso a beneficios y servicios institucionales para egresados.
            </p>
            <a href="{{ asset('pdfs/resolucion-003-2024.pdf') }}" target="_blank"
                class="btn btn-primary">
                Ver PDF
            </a>
        </div>

    </div>
</section>



@endsection