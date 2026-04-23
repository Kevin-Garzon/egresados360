@extends('layouts.app')

@section('title', 'Inicio — Egresados 360')

{{-- Hero de bienvenida --}}
@section('hero')
<x-hero
    badge="Egresados 360"
    title="Bienvenidos"
    highlight="Egresados FET"
    subtitle="Orgullo Institucional"
    description="Somos el puente entre la FET y sus egresados: aquí encontrarás oportunidades laborales, formación continua y actividades de bienestar."
    :btnPrimary="[
            'text' => 'Contáctanos',
            'icon' => 'fa-brands fa-whatsapp',
            'link' => 'https://wa.me/573224650595'
        ]"
    :btnSecondary="[
            'text' => 'Contáctanos',
            'icon' => 'fa-solid fa-envelope',
            'link' => 'https://mail.google.com/mail/?view=cm&to=ori-egresados@fet.edu.co'
        ]"
    image="{{ asset('imgs/egre9.jpg') }}" />
@endsection


{{-- Contenido específico de la página --}}
@section('content')

{{-- Nuestra Oficina de Egresados --}}
<section id="oficina" class="relative py-20 text-white overflow-hidden">
    <div class="absolute inset-0 bg-[#09B451]"></div>

    <div class="relative container-app grid lg:grid-cols-2 gap-12 items-center">
        {{-- Imagen --}}
        <figure class="flex justify-center lg:justify-start">
            <img
                src="{{ asset('imgs/egre2.jpg') }}"
                alt="Oficina de Egresados"
                class="w-11/12 sm:w-4/5 md:w-3/4 rounded-2xl shadow-card object-cover transition-transform duration-500 hover:scale-[1.03]">
        </figure>

        {{-- Texto --}}
        <div class="text-center lg:text-left">
            <h2 class="text-3xl sm:text-4xl font-poppins font-semibold tracking-tight">
                Nuestra Oficina de
            </h2>
            <p class="text-5xl sm:text-6xl font-bold leading-none mt-2 text-white">
                Egresados
            </p>

            <p class="mt-6 text-base sm:text-lg text-white/90 leading-relaxed max-w-prose mx-auto lg:mx-0">
                Acompañamos a nuestros graduados con servicios, oportunidades y articulación con aliados para su
                crecimiento profesional. Fomentamos el vínculo permanente con la institución y fortalecemos la
                proyección laboral y social de nuestros egresados.
            </p>

            {{-- Botones (alto contraste sobre fondo verde) --}}
            <div class="mt-8 flex flex-row justify-center lg:justify-start gap-4">
                {{-- Botón Visítanos --}}
                <button
                    onclick="document.getElementById('mapModal').classList.remove('hidden')"
                    class="btn !bg-white !text-[#09B451] hover:!bg-silver px-8 flex items-center gap-2 font-semibold">
                    <i class="fa-solid fa-location-dot"></i> Visítanos
                </button>

                {{-- Botón Política (PDF) --}}
                <a href="{{ asset('pdfs/politica_de_egresados.pdf') }}" target="_blank"
                    class="btn !bg-[#383D38] !text-white px-8 flex items-center gap-2 font-semibold rounded-md shadow-sm transition">
                    <i class="fa-solid fa-file-lines"></i> Política
                </a>
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

