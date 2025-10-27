@extends('layouts.admin')

@section('content')
<div class="space-y-8">

    {{-- Encabezado --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-4">
        <div>
            <h1 class="text-2xl font-poppins font-semibold text-rblack">Panel de Analítica</h1>
            <p class="text-sm text-gray-500 mt-1">Monitorea la actividad general y el comportamiento de los egresados en el portal.</p>
        </div>
    </div>

    {{-- Tarjetas principales --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        {{-- visitas hoy --}}
        <div class="bg-white rounded-2xl shadow-md p-5 flex flex-col justify-between border border-gray-100">
            <div class="flex items-center justify-between">
                <p class="text-sm text-gray-500">Visitas hoy</p>
                <i class="fa-solid fa-chart-line text-primary"></i>
            </div>
            <h3 class="text-3xl font-semibold text-primary mt-1">{{ $totalHoy }}</h3>
            <p class="text-xs mt-1 {{ $variacionVisitas >= 0 ? 'text-green-600' : 'text-red-500' }}">
                {{ $variacionVisitas >= 0 ? '+' : '' }}{{ $variacionVisitas }}% vs semana pasada
            </p>
        </div>

        {{-- visitas semana --}}
        <div class="bg-white rounded-2xl shadow-md p-5 flex flex-col justify-between border border-gray-100">
            <div class="flex items-center justify-between">
                <p class="text-sm text-gray-500">Esta semana</p>
                <i class="fa-solid fa-calendar-week text-primary"></i>
            </div>
            <h3 class="text-3xl font-semibold text-primary mt-1">{{ $totalSemana }}</h3>
        </div>

        {{-- interacciones --}}
        <div class="bg-white rounded-2xl shadow-md p-5 flex flex-col justify-between border border-gray-100">
            <div class="flex items-center justify-between">
                <p class="text-sm text-gray-500">Interacciones totales</p>
                <i class="fa-solid fa-bolt text-primary"></i>
            </div>
            <h3 class="text-3xl font-semibold text-primary mt-1">{{ $totalInteracciones }}</h3>
            <p class="text-xs mt-1 {{ $variacionInteracciones >= 0 ? 'text-green-600' : 'text-red-500' }}">
                {{ $variacionInteracciones >= 0 ? '+' : '' }}{{ $variacionInteracciones }}% vs semana pasada
            </p>
        </div>

        {{-- egresados --}}
        <div class="bg-white rounded-2xl shadow-md p-5 flex flex-col justify-between border border-gray-100">
            <div class="flex items-center justify-between">
                <p class="text-sm text-gray-500">Egresados registrados</p>
                <i class="fa-solid fa-user-graduate text-primary"></i>
            </div>
            <h3 class="text-3xl font-semibold text-primary mt-1">{{ $totalPerfiles }}</h3>
        </div>
    </div>

    {{-- Gráficos principales --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Gráfico de visitas --}}
        <div class="bg-white rounded-2xl shadow-md border border-gray-100 p-6 lg:col-span-2">
            <h4 class="text-lg font-semibold text-rblack mb-4">Visitas de los últimos 14 días</h4>
            <canvas id="graficaVisitas" class="w-full h-80"></canvas>
        </div>

        {{-- Donut participación --}}
        <div class="bg-white rounded-2xl shadow-md border border-gray-100 p-6 flex flex-col items-center justify-center">
            <h4 class="text-lg font-semibold text-rblack mb-2">Tasa de participación</h4>
            <p class="text-sm text-gray-500 mb-4">{{ $egresadosActivos }} activos de {{ $totalEgresados }}</p>
            <div class="w-48 h-48">
                <canvas id="graficoParticipacion"></canvas>
            </div>
        </div>
    </div>

    {{-- Actividad reciente --}}
    <div class="bg-white rounded-2xl shadow-md border border-gray-100 p-6">
        <div class="flex items-center justify-between mb-4">
            <h4 class="text-lg font-semibold text-rblack">Actividad reciente</h4>
            <i class="fa-solid fa-clock-rotate-left text-gray-400 text-lg"></i>
        </div>

        @if ($ultimasAcciones->isEmpty())
        <p class="text-gray-500 text-sm text-center py-6">No hay actividad reciente aún.</p>
        @else
        <div class="flex flex-wrap justify-center gap-6">
            @foreach ($ultimasAcciones as $i)
            <div class="flex flex-col items-center w-48 bg-gray-50 rounded-xl p-4 shadow-sm border border-gray-100 hover:shadow-md transition">
                <div class="flex items-center justify-center w-10 h-10 bg-primary/10 text-primary rounded-full mb-2">
                    <i class="fa-solid fa-bolt"></i>
                </div>

                <p class="text-sm text-center text-gray-800 font-medium leading-tight">
                    {{ $i->perfil->nombre ?? 'Egresado Anónimo' }}
                </p>

                <p class="text-xs text-gray-600 text-center mt-1">
                    {{ ucfirst($i->action) }}
                    <br>
                    <span class="text-gray-500">en {{ ucfirst($i->module) }}</span>
                </p>

                @if($i->item_title)
                <p class="text-[11px] text-gray-500 text-center mt-1 italic">
                    “{{ Str::limit($i->item_title, 40) }}”
                </p>
                @endif

                <p class="text-[11px] text-gray-400 mt-2">
                    {{ $i->created_at->setTimezone('America/Bogota')->format('d/m H:i') }}
                </p>
            </div>
            @endforeach
        </div>
        @endif
    </div>

    {{-- Gráfico por módulo --}}
    <div class="bg-white rounded-2xl shadow-md border border-gray-100 p-6">
        <h4 class="text-lg font-semibold text-rblack mb-4">Distribución de interacciones por módulo</h4>
        <canvas id="graficoPorModulo" height="100"></canvas>
    </div>

    {{-- Top interacciones --}}
    <div class="bg-white rounded-2xl shadow-md border border-gray-100 p-6">
        <h4 class="text-lg font-semibold text-rblack mb-4">Módulos o elementos más utilizados</h4>
        <canvas id="graficaTopItems" height="120"></canvas>
    </div>


    {{-- Tablas --}}
    <div class="space-y-6">
        <div class="bg-white rounded-2xl shadow-md border border-gray-100 p-6">
            <livewire:admin.dashboard.interacciones-table />
        </div>

        <div class="bg-white rounded-2xl shadow-md border border-gray-100 p-6">
            <livewire:admin.dashboard.perfiles-egresado-table />
        </div>
    </div>

</div>
@endsection


@push('scripts')
{{-- Cargar Chart.js una sola vez --}}
@once
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
@endonce

<script>
    let __chartsInitOnce = false;

    function initVisitasChart() {
        const ctx = document.getElementById('graficaVisitas');
        const labels = @json($labels);
        const values = @json($values);

        if (!ctx || !labels.length || !values.length || typeof Chart === 'undefined') return;
        if (ctx.__chartInstance) ctx.__chartInstance.destroy();

        ctx.__chartInstance = new Chart(ctx, {
            type: 'line',
            data: {
                labels,
                datasets: [{
                    label: 'Visitas diarias',
                    data: values,
                    borderColor: '#09B451',
                    backgroundColor: '#09B45122',
                    borderWidth: 2,
                    tension: 0.3,
                    fill: true,
                    pointRadius: 3,
                    pointBackgroundColor: '#09B451'
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        } // 👈 enteros
                    }
                }
            }
        });
    }

    function initDonutParticipacion() {
        const ctx = document.getElementById('graficoParticipacion');
        if (!ctx || typeof Chart === 'undefined') return;

        const activos = Number(@json($egresadosActivos));
        const totales = Number(@json($totalEgresados));
        const inactivos = Math.max(totales - activos, 0);

        if (ctx.__chartInstance) ctx.__chartInstance.destroy();

        ctx.__chartInstance = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Activos', 'Inactivos'],
                datasets: [{
                    data: [activos, inactivos],
                    backgroundColor: ['#09B451', '#E5E7EB'],
                    borderWidth: 0,
                }]
            },
            options: {
                cutout: '60%',
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            color: '#374151',
                            font: {
                                size: 13
                            }
                        }
                    }
                }
            }
        });
    }

    function initTopItemsChart() {
        const ctx = document.getElementById('graficaTopItems');
        if (!ctx || typeof Chart === 'undefined') return;

        const items = @json(array_column($topItems, 'item_title'));
        const valores = @json(array_column($topItems, 'total'));

        if (!items.length) return;
        if (ctx.__chartInstance) ctx.__chartInstance.destroy();

        ctx.__chartInstance = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: items,
                datasets: [{
                    label: 'Clics',
                    data: valores,
                    backgroundColor: '#09B45188',
                    borderColor: '#09B451',
                    borderWidth: 1,
                    borderRadius: 6
                }]
            },
            options: {
                indexAxis: 'y',
                scales: {
                    x: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        } // 👈 enteros
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });
    }

    function initGraficoPorModulo() {
        const ctx = document.getElementById('graficoPorModulo');
        const labels = Object.keys(@json($interaccionesPorModulo));
        const data = Object.values(@json($interaccionesPorModulo));

        if (!ctx || !labels.length || typeof Chart === 'undefined') return;
        if (ctx.__chartInstance) ctx.__chartInstance.destroy();

        ctx.__chartInstance = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels.map(l => l.charAt(0).toUpperCase() + l.slice(1)),
                datasets: [{
                    label: 'Interacciones',
                    data,
                    backgroundColor: ['#09B45188', '#F59E0B88', '#3B82F688'],
                    borderColor: ['#09B451', '#F59E0B', '#3B82F6'],
                    borderWidth: 1,
                    borderRadius: 6
                }]
            },
            options: {
                indexAxis: 'y',
                scales: {
                    x: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        } // 👈 enteros
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });
    }

    // Único inicializador que usamos
    function initAllChartsExtended() {
        if (typeof Chart === 'undefined') {
            setTimeout(initAllChartsExtended, 100);
            return;
        }
        initVisitasChart();
        initDonutParticipacion();
        initTopItemsChart();
        initGraficoPorModulo();
    }

    document.addEventListener('DOMContentLoaded', initAllChartsExtended);
    document.addEventListener('livewire:load', initAllChartsExtended);
    window.addEventListener('livewire:navigated', initAllChartsExtended);
</script>
@endpush