@extends('layouts.app')

@section('title', 'Ofertas de Formación — Egresados 360')

@section('content')

{{-- Hero de bienvenida --}}
<x-hero
  badge="Educación Continua"
  title="Ofertas de"
  highlight="Formación"
  subtitle="Cursos, diplomados y seminarios FET"
  description="Explora nuestra oferta de formación continua y fortalece tus competencias profesionales con programas actualizados y accesibles."
  :btnPrimary="['text' => 'Ver Cursos', 'icon' => 'fa-solid fa-book-open-reader', 'link' => '#formacion']"
  :btnSecondary="['text' => 'Docentes FET', 'icon' => 'fa-solid fa-chalkboard-user', 'link' => '#docentes']"
  image="https://www.ceduk.edu.mx/blog/wp-content/uploads/2024/07/tecnicas-de-estudio-ejercicios.jpg" />


{{-- Sección de Formación Continua --}}
<section id="formacion" class="container-app py-20">
  {{-- Título --}}
  <div class="text-center max-w-2xl mx-auto mb-14">
    <h2 class="text-3xl sm:text-4xl font-poppins font-semibold">
      Formación <span class="text-primary">Continua</span>
    </h2>
    <p class="mt-3 text-rblack/70">
      Programas diseñados para la actualización profesional de nuestros egresados en distintas áreas del conocimiento.
    </p>
  </div>

  {{-- Filtros --}}
  <div class="flex flex-wrap justify-center gap-3 mb-10">
    <button class="px-5 py-2 rounded-full border-2 border-primary text-primary hover:bg-primary hover:text-white transition">Todos</button>
    <button class="px-5 py-2 rounded-full border-2 border-primary text-primary hover:bg-primary hover:text-white transition">Software</button>
    <button class="px-5 py-2 rounded-full border-2 border-primary text-primary hover:bg-primary hover:text-white transition">Alimentos</button>
    <button class="px-5 py-2 rounded-full border-2 border-primary text-primary hover:bg-primary hover:text-white transition">Eléctrica</button>
    <button class="px-5 py-2 rounded-full border-2 border-primary text-primary hover:bg-primary hover:text-white transition">Ambiental</button>
    <button class="px-5 py-2 rounded-full border-2 border-primary text-primary hover:bg-primary hover:text-white transition">Negocios</button>
    <button class="px-5 py-2 rounded-full border-2 border-primary text-primary hover:bg-primary hover:text-white transition">Salud</button>
  </div>

  {{-- Grid de Cursos --}}
  <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-3">
    {{-- Curso 1 --}}
    <div class="card p-6 flex flex-col justify-between">
      <img src="https://img.freepik.com/free-vector/ai-artificial-intelligence-robot-head-digital-technology-background_1017-38068.jpg"
        alt="Curso de IA" class="rounded-xl mb-4 h-44 w-full object-cover">
      <h3 class="font-poppins font-semibold text-lg">Curso en Inteligencia Artificial</h3>
      <p class="text-primary font-medium">Virtual - 120 horas</p>
      <p class="text-sm text-rblack/70 mt-2 mb-4">
        Aprende los fundamentos de la inteligencia artificial y su aplicación en entornos reales.
      </p>
      <div class="flex items-center justify-between mt-4">
        <p class="text-sm text-primary font-semibold"><i class="fa-solid fa-money-bill-wave mr-1"></i> $300.000</p>
        <button class="btn btn-primary py-2">Detalles</button>
      </div>
    </div>

    {{-- Curso 2 --}}
    <div class="card p-6 flex flex-col justify-between">
      <img src="https://img.freepik.com/free-photo/close-up-scientist-holding-laboratory-flask_23-2148721275.jpg"
        alt="Curso de alimentos" class="rounded-xl mb-4 h-44 w-full object-cover">
      <h3 class="font-poppins font-semibold text-lg">Diplomado en Seguridad Alimentaria</h3>
      <p class="text-primary font-medium">Presencial - 100 horas</p>
      <p class="text-sm text-rblack/70 mt-2 mb-4">
        Fortalece tus competencias en inocuidad, control y gestión alimentaria en contextos industriales.
      </p>
      <div class="flex items-center justify-between mt-4">
        <p class="text-sm text-primary font-semibold"><i class="fa-solid fa-money-bill-wave mr-1"></i> $420.000</p>
        <button class="btn btn-primary py-2">Detalles</button>
      </div>
    </div>

    {{-- Curso 3 --}}
    <div class="card p-6 flex flex-col justify-between">
      <img src="https://img.freepik.com/free-photo/renewable-energy-concept-with-solar-panels_23-2149432928.jpg"
        alt="Curso energía" class="rounded-xl mb-4 h-44 w-full object-cover">
      <h3 class="font-poppins font-semibold text-lg">Diplomado en Energías Renovables</h3>
      <p class="text-primary font-medium">Virtual - 140 horas</p>
      <p class="text-sm text-rblack/70 mt-2 mb-4">
        Descubre las principales tecnologías y aplicaciones de las fuentes de energía limpia.
      </p>
      <div class="flex items-center justify-between mt-4">
        <p class="text-sm text-primary font-semibold"><i class="fa-solid fa-money-bill-wave mr-1"></i> $500.000</p>
        <button class="btn btn-primary py-2">Detalles</button>
      </div>
    </div>

    {{-- Curso 4 --}}
    <div class="card p-6 flex flex-col justify-between">
      <img src="https://img.freepik.com/free-photo/electric-engineer-checking-maintenance-cabinet_23-2148749922.jpg"
        alt="Curso electricidad" class="rounded-xl mb-4 h-44 w-full object-cover">
      <h3 class="font-poppins font-semibold text-lg">Curso en Instalaciones Eléctricas</h3>
      <p class="text-primary font-medium">Presencial - 80 horas</p>
      <p class="text-sm text-rblack/70 mt-2 mb-4">
        Domina las normas y prácticas seguras para instalaciones residenciales y comerciales.
      </p>
      <div class="flex items-center justify-between mt-4">
        <p class="text-sm text-primary font-semibold"><i class="fa-solid fa-money-bill-wave mr-1"></i> $280.000</p>
        <button class="btn btn-primary py-2">Detalles</button>
      </div>
    </div>

    {{-- Curso 5 --}}
    <div class="card p-6 flex flex-col justify-between">
      <img src="https://img.freepik.com/free-photo/environmental-engineer-working-industrial-factory_23-2149362811.jpg"
        alt="Curso ambiental" class="rounded-xl mb-4 h-44 w-full object-cover">
      <h3 class="font-poppins font-semibold text-lg">Curso en Gestión Ambiental</h3>
      <p class="text-primary font-medium">Virtual - 90 horas</p>
      <p class="text-sm text-rblack/70 mt-2 mb-4">
        Aprende sobre la gestión sostenible de recursos naturales y estrategias ambientales empresariales.
      </p>
      <div class="flex items-center justify-between mt-4">
        <p class="text-sm text-primary font-semibold"><i class="fa-solid fa-money-bill-wave mr-1"></i> $350.000</p>
        <button class="btn btn-primary py-2">Detalles</button>
      </div>
    </div>
  </div>