{{-- Últimas Novedades --}}
<section id="ultimas-novedades" class="py-24 bg-white relative">
    <div class="container-app text-center mb-12">
        <h2 class="text-3xl sm:text-4xl font-poppins font-semibold">
            Últimas <span class="text-primary">Novedades</span>
        </h2>
        <p class="mt-3 text-rblack/70 max-w-2xl mx-auto">
            Entérate de las publicaciones más recientes de los módulos de Formación, Bienestar y Oportunidades Laborales.
        </p>
    </div>

    {{-- Carrusel --}}
    <div
        x-data="{
        scrollAmount: window.innerWidth < 640 ? 2 : 1,
        startAutoScroll() {
          const container = this.$refs.slider;
          const intervalTime = window.innerWidth < 640 ? 15 : 20;
          setInterval(() => {
            container.scrollLeft += this.scrollAmount;
            if (container.scrollLeft + container.clientWidth >= container.scrollWidth) {
              container.scrollLeft = 0;
            }
          }, intervalTime);
        }
      }"
        x-init="startAutoScroll()"
        class="relative px-6 md:px-12">

        <div
            x-ref="slider"
            class="flex gap-6 overflow-hidden scroll-smooth select-none py-8">

            @foreach(array_merge($items->toArray(), $items->toArray()) as $item)
            @php
            $visual = match($item['tipo']) {
            'Laboral' => ['color' => 'text-primary', 'bg' => 'bg-white', 'icon' => 'fa-briefcase', 'img' => 'https://www.stelorder.com/wp-content/uploads/2021/09/portada-sociedad-laboral.jpg'],
            'Formación' => ['color' => 'text-blue-600', 'bg' => 'bg-white', 'icon' => 'fa-graduation-cap', 'img' => 'https://www.ceduk.edu.mx/blog/wp-content/uploads/2024/07/tecnicas-de-estudio-ejercicios.jpg'],
            'Evento' => ['color' => 'text-yellow-600', 'bg' => 'bg-white', 'icon' => 'fa-calendar-days', 'img' => 'https://storage.googleapis.com/www-saludiario-com/wp-content/uploads/2023/08/8e35f3c3-bienestar-integral.jpg'],
            'Habilidad' => ['color' => 'text-emerald-600', 'bg' => 'bg-white', 'icon' => 'fa-lightbulb', 'img' => 'https://storage.googleapis.com/www-saludiario-com/wp-content/uploads/2023/08/8e35f3c3-bienestar-integral.jpg'],
            'Servicio' => ['color' => 'text-rose-600', 'bg' => 'bg-white', 'icon' => 'fa-hand-holding-heart', 'img' => 'https://storage.googleapis.com/www-saludiario-com/wp-content/uploads/2023/08/8e35f3c3-bienestar-integral.jpg'],
            'Mentoría' => ['color' => 'text-indigo-600', 'bg' => 'bg-white', 'icon' => 'fa-user-tie', 'img' => 'https://storage.googleapis.com/www-saludiario-com/wp-content/uploads/2023/08/8e35f3c3-bienestar-integral.jpg'],
            default => ['color' => 'text-gray-600', 'bg' => 'bg-white', 'icon' => 'fa-circle-info', 'img' => 'https://blog.oncosalud.pe/hubfs/Bienestar%20Emocional%20Qu%C3%A9%20Debes%20Saber.jpg']
            };

            // Usa fecha_inicio o fecha si existe, sino created_at
            $fecha = $item['fecha_inicio'] ?? $item['fecha'] ?? $item['created_at'];
            @endphp

            {{-- Tarjeta --}}
            <div
                class="snap-center shrink-0 w-[280px] sm:w-[300px] md:w-[320px] lg:w-[340px] {{ $visual['bg'] }} rounded-3xl shadow-card hover:shadow-xl transition-transform duration-300 hover:-translate-y-1 mx-2 flex flex-col">
                <div class="h-44 w-full overflow-hidden rounded-t-3xl">
                    <img src="{{ $visual['img'] }}" alt="{{ $item['tipo'] }}" class="w-full h-full object-cover">
                </div>

                <div class="p-6 text-center flex flex-col flex-1 justify-between">
                    <div>
                        <div class="flex justify-center mb-3">
                            <div class="w-12 h-12 flex items-center justify-center rounded-full bg-gray-50 shadow-inner {{ $visual['color'] }} text-xl">
                                <i class="fa-solid {{ $visual['icon'] }}"></i>
                            </div>
                        </div>
                        <h3 class="font-poppins font-semibold text-lg text-gunmetal mb-1">
                            {{ Str::limit($item['titulo'], 60) }}
                        </h3>
                        <p class="text-sm text-rblack/60 mb-4">
                            {{ $item['tipo'] }} — {{ \Carbon\Carbon::parse($fecha)->translatedFormat('d M, Y') }}
                        </p>
                    </div>

                    {{-- Botón unificado --}}
                    <a href="{{ $item['url'] }}" target="_blank"
                        class="btn btn-primary w-full justify-center py-2">
                        <i class="fa-solid fa-arrow-right mr-2"></i> Ver más
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>






