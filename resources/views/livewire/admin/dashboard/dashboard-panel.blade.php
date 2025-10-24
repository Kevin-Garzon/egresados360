@extends('layouts.admin')

@section('title', 'Dashboard - Admin')
@section('header', 'Dashboard')

@section('content')
{{-- ====================== --}}
{{-- DASHBOARD ADMIN EGRESADOS 360 --}}
{{-- ====================== --}}
<section class="container-app py-10 space-y-10">

    {{-- TITULO Y RANGO --}}
    <div class="flex flex-wrap justify-between items-center gap-4">
        <div>
            <h2 class="text-2xl font-poppins font-semibold text-gunmetal">
                Panel de Analítica e Interacciones
            </h2>
            <p class="text-sm text-rblack/70 mt-1">
                Monitorea las visitas, clics y el comportamiento de los usuarios dentro del portal.
            </p>
        </div>

        {{-- Selector de rango de fechas --}}
        <div class="flex items-center gap-3">
            <input type="date" class="border rounded-lg px-3 py-2 text-sm text-rblack/80">
            <span class="text-gray-400">—</span>
            <input type="date" class="border rounded-lg px-3 py-2 text-sm text-rblack/80">
            <button class="btn btn-primary text-sm px-4 py-2">Aplicar</button>
        </div>
    </div>


    {{-- TARJETAS RESUMEN --}}
    <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-4">
        <div class="card p-5 flex items-center gap-4">
            <div class="bg-primary/10 text-primary p-3 rounded-xl text-2xl"><i class="fa-solid fa-user-group"></i></div>
            <div>
                <p class="text-sm text-gray-500">Visitantes únicos</p>
                <h3 class="text-2xl font-semibold">438</h3>
            </div>
        </div>

        <div class="card p-5 flex items-center gap-4">
            <div class="bg-primary/10 text-primary p-3 rounded-xl text-2xl"><i class="fa-solid fa-mouse-pointer"></i></div>
            <div>
                <p class="text-sm text-gray-500">Clics totales</p>
                <h3 class="text-2xl font-semibold">1,287</h3>
            </div>
        </div>

        <div class="card p-5 flex items-center gap-4">
            <div class="bg-primary/10 text-primary p-3 rounded-xl text-2xl"><i class="fa-solid fa-chart-pie"></i></div>
            <div>
                <p class="text-sm text-gray-500">% con perfil registrado</p>
                <h3 class="text-2xl font-semibold">63%</h3>
            </div>
        </div>

        <div class="card p-5 flex items-center gap-4">
            <div class="bg-primary/10 text-primary p-3 rounded-xl text-2xl"><i class="fa-solid fa-clock-rotate-left"></i></div>
            <div>
                <p class="text-sm text-gray-500">Último clic registrado</p>
                <h3 class="text-2xl font-semibold">Hoy, 10:42 AM</h3>
            </div>
        </div>
    </div>


    {{-- GRÁFICAS PRINCIPALES --}}
    <div class="grid gap-6 lg:grid-cols-3">
        {{-- Gráfica de líneas - visitas --}}
        <div class="card p-6 col-span-2">
            <h4 class="font-semibold text-gunmetal mb-4">Visitas al portal</h4>
            <img src="https://placehold.co/600x200/EEEEEE/09B451?text=Gráfica+de+Visitas+(líneas)" class="rounded-lg w-full">
        </div>

        {{-- Gráfica de barras - clics por módulo --}}
        <div class="card p-6">
            <h4 class="font-semibold text-gunmetal mb-4">Clics por módulo</h4>
            <img src="https://placehold.co/300x200/EEEEEE/09B451?text=Gráfica+Barras+por+Módulo" class="rounded-lg w-full">
        </div>
    </div>


    {{-- DISTRIBUCION DE PROGRAMAS --}}
    <div class="card p-6">
        <h4 class="font-semibold text-gunmetal mb-4">Distribución por programa (usuarios con perfil)</h4>
        <img src="https://placehold.co/600x250/EEEEEE/09B451?text=Gráfica+de+Dona+por+Programa" class="rounded-lg w-full">
    </div>


    {{-- TABLA DE INTERACCIONES RECIENTES --}}
    <div class="card p-6">
    <div class="flex justify-between items-center mb-4">
        <h4 class="font-semibold text-gunmetal">Interacciones registradas</h4>
        <div class="flex items-center gap-3">
            <select class="border rounded-lg px-3 py-2 text-sm text-rblack/80">
                <option>Todos los módulos</option>
                <option>Laboral</option>
                <option>Formación</option>
                <option>Bienestar</option>
            </select>
            <button class="btn btn-primary text-sm px-4 py-2">
                <i class="fa-solid fa-download mr-2"></i> Exportar
            </button>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full text-sm text-gray-700 border border-gray-200 rounded-2xl overflow-hidden">
            <thead class="bg-gray-100 text-gray-600 uppercase text-xs">
                <tr>
                    <th class="px-4 py-3 text-left">Fecha</th>
                    <th class="px-4 py-3 text-left">Módulo</th>
                    <th class="px-4 py-3 text-left">Acción</th>
                    <th class="px-4 py-3 text-left">Elemento</th>
                    <th class="px-4 py-3 text-left">Nombre</th>
                    <th class="px-4 py-3 text-left">Correo</th>
                    <th class="px-4 py-3 text-left">Celular</th>
                    <th class="px-4 py-3 text-left">Programa</th>
                    <th class="px-4 py-3 text-left">Año egreso</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 bg-white">
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3">23 Oct 2025 - 11:05 AM</td>
                    <td class="px-4 py-3">Laboral</td>
                    <td class="px-4 py-3">Ir a aplicar</td>
                    <td class="px-4 py-3">Vacante — Desarrollador Laravel</td>
                    <td class="px-4 py-3">Kevin Garzón</td>
                    <td class="px-4 py-3">kevin.garzon@fet.edu.co</td>
                    <td class="px-4 py-3">321-987-4456</td>
                    <td class="px-4 py-3">Ingeniería de Software</td>
                    <td class="px-4 py-3">2024</td>
                </tr>
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3">23 Oct 2025 - 10:30 AM</td>
                    <td class="px-4 py-3">Formación</td>
                    <td class="px-4 py-3">Inscribirse</td>
                    <td class="px-4 py-3">Curso — Excel Avanzado</td>
                    <td class="px-4 py-3">Anónimo</td>
                    <td class="px-4 py-3">—</td>
                    <td class="px-4 py-3">—</td>
                    <td class="px-4 py-3">—</td>
                    <td class="px-4 py-3">—</td>
                </tr>
            </tbody>
        </table>
    </div>

    {{-- Pie con total y filtros de resumen --}}
    <div class="flex justify-between items-center mt-4 text-sm text-gray-500">
        <span>Total: <strong>123 interacciones</strong></span>
        <span>Mostrando últimos 50 registros</span>
    </div>
</div>


</section>

@endsection