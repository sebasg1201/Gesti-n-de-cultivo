@extends('layouts.barra_lateral')

@section('content')

<div class="space-y-6">

    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold text-gray-800">Panel de Reportes e Indicadores</h1>
        <div class="flex items-center gap-2">
            <span class="text-sm text-gray-500 bg-white px-3 py-1 rounded shadow-sm border border-gray-100">
                {{ now()->format('d M, Y') }}
            </span>
        </div>
    </div>

    <!-- SECCION 1: KPI CARDS (Licencias) -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        <!-- Licencias Por Vencer -->
        <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-red-500 hover:shadow-md transition-shadow">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs font-bold text-red-500 uppercase tracking-wider mb-1">Licencias Por Vencer</p>
                    <h2 class="text-4xl font-extrabold text-gray-800">{{ $licenciasPorVencer ?? 0 }}</h2>
                    <p class="text-xs text-gray-400 mt-2">Requieren atención inmediata</p>
                </div>
                <div class="p-3 bg-red-50 rounded-lg text-red-500">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Renovadas este mes -->
        <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-yellow-500 hover:shadow-md transition-shadow">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs font-bold text-yellow-600 uppercase tracking-wider mb-1">Renovadas este mes</p>
                    <h2 class="text-4xl font-extrabold text-gray-800">{{ $renovadasEsteMes ?? 0 }}</h2>
                    <p class="text-xs text-gray-400 mt-2">Ingresos recientes</p>
                </div>
                <div class="p-3 bg-yellow-50 rounded-lg text-yellow-600">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Total Licencias -->
        <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-blue-500 hover:shadow-md transition-shadow">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs font-bold text-blue-600 uppercase tracking-wider mb-1">Total Licencias</p>
                    <h2 class="text-4xl font-extrabold text-gray-800">{{ $totalLicencias ?? 0 }}</h2>
                    <p class="text-xs text-gray-400 mt-2">Base instalada total</p>
                </div>
                <div class="p-3 bg-blue-50 rounded-lg text-blue-600">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />
                    </svg>
                </div>
            </div>
        </div>

    </div>

    <!-- SECCION 2: KPI CARDS (Empresas) -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">

        <div class="bg-white p-4 rounded-lg shadow-sm flex items-center gap-4">
            <div class="p-3 bg-indigo-100 text-indigo-600 rounded-full">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21" />
                </svg>
            </div>
            <div>
                <p class="text-sm text-gray-500">Total Empresas</p>
                <p class="text-xl font-bold text-gray-800">{{ $totalEmpresas ?? 0 }}</p>
            </div>
        </div>

        <div class="bg-white p-4 rounded-lg shadow-sm flex items-center gap-4">
            <div class="p-3 bg-green-100 text-green-600 rounded-full">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
            </div>
            <div>
                <p class="text-sm text-gray-500">Activas</p>
                <p class="text-xl font-bold text-gray-800">{{ $empresasActivas ?? 0 }}</p>
            </div>
        </div>

        <div class="bg-white p-4 rounded-lg shadow-sm flex items-center gap-4">
            <div class="p-3 bg-yellow-100 text-yellow-600 rounded-full">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
            </div>
            <div>
                <p class="text-sm text-gray-500">Pendientes</p>
                <p class="text-xl font-bold text-gray-800">{{ $empresasNuevas ?? 0 }}</p>
            </div>
        </div>

        <div class="bg-white p-4 rounded-lg shadow-sm flex items-center gap-4">
            <div class="p-3 bg-red-100 text-red-600 rounded-full">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 0 0 5.636 5.636m12.728 12.728A9 9 0 0 1 5.636 5.636m12.728 12.728L5.636 5.636" />
                </svg>
            </div>
            <div>
                <p class="text-sm text-gray-500">Suspendidas</p>
                <p class="text-xl font-bold text-gray-800">{{ $empresasSuspendidas ?? 0 }}</p>
            </div>
        </div>

    </div>

    <!-- SECCION 3: GRAFICOS -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        <!-- Grafico de Ventas -->
        <div class="bg-white p-6 rounded-lg shadow-sm">
            <h3 class="text-lg font-bold text-gray-800 mb-4">Tendencia de Licencias ({{ date('Y') }})</h3>
            <div class="relative h-64 w-full">
                <canvas id="salesChart"></canvas>
            </div>
        </div>

        <!-- Grafico de Estado de Empresas -->
        <div class="bg-white p-6 rounded-lg shadow-sm">
            <h3 class="text-lg font-bold text-gray-800 mb-4">Estado de Empresas</h3>
            <div class="relative h-64 w-full flex justify-center">
                <canvas id="statusChart"></canvas>
            </div>
        </div>

    </div>

</div>

<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {

        /* ===============================
           1. GRÁFICO DE LÍNEA – LICENCIAS
        ================================ */

        const salesCanvas = document.getElementById('salesChart');
        if (salesCanvas) {

            const ctxSales = salesCanvas.getContext('2d');

            new Chart(ctxSales, {
                type: 'line',
                data: {
                    labels: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
                    datasets: [{
                        label: 'Licencias Vendidas',
                        data: @json($chartData),
                        borderColor: '#10B981', // Green-500
                        backgroundColor: 'rgba(16, 185, 129, 0.12)',
                        borderWidth: 2,
                        tension: 0.4,
                        fill: true,
                        pointBackgroundColor: '#ffffff',
                        pointBorderColor: '#059669',
                        pointRadius: 4,
                        pointHoverRadius: 6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            backgroundColor: '#111827',
                            titleColor: '#ffffff',
                            bodyColor: '#e5e7eb',
                            padding: 10
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                borderDash: [4, 4],
                                color: '#e5e7eb'
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        }
                    }
                }
            });
        }

        /* ======================================
           2. GRÁFICO DONUT – ESTADO DE EMPRESAS
        ====================================== */

        const statusCanvas = document.getElementById('statusChart');
        if (statusCanvas) {

            const ctxStatus = statusCanvas.getContext('2d');

            new Chart(ctxStatus, {
                type: 'doughnut',
                data: {
                    labels: ['Pendientes', 'Suspendidas', 'Activas'],
                    datasets: [{
                        data: @json($statusDistribution),
                        backgroundColor: [
                            '#FBBF24', // Yellow-400
                            '#EF4444', // Red-500
                            '#10B981' // Green-500
                        ],
                        borderWidth: 0,
                        hoverOffset: 8
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '70%',
                    plugins: {
                        legend: {
                            position: 'right',
                            labels: {
                                boxWidth: 12,
                                usePointStyle: true,
                                padding: 15
                            }
                        },
                        tooltip: {
                            backgroundColor: '#111827',
                            titleColor: '#ffffff',
                            bodyColor: '#e5e7eb'
                        }
                    }
                }
            });
        }

    });
</script>

@endsection