</section>


{{-- Sección de Docentes --}}
<section id="docentes" class="bg-cultured py-20">
  <div class="container-app">
    <h2 class="text-2xl sm:text-3xl font-poppins font-semibold text-center mb-10">
      Nuestro <span class="text-primary">Equipo Docente</span>
    </h2>

    <div class="grid gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
      <div class="card text-center p-8">
        <img src="https://randomuser.me/api/portraits/men/32.jpg"
          alt="Docente" class="h-24 w-24 rounded-full mx-auto mb-4 object-cover">
        <h3 class="font-semibold">Sebastián Vargas</h3>
        <p class="text-primary text-sm mb-1">Ing. Software e IA</p>
        <p class="text-sm text-rblack/70">Especialista en inteligencia artificial y ciencia de datos aplicada.</p>
      </div>

      <div class="card text-center p-8">
        <img src="https://randomuser.me/api/portraits/women/45.jpg"
          alt="Docente" class="h-24 w-24 rounded-full mx-auto mb-4 object-cover">
        <h3 class="font-semibold">Carolina Andrade</h3>
        <p class="text-primary text-sm mb-1">MSc. Energías Renovables</p>
        <p class="text-sm text-rblack/70">Experta en sistemas eléctricos sostenibles y energías limpias.</p>
      </div>

      <div class="card text-center p-8">
        <img src="https://randomuser.me/api/portraits/men/76.jpg"
          alt="Docente" class="h-24 w-24 rounded-full mx-auto mb-4 object-cover">
        <h3 class="font-semibold">Andrés Castillo</h3>
        <p class="text-primary text-sm mb-1">Esp. Seguridad Alimentaria</p>
        <p class="text-sm text-rblack/70">Consultor en calidad e inocuidad alimentaria.</p>
      </div>
    </div>
  </div>
</section>

@endsection
