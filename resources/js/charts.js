import Chart from 'chart.js/auto';

/*
|--------------------------------------------------------------------------
| Gráfico de Visitas (línea)
|--------------------------------------------------------------------------
| Muestra las visitas diarias de los últimos 14 días.
*/
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


/*
|--------------------------------------------------------------------------
| Gráfico de Tasa de Participación (donut)
|--------------------------------------------------------------------------
| Muestra el porcentaje de egresados activos frente a inactivos.
*/
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
                borderWidth: 0
            }]
        },
        options: {
            cutout: '60%',
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        color: '#374151',
                        font: { size: 13 }
                    }
                }
            }
        }
    });
}


/*
|--------------------------------------------------------------------------
| Gráfico de Elementos Más Interactuados
|--------------------------------------------------------------------------
| Muestra los ítems más clicados por los egresados.
*/
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


/*
|--------------------------------------------------------------------------
| Distribución por Programa Académico
|--------------------------------------------------------------------------
| Muestra la cantidad de egresados agrupados por programa académico.
*/
function initEgresadosPorPrograma(programas, valores) {
    const ctx = document.getElementById('graficoEgresadosPrograma');
    if (!ctx || !programas.length) return;

    if (ctx.__chartInstance) ctx.__chartInstance.destroy();

    ctx.__chartInstance = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: programas,
            datasets: [{
                label: 'Egresados',
                data: valores,
                backgroundColor: '#09B451',
                borderRadius: 6
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        color: '#4B5563',
                        stepSize: 1,
                        callback: function (value) {
                            return Number.isInteger(value) ? value : null;
                        }
                    },
                    grid: { color: '#E5E7EB' }
                },
                x: {
                    ticks: {
                        color: '#4B5563',
                        maxRotation: 0,
                        minRotation: 0,
                        autoSkip: true,
                        maxTicksLimit: 6
                    },
                    grid: { display: false }
                }
            },
            plugins: { legend: { display: false } }
        }
    });
}


/*
|--------------------------------------------------------------------------
| Participación por Módulo (donut con porcentajes)
|--------------------------------------------------------------------------
| Muestra la proporción de interacciones por cada módulo del portal,
| incluyendo el porcentaje dentro de cada sección.
*/
function initParticipacionPorModulo(modulos, valores) {
    const ctx = document.getElementById('graficoModulos');
    if (!ctx || !modulos.length) return;

    if (ctx.__chartInstance) ctx.__chartInstance.destroy();

    ctx.__chartInstance = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: modulos,
            datasets: [{
                data: valores,
                backgroundColor: [
                    '#09B451', '#2563EB', '#EAB308',
                    '#F97316', '#A855F7', '#EF4444'
                ],
                borderWidth: 0
            }]
        },
        options: {
            cutout: '60%',
            plugins: {
                legend: {
                    position: 'right',
                    labels: {
                        color: '#374151',
                        font: { size: 13 },
                        usePointStyle: true,
                        pointStyle: 'circle',
                        padding: 30
                    }
                },
                tooltip: {
                    callbacks: {
                        label: function (context) {
                            const total = context.chart._metasets[0].total || context.chart.data.datasets[0].data.reduce((a, b) => a + b, 0);
                            const valor = context.parsed;
                            const porcentaje = ((valor / total) * 100).toFixed(1);
                            return `${context.label}: ${valor} (${porcentaje}%)`;
                        }
                    }
                },
                // Plugin personalizado para mostrar los porcentajes dentro del gráfico
                datalabels: false
            },
            layout: {
                padding: { top: 10, bottom: 10, left: 10, right: 10 }
            }
        },
        plugins: [{
            id: 'inChartLabels',
            afterDatasetsDraw(chart) {
                const { ctx } = chart;
                chart.data.datasets[0].data.forEach((value, i) => {
                    const meta = chart.getDatasetMeta(0);
                    const total = chart.data.datasets[0].data.reduce((a, b) => a + b, 0);
                    const porcentaje = ((value / total) * 100).toFixed(0) + '%';
                    const { x, y } = meta.data[i].tooltipPosition();

                    ctx.save();
                    ctx.fillStyle = '#fff';
                    ctx.font = 'bold 11px Poppins, sans-serif';
                    ctx.textAlign = 'center';
                    ctx.textBaseline = 'middle';
                    ctx.fillText(porcentaje, x, y);
                    ctx.restore();
                });
            }
        }]
    });
}



/*
|--------------------------------------------------------------------------
| Inicialización general del Dashboard
|--------------------------------------------------------------------------
| Carga todos los gráficos cuando se llama desde el Blade principal.
*/
export function initDashboardCharts(data) {
    initVisitasChart(data.labels, data.values);
    initDonutParticipacion(data.activos, data.totales);
    initTopItemsChart(data.topItems, data.topValores);
    initEgresadosPorPrograma(data.programas, data.programasValores);
    initParticipacionPorModulo(data.modulosNombres, data.modulosValores);
}
