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

    {{-- TARJETAS COMPARATIVAS --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- VISITAS --}}
        <div class="bg-white rounded-2xl shadow-md p-6 border border-gray-100">
            <h4 class="text-md font-semibold text-gray-700 mb-2 flex items-center gap-2">
                <i class="fa-solid fa-eye text-primary"></i> Visitas
            </h4>
            <div class="grid grid-cols-3 text-center">
                <div>
                    <p class="text-xs text-gray-500">Totales</p>
                    <h3 class="text-2xl font-bold text-primary">{{ $visitasTotales }}</h3>
                </div>
                <div>
                    <p class="text-xs text-gray-500">Esta semana</p>
                    <h3 class="text-2xl font-bold text-primary">{{ $visitasSemana }}</h3>
                    <p class="text-xs {{ $variacionVisitasSemana >= 0 ? 'text-green-600' : 'text-red-500' }}">
                        {{ $variacionVisitasSemana >= 0 ? '+' : '' }}{{ $variacionVisitasSemana }}%
                    </p>
                </div>
                <div>
                    <p class="text-xs text-gray-500">Hoy</p>
                    <h3 class="text-2xl font-bold text-primary">{{ $visitasHoy }}</h3>
                    <p class="text-xs {{ $variacionVisitasDia >= 0 ? 'text-green-600' : 'text-red-500' }}">
                        {{ $variacionVisitasDia >= 0 ? '+' : '' }}{{ $variacionVisitasDia }}%
                    </p>
                </div>
            </div>
        </div>

        {{-- INTERACCIONES --}}
        <div class="bg-white rounded-2xl shadow-md p-6 border border-gray-100">
            <h4 class="text-md font-semibold text-gray-700 mb-2 flex items-center gap-2">
                <i class="fa-solid fa-bolt text-primary"></i> Interacciones
            </h4>
            <div class="grid grid-cols-3 text-center">
                <div>
                    <p class="text-xs text-gray-500">Totales</p>
                    <h3 class="text-2xl font-bold text-primary">{{ $interaccionesTotales }}</h3>
                </div>
                <div>
                    <p class="text-xs text-gray-500">Esta semana</p>
                    <h3 class="text-2xl font-bold text-primary">{{ $interaccionesSemana }}</h3>
                    <p class="text-xs {{ $variacionInteraccionesSemana >= 0 ? 'text-green-600' : 'text-red-500' }}">
                        {{ $variacionInteraccionesSemana >= 0 ? '+' : '' }}{{ $variacionInteraccionesSemana }}%
                    </p>
                </div>
                <div>
                    <p class="text-xs text-gray-500">Hoy</p>
                    <h3 class="text-2xl font-bold text-primary">{{ $interaccionesHoy }}</h3>
                    <p class="text-xs {{ $variacionInteraccionesDia >= 0 ? 'text-green-600' : 'text-red-500' }}">
                        {{ $variacionInteraccionesDia >= 0 ? '+' : '' }}{{ $variacionInteraccionesDia }}%
                    </p>
                </div>
            </div>
        </div>

        {{-- EGRESADOS REGISTRADOS --}}
        <div class="bg-white rounded-2xl shadow-md p-6 border border-gray-100">
            <h4 class="text-md font-semibold text-gray-700 mb-2 flex items-center gap-2">
                <i class="fa-solid fa-user-graduate text-primary"></i> Egresados registrados
            </h4>
            <div class="grid grid-cols-3 text-center">
                <div>
                    <p class="text-xs text-gray-500">Totales</p>
                    <h3 class="text-2xl font-bold text-primary">{{ $egresadosTotales }}</h3>
                </div>
                <div>
                    <p class="text-xs text-gray-500">Esta semana</p>
                    <h3 class="text-2xl font-bold text-primary">{{ $egresadosSemana }}</h3>
                    <p class="text-xs {{ $variacionEgresadosSemana >= 0 ? 'text-green-600' : 'text-red-500' }}">
                        {{ $variacionEgresadosSemana >= 0 ? '+' : '' }}{{ $variacionEgresadosSemana }}%
                    </p>
                </div>
                <div>
                    <p class="text-xs text-gray-500">Hoy</p>
                    <h3 class="text-2xl font-bold text-primary">{{ $egresadosHoy }}</h3>
                    <p class="text-xs {{ $variacionEgresadosDia >= 0 ? 'text-green-600' : 'text-red-500' }}">
                        {{ $variacionEgresadosDia >= 0 ? '+' : '' }}{{ $variacionEgresadosDia }}%
                    </p>
                </div>
            </div>
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


    {{-- Botones de exportación CSV --}}
    <div class="bg-white rounded-2xl shadow-md border border-gray-100 p-6">
        <h4 class="text-lg font-semibold text-rblack mb-3 flex items-center gap-2">
            <i class="fa-solid fa-file-excel text-primary"></i>
            Exportar datos
        </h4>
        <p class="text-sm text-gray-500 mb-4">Descarga las métricas del portal en formato XLSX (compatible con Excel y Google Sheets).</p>

        <div class="flex flex-wrap gap-3">
            <a href="{{ route('exportar.visitas') }}"
                class="btn btn-primary flex items-center gap-2 px-4 py-2">
                <i class="fa-solid fa-chart-line"></i> Exportar Visitas
            </a>

            <a href="{{ route('exportar.interacciones') }}"
                class="btn btn-primary flex items-center gap-2 px-4 py-2">
                <i class="fa-solid fa-bolt"></i> Exportar Interacciones
            </a>

            <a href="{{ route('exportar.egresados') }}"
                class="btn btn-primary flex items-center gap-2 px-4 py-2">
                <i class="fa-solid fa-user-graduate"></i> Exportar Egresados
            </a>
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