{{-- Nuestros Egresados FET --}}
<section id="egresados-fet" class="container-app py-20 bg-silver">
    <div class="grid md:grid-cols-2 gap-12 items-center">

        {{-- Imagen --}}
        <div>
            <img src="{{ asset('imgs/egre3.jpg') }}"
                alt="Egresados FET"
                class="w-full h-full object-cover rounded-lg shadow-card">
        </div>

        {{-- Texto y datos --}}
        <div>
            <h2 class="text-3xl sm:text-4xl font-poppins font-bold mb-5">
                Nuestros <span class="text-primary">Egresados FET</span>
            </h2>
            <p class="text-rblack/70 leading-relaxed mb-10">
                Nuestros egresados son el orgullo de la FET. Profesionales íntegros, innovadores y comprometidos con el desarrollo social y productivo de la región. A través de su desempeño, fortalecen el nombre de nuestra institución y mantienen viva la misión formativa que nos une.
            </p>

            {{-- Datos destacados --}}
            <div class="grid sm:grid-cols-2 gap-8">
                <div class="flex items-start gap-4">
                    <div class="w-10 h-10 flex items-center justify-center rounded-full bg-primary text-white text-lg shrink-0">
                        <i class="fa-solid fa-plus"></i>
                    </div>
                    <div>
                        <h3 class="font-semibold text-lg">Talento y Liderazgo</h3>
                        <p class="text-sm text-rblack/70">
                            Egresados que marcan la diferencia con su compromiso y excelencia profesional.
                        </p>
                    </div>
                </div>

                <div class="flex items-start gap-4">
                    <div class="w-10 h-10 flex items-center justify-center rounded-full bg-primary text-white text-lg shrink-0">
                        <i class="fa-solid fa-plus"></i>
                    </div>
                    <div>
                        <h3 class="font-semibold text-lg">Proyección Constante</h3>
                        <p class="text-sm text-rblack/70">
                            Egresados que siguen creciendo y aportando al desarrollo de la regional e institucional.
                        </p>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>






{{-- Principios Institucionales --}}
<section id="principios" class="container-app py-20">
    {{-- Título --}}
    <div class="text-center max-w-3xl mx-auto">
        <h2 class="text-3xl sm:text-4xl font-poppins font-semibold mb-4">
            Principios <span class="text-primary">Institucionales</span>
        </h2>
        <p class="text-rblack/70">
            Los principios institucionales de la FET reflejan nuestro compromiso con la excelencia académica, la innovación y el desarrollo sostenible de nuestra comunidad.
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





