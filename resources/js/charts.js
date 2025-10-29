import Chart from 'chart.js/auto';

function initVisitasChart(labels, values) {
    const ctx = document.getElementById('graficaVisitas');
    if (!ctx || !labels.length || !values.length) return;

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
            plugins: { legend: { display: false } },
            scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } }
        }
    });
}

function initDonutParticipacion(activos, totales) {
    const ctx = document.getElementById('graficoParticipacion');
    if (!ctx) return;

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
                    labels: { color: '#374151', font: { size: 13 } }
                }
            }
        }
    });
}

function initTopItemsChart(items, valores) {
    const ctx = document.getElementById('graficaTopItems');
    if (!ctx || !items.length) return;

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
                x: { beginAtZero: true, ticks: { stepSize: 1 } }
            },
            plugins: { legend: { display: false } }
        }
    });
}

function initGraficoPorModulo(data) {
    const ctx = document.getElementById('graficoPorModulo');
    if (!ctx) return;

    const labels = Object.keys(data);
    const valores = Object.values(data);

    if (ctx.__chartInstance) ctx.__chartInstance.destroy();

    ctx.__chartInstance = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels.map(l => l.charAt(0).toUpperCase() + l.slice(1)),
            datasets: [{
                label: 'Interacciones',
                data: valores,
                backgroundColor: ['#09B45188', '#F59E0B88', '#3B82F688'],
                borderColor: ['#09B451', '#F59E0B', '#3B82F6'],
                borderWidth: 1,
                borderRadius: 6
            }]
        },
        options: {
            indexAxis: 'y',
            scales: { x: { beginAtZero: true, ticks: { stepSize: 1 } } },
            plugins: { legend: { display: false } }
        }
    });
}

// Función principal
export function initDashboardCharts(data) {
    initVisitasChart(data.labels, data.values);
    initDonutParticipacion(data.activos, data.totales);
    initTopItemsChart(data.topItems, data.topValores);
    initGraficoPorModulo(data.modulos);
}
