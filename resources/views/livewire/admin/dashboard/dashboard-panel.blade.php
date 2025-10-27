@extends('layouts.admin')

@section('content')

<div class="space-y-6">

    {{-- Tarjetas resumen de visitas --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="bg-white rounded-2xl shadow p-4 flex flex-col items-center">
            <p class="text-sm text-gray-500">Visitas hoy</p>
            <h3 class="text-3xl font-semibold text-primary">{{ $totalHoy }}</h3>
        </div>

        <div class="bg-white rounded-2xl shadow p-4 flex flex-col items-center">
            <p class="text-sm text-gray-500">Esta semana</p>
            <h3 class="text-3xl font-semibold text-primary">{{ $totalSemana }}</h3>
        </div>

        <div class="bg-white rounded-2xl shadow p-4 flex flex-col items-center">
            <p class="text-sm text-gray-500">Este mes</p>
            <h3 class="text-3xl font-semibold text-primary">{{ $totalMes }}</h3>
        </div>
    </div>

    {{-- Gráfica de visitas --}}
    <div class="bg-white rounded-2xl shadow p-6">
        <h4 class="text-lg font-semibold text-rblack mb-4">Visitas de los últimos 14 días</h4>
        <canvas id="graficaVisitas" class="w-full h-64"></canvas>
    </div>

    {{-- Tarjetas resumen de interacciones / perfiles --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="bg-white rounded-2xl shadow p-4 flex flex-col items-center">
            <p class="text-sm text-gray-500">Interacciones totales</p>
            <h3 class="text-3xl font-semibold text-primary">{{ $totalInteracciones }}</h3>
        </div>

        <div class="bg-white rounded-2xl shadow p-4 flex flex-col items-center">
            <p class="text-sm text-gray-500">Egresados registrados</p>
            <h3 class="text-3xl font-semibold text-primary">{{ $totalPerfiles }}</h3>
        </div>

        <div class="bg-white rounded-2xl shadow p-4 flex flex-col items-center">
            <p class="text-sm text-gray-500">Tasa de participación</p>
            <h3 class="text-3xl font-semibold text-primary">{{ $tasaParticipacion }}%</h3>
            <p class="text-xs text-gray-500 mt-1">
                {{ $egresadosActivos }} activos de {{ $totalEgresados }}
            </p>
        </div>
    </div>

    {{-- Gráfico de egresados activos vs inactivos --}}
    <div class="bg-white rounded-2xl shadow p-6">
        <h4 class="text-lg font-semibold text-rblack mb-4">Egresados activos vs inactivos</h4>
        <canvas id="graficoParticipacion" height="100"></canvas>
    </div>

    {{-- Top 5 ítems más clicados --}}
    <div class="bg-white rounded-2xl shadow p-6">
        <h4 class="text-lg font-semibold text-rblack mb-4">Top 5 ítems más clicados</h4>
        <canvas id="graficaTopItems" height="120"></canvas>
    </div>

    {{-- Tablas detalladas --}}
    <div class="bg-white rounded-2xl shadow p-4">
        <livewire:admin.dashboard.interacciones-table />
        <livewire:admin.dashboard.perfiles-egresado-table />
    </div>

</div>

@endsection

@push('scripts')
    {{-- Cargar Chart.js una sola vez --}}
    @once
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    @endonce

    <script>
        // Evitar re-inicializaciones múltiples al navegar con Livewire v3
        let __chartsInitOnce = false;

        function initVisitasChart() {
            const ctx = document.getElementById('graficaVisitas');
            const labels = @json($labels);
            const values = @json($values);

            if (!ctx || !labels.length || !values.length || typeof Chart === 'undefined') return;

            // Destruir chart previo si existe
            if (ctx.__chartInstance) {
                ctx.__chartInstance.destroy();
            }

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
                    plugins: { legend: { display: false } },
                    scales: { y: { beginAtZero: true } }
                }
            });
        }

        function initDonutParticipacion() {
            const ctx = document.getElementById('graficoParticipacion');
            if (!ctx || typeof Chart === 'undefined') return;

            const activos   = Number(@json($egresadosActivos));
            const totales   = Number(@json($totalEgresados));
            const inactivos = Math.max(totales - activos, 0);

            if (ctx.__chartInstance) {
                ctx.__chartInstance.destroy();
            }

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
                        legend: { position: 'bottom', labels: { color: '#374151', font: { size: 13 } } }
                    }
                }
            });
        }

        function initTopItemsChart() {
            const ctx = document.getElementById('graficaTopItems');
            if (!ctx || typeof Chart === 'undefined') return;

            const items   = @json(array_column($topItems, 'item_title'));
            const valores = @json(array_column($topItems, 'total'));

            if (!items.length) return;

            if (ctx.__chartInstance) {
                ctx.__chartInstance.destroy();
            }

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
                    scales: { x: { beginAtZero: true } },
                    plugins: { legend: { display: false } }
                }
            });
        }

        function initAllCharts() {
            // Si Chart.js aún no cargó, esperar al siguiente tick
            if (typeof Chart === 'undefined') {
                setTimeout(initAllCharts, 100);
                return;
            }
            initVisitasChart();
            initDonutParticipacion();
            initTopItemsChart();
        }

        // Inicializar en diferentes eventos para cubrir Livewire v3 y cargas normales
        document.addEventListener('DOMContentLoaded', initAllCharts);
        document.addEventListener('livewire:load', initAllCharts);
        window.addEventListener('livewire:navigated', initAllCharts);
    </script>
@endpush