{{-- Canal Egresados WhatsApp --}}
<section id="canal-egresados" class="relative py-24 overflow-hidden">
    {{-- Fondo con gradiente --}}
    <div class="absolute inset-0 bg-gradient-to-r from-[#09B451] via-[#0a9a45] to-[#087d38]"></div>

    {{-- Patrón decorativo de fondo --}}
    <div class="absolute inset-0 opacity-10">
        <svg class="w-full h-full" viewBox="0 0 1200 600">
            <defs>
                <pattern id="whatsapp-pattern" x="0" y="0" width="200" height="200" patternUnits="userSpaceOnUse">
                    <circle cx="100" cy="100" r="80" fill="none" stroke="white" stroke-width="2" opacity="0.3" />
                    <text x="100" y="110" text-anchor="middle" fill="white" opacity="0.2" font-size="30">✓</text>
                </pattern>
            </defs>
            <rect width="1200" height="600" fill="url(#whatsapp-pattern)" />
        </svg>
    </div>

    {{-- Contenido --}}
    <div class="relative container-app">
        <div class="grid md:grid-cols-2 gap-12 items-center">


            {{-- Lado izquierdo: Elementos visuales (Oculto en móvil, visible en md en adelante) --}}
            <div class="relative hidden md:flex items-center justify-center mt-12 md:mt-0">
                {{-- Círculos decorativos --}}
                <div class="absolute w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>
                <div class="absolute w-40 h-40 bg-white/5 rounded-full blur-3xl top-20 left-20"></div>

                {{-- Mockup de teléfono/Chat --}}
                <div class="relative z-10 max-w-xs sm:max-w-sm md:max-w-xs lg:max-w-xs">
                    {{-- Teléfono --}}
                    <div class="bg-white rounded-3xl shadow-2xl overflow-hidden border-8 border-gray-900 aspect-[9/16]">
                        {{-- Status bar --}}
                        <div class="bg-gray-900 text-white px-4 py-1 text-xs flex justify-between items-center">
                            <span>9:41</span>
                            <div class="flex gap-1">
                                <i class="fa-solid fa-signal"></i>
                                <i class="fa-solid fa-wifi"></i>
                                <i class="fa-solid fa-battery-full"></i>
                            </div>
                        </div>

                        {{-- WhatsApp Header --}}
                        <div class="bg-[#128C7E] text-white px-4 py-3 flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <i class="fa-brands fa-whatsapp text-lg"></i>
                                <span class="font-semibold text-sm">Canal Egresados</span>
                            </div>
                            <i class="fa-solid fa-ellipsis-vertical text-sm"></i>
                        </div>

                        {{-- Chat área --}}
                        <div class="bg-gray-50 px-3 py-4 space-y-3 h-80 overflow-hidden">
                            {{-- Mensaje entrada --}}
                            <div class="flex justify-start">
                                <div class="bg-white rounded-lg rounded-tl-none px-3 py-2 shadow-sm max-w-xs">
                                    <p class="text-xs text-gray-700">¡Hola! Bienvenido al canal de egresados 👋</p>
                                </div>
                            </div>

                            {{-- Mensaje salida --}}
                            <div class="flex justify-end">
                                <div class="bg-[#DCF8C6] rounded-lg rounded-tr-none px-3 py-2 shadow-sm max-w-xs">
                                    <p class="text-xs text-gray-800">¡Gracias! Quiero estar siempre informado 📢</p>
                                </div>
                            </div>

                            {{-- Mensaje entrada --}}
                            <div class="flex justify-start">
                                <div class="bg-white rounded-lg rounded-tl-none px-3 py-2 shadow-sm max-w-xs">
                                    <p class="text-xs text-gray-700">Aquí compartimos ofertas laborales, eventos y más 💼✨</p>
                                </div>
                            </div>

                            {{-- Indicador de escritura --}}
                            <div class="flex justify-start">
                                <div class="bg-white rounded-lg rounded-tl-none px-3 py-2 shadow-sm">
                                    <div class="flex gap-1">
                                        <span class="w-2 h-2 bg-gray-400 rounded-full animate-bounce"></span>
                                        <span class="w-2 h-2 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 0.1s;"></span>
                                        <span class="w-2 h-2 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 0.2s;"></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Input area --}}
                        <div class="bg-gray-100 px-3 py-3 flex items-center gap-2 border-t border-gray-200">
                            <i class="fa-solid fa-face-smile text-[#128C7E] text-lg cursor-pointer"></i>
                            <input type="text" placeholder="Escribe un mensaje..." class="flex-1 bg-white rounded-full px-4 py-2 text-xs outline-none border border-gray-300">
                            <i class="fa-solid fa-microphone text-[#128C7E] text-lg cursor-pointer"></i>
                        </div>
                    </div>

                    {{-- Badge flotante --}}
                    <div class="absolute -bottom-4 -right-4 bg-white rounded-full w-16 h-16 flex items-center justify-center shadow-lg border-4 border-[#09B451]">
                        <div class="text-center">
                            <div class="text-4xl font-bold text-[#09B451]">+</div>
                            <!-- <div class="text-xs font-semibold text-gray-700">Únete</div> -->
                        </div>
                    </div>
                </div>
            </div>

            {{-- Lado derecho: Contenido --}}
            <div class="text-white flex flex-col items-center md:items-start text-center md:text-left">
                {{-- Badge --}}
                <div class="inline-block mb-6 px-4 py-2 bg-white/20 rounded-full border border-white/30 backdrop-blur-sm">
                    <span class="text-sm font-semibold flex items-center gap-2">
                        <i class="fa-brands fa-whatsapp"></i> Conecta con nosotros
                    </span>
                </div>

                {{-- Título --}}
                <h2 class="text-3xl sm:text-4xl md:text-5xl font-poppins font-bold mb-6 leading-tight">
                    Únete a nuestro<br>
                    <span class="relative font-colors text-silver">
                        Canal Egresados
                    </span>
                </h2>

                {{-- Imagen visible solo en responsive (Oculta en md en adelante) --}}
                <div class="block md:hidden mb-8 w-full max-w-sm">
                    <img src="{{ asset('imgs/canal-img.jpg') }}" alt="Estudiante en el canal" class="w-full h-auto rounded-2xl shadow-lg border-2 border-white/20">
                </div>

                {{-- Descripción --}}
                <p class="text-lg text-white/90 mb-8 leading-relaxed max-w-lg">
                    Mantente informado de todas las oportunidades, eventos, formaciones y noticias importantes de la comunidad FET.
                    Entra y sé parte de nuestra red de egresados.
                </p>

                {{-- Beneficios --}}
                <div class="space-y-4 mb-10 w-full md:w-auto">
                    <div class="flex items-start gap-3">
                        <div class="w-6 h-6 rounded-full bg-white/30 flex items-center justify-center flex-shrink-0 mt-1">
                            <i class="fa-solid fa-check text-white text-sm"></i>
                        </div>
                        <span class="text-white/95">Ofertas laborales exclusivas</span>
                    </div>
                    <div class="flex items-start gap-3">
                        <div class="w-6 h-6 rounded-full bg-white/30 flex items-center justify-center flex-shrink-0 mt-1">
                            <i class="fa-solid fa-check text-white text-sm"></i>
                        </div>
                        <span class="text-white/95">Eventos y actividades de bienestar</span>
                    </div>
                    <div class="flex items-start gap-3">
                        <div class="w-6 h-6 rounded-full bg-white/30 flex items-center justify-center flex-shrink-0 mt-1">
                            <i class="fa-solid fa-check text-white text-sm"></i>
                        </div>
                        <span class="text-white/95">Programas de formación continua</span>
                    </div>
                    <div class="flex items-start gap-3">
                        <div class="w-6 h-6 rounded-full bg-white/30 flex items-center justify-center flex-shrink-0 mt-1">
                            <i class="fa-solid fa-check text-white text-sm"></i>
                        </div>
                        <span class="text-white/95">Conexión con la FET</span>
                    </div>
                </div>

                {{-- CTA Botón --}}
                <a href="https://whatsapp.com/channel/0029Vb6m945GZNCmGywXOd0o" target="_blank"
                    class="inline-flex items-center gap-3 bg-white text-[#09B451] hover:bg-silver px-6 py-2 rounded-lg font-poppins font-bold text-lg shadow-lg transition-all duration-300 hover:shadow-xl hover:scale-105 group">
                    <i class="fa-brands fa-whatsapp text-2xl group-hover:animate-pulse"></i>
                    <span>Unirme al Canal</span>
                </a>
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
                Es de suma importancia que los estudiantes al terminar sus estudios y obtener el título de grado, efectúen los trámites correspondientes para obtener el carné de graduado, que además de identificarlo como parte activa de la comunidad universitaria FET , posibilita el acceso a los servicios que la institución le ofrece.
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

            <img src="{{ asset('imgs/egre1.jpg') }}"
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

@endsection