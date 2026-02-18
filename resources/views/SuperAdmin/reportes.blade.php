@extends('layouts.barra_lateral')

@section('content')
    <!-- Containers reverted to standard layout -->
    <div id="reports-container" class="space-y-6">

        <div class="flex justify-between items-center">
            <h1 class="text-2xl font-bold text-gray-800">Panel de Reportes e Indicadores</h1>
            <div class="flex items-center gap-2">
                <span class="text-sm text-gray-500 bg-white px-3 py-1 rounded shadow-sm border border-gray-100">
                    {{ now()->format('d M, Y') }}
                </span>
                <button id="downloadPdfBtn"
                    class="bg-green-600 hover:bg-green-700 text-white text-sm font-medium px-4 py-2 rounded-lg shadow transition-colors flex items-center gap-2 cursor-pointer">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" />
                    </svg>
                    Descargar Reporte
                </button>
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
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
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
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" />
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
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />
                        </svg>
                    </div>
                </div>
            </div>

        </div>

        <!-- SECCION 2: KPI CARDS (Empresas) -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">

            <div class="bg-white p-4 rounded-lg shadow-sm flex items-center gap-4">
                <div class="p-3 bg-indigo-100 text-indigo-600 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21" />
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Total Empresas</p>
                    <p class="text-xl font-bold text-gray-800">{{ $totalEmpresas ?? 0 }}</p>
                </div>
            </div>

            <div class="bg-white p-4 rounded-lg shadow-sm flex items-center gap-4">
                <div class="p-3 bg-green-100 text-green-600 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Activas</p>
                    <p class="text-xl font-bold text-gray-800">{{ $empresasActivas ?? 0 }}</p>
                </div>
            </div>

            <div class="bg-white p-4 rounded-lg shadow-sm flex items-center gap-4">
                <div class="p-3 bg-yellow-100 text-yellow-600 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Pendientes</p>
                    <p class="text-xl font-bold text-gray-800">{{ $empresasNuevas ?? 0 }}</p>
                </div>
            </div>

            <div class="bg-white p-4 rounded-lg shadow-sm flex items-center gap-4">
                <div class="p-3 bg-red-100 text-red-600 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M18.364 18.364A9 9 0 0 0 5.636 5.636m12.728 12.728A9 9 0 0 1 5.636 5.636m12.728 12.728L5.636 5.636" />
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



    <!-- Hidden elements for data passing -->
    <div id="chart-data" data-json="{{ json_encode($chartData) }}" class="hidden"></div>
    <div id="status-data" data-json="{{ json_encode($statusDistribution) }}" class="hidden"></div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {

            // Retrieve data safely
            const chartData = JSON.parse(document.getElementById('chart-data').getAttribute('data-json') || '[]');
            const statusDistribution = JSON.parse(document.getElementById('status-data').getAttribute('data-json') || '[]');

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
                            data: chartData,
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
                            data: statusDistribution,
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


    <!-- ==========================================
                     HIDDEN PRINT LAYOUT (A4)
                ========================================== -->
    <!-- Updated CSS: Positioned at 0,0 for rendering, but invisible via opacity -->
    <div id="print-layout"
        style="display: none; position: absolute; top: 0; left: 0; width: 210mm; min-height: 297mm; z-index: -1; background: white; padding: 20mm; font-family: 'Arial', sans-serif; color: #333; opacity: 0; pointer-events: none;">

        <!-- HEADER -->
        <div
            style="display: flex; justify-content: space-between; align-items: center; border-bottom: 2px solid #16a34a; padding-bottom: 10px; margin-bottom: 20px;">
            <div style="display: flex; align-items: center; gap: 10px;">
                <!-- Logo SVG (Simulated) -->
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" style="width: 40px; height: 40px; color: #16a34a;">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 3v2.25m6.364.386-1.591 1.591M21 12h-2.25m-.386 6.364-1.591-1.591M12 18.75V21m-4.773-4.227-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0Z" />
                </svg>
                <h1 style="font-size: 24px; font-weight: bold; color: #16a34a; margin: 0;">AgriManager</h1>
            </div>
            <div style="text-align: right;">
                <p style="margin: 0; font-size: 12px; color: #666;">Reporte Generado</p>
                <p style="margin: 0; font-size: 14px; font-weight: bold;">{{ now()->format('d/m/Y H:i') }}</p>
            </div>
        </div>

        <h2 style="text-align: center; font-size: 18px; margin-bottom: 20px; text-transform: uppercase; color: #1f2937;">
            Reporte de Estado General</h2>

        <!-- RESUMEN DE LICENCIAS (TABLA) -->
        <div style="margin-bottom: 30px;">
            <h3
                style="font-size: 14px; font-weight: bold; border-left: 4px solid #3b82f6; padding-left: 10px; margin-bottom: 10px; color: #374151;">
                Resumen de Licencias</h3>
            <table style="width: 100%; border-collapse: collapse; font-size: 12px;">
                <thead style="background-color: #f3f4f6;">
                    <tr>
                        <th style="border: 1px solid #e5e7eb; padding: 8px; text-align: left;">Métrica</th>
                        <th style="border: 1px solid #e5e7eb; padding: 8px; text-align: center;">Cantidad</th>
                        <th style="border: 1px solid #e5e7eb; padding: 8px; text-align: left;">Estado / Observación</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="border: 1px solid #e5e7eb; padding: 8px;">Licencias Por Vencer</td>
                        <td
                            style="border: 1px solid #e5e7eb; padding: 8px; text-align: center; font-weight: bold; color: #ef4444;">
                            {{ $licenciasPorVencer ?? 0 }}
                        </td>
                        <td style="border: 1px solid #e5e7eb; padding: 8px; color: #ef4444;">Requieren atención inmediata
                        </td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid #e5e7eb; padding: 8px;">Renovadas Este Mes</td>
                        <td
                            style="border: 1px solid #e5e7eb; padding: 8px; text-align: center; font-weight: bold; color: #eab308;">
                            {{ $renovadasEsteMes ?? 0 }}
                        </td>
                        <td style="border: 1px solid #e5e7eb; padding: 8px;">Ingresos recientes</td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid #e5e7eb; padding: 8px;">Total Licencias Activas</td>
                        <td
                            style="border: 1px solid #e5e7eb; padding: 8px; text-align: center; font-weight: bold; color: #2563eb;">
                            {{ $totalLicencias ?? 0 }}
                        </td>
                        <td style="border: 1px solid #e5e7eb; padding: 8px;">Base instalada total</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- RESUMEN DE EMPRESAS (TABLA) -->
        <div style="margin-bottom: 30px;">
            <h3
                style="font-size: 14px; font-weight: bold; border-left: 4px solid #8b5cf6; padding-left: 10px; margin-bottom: 10px; color: #374151;">
                Estado de Empresas</h3>
            <table style="width: 100%; border-collapse: collapse; font-size: 12px;">
                <thead style="background-color: #f3f4f6;">
                    <tr>
                        <th style="border: 1px solid #e5e7eb; padding: 8px; text-align: left;">Estado</th>
                        <th style="border: 1px solid #e5e7eb; padding: 8px; text-align: center;">Cantidad</th>
                        <th style="border: 1px solid #e5e7eb; padding: 8px; text-align: left;">% del Total (Aprox)</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="border: 1px solid #e5e7eb; padding: 8px;">Activas</td>
                        <td
                            style="border: 1px solid #e5e7eb; padding: 8px; text-align: center; font-weight: bold; color: #16a34a;">
                            {{ $empresasActivas ?? 0 }}
                        </td>
                        <td style="border: 1px solid #e5e7eb; padding: 8px;">
                            {{ $totalEmpresas > 0 ? round(($empresasActivas / $totalEmpresas) * 100, 1) : 0 }}%
                        </td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid #e5e7eb; padding: 8px;">Pendientes</td>
                        <td
                            style="border: 1px solid #e5e7eb; padding: 8px; text-align: center; font-weight: bold; color: #eab308;">
                            {{ $empresasNuevas ?? 0 }}
                        </td>
                        <td style="border: 1px solid #e5e7eb; padding: 8px;">
                            {{ $totalEmpresas > 0 ? round(($empresasNuevas / $totalEmpresas) * 100, 1) : 0 }}%
                        </td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid #e5e7eb; padding: 8px;">Suspendidas</td>
                        <td
                            style="border: 1px solid #e5e7eb; padding: 8px; text-align: center; font-weight: bold; color: #ef4444;">
                            {{ $empresasSuspendidas ?? 0 }}
                        </td>
                        <td style="border: 1px solid #e5e7eb; padding: 8px;">
                            {{ $totalEmpresas > 0 ? round(($empresasSuspendidas / $totalEmpresas) * 100, 1) : 0 }}%
                        </td>
                    </tr>
                    <tr style="background-color: #f9fafb; font-weight: bold;">
                        <td style="border: 1px solid #e5e7eb; padding: 8px;">TOTAL EMPRESAS</td>
                        <td style="border: 1px solid #e5e7eb; padding: 8px; text-align: center;">{{ $totalEmpresas ?? 0 }}
                        </td>
                        <td style="border: 1px solid #e5e7eb; padding: 8px;">100%</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- GRÁFICOS (IMÁGENES) -->
        <div style="margin-bottom: 20px;">
            <h3
                style="font-size: 14px; font-weight: bold; border-left: 4px solid #16a34a; padding-left: 10px; margin-bottom: 15px; color: #374151;">
                Análisis Gráfico</h3>

            <div style="display: flex; gap: 20px; justify-content: space-between;">
                <!-- IMG CHART 1 -->
                <div style="width: 48%; border: 1px solid #e5e7eb; padding: 10px; border-radius: 4px;">
                    <h4 style="font-size: 12px; font-weight: bold; text-align: center; margin-bottom: 10px;">Tendencia de
                        Ventas</h4>
                    <img id="print-chart-sales" src="" style="width: 100%; height: auto; display: block;">
                </div>

                <!-- IMG CHART 2 -->
                <div style="width: 48%; border: 1px solid #e5e7eb; padding: 10px; border-radius: 4px;">
                    <h4 style="font-size: 12px; font-weight: bold; text-align: center; margin-bottom: 10px;">Distribución de
                        Empresas</h4>
                    <img id="print-chart-status" src="" style="width: 100%; height: auto; display: block;">
                </div>
            </div>
        </div>

        <!-- FOOTER -->
        <div
            style="margin-top: 50px; border-top: 1px solid #e5e7eb; padding-top: 10px; text-align: center; font-size: 10px; color: #9ca3af;">
            <p>Este documento fue generado automáticamente por la plataforma AgriManager.</p>
            <p>Gesti-n-de-cultivo &copy; {{ date('Y') }}</p>
        </div>

    </div>

    <!-- Scripts para generar PDF -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html-to-image/1.11.11/html-to-image.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

    <script>
        document.getElementById('downloadPdfBtn').addEventListener('click', async function () {
            const btn = this;
            const originalText = btn.innerHTML;

            try {
                if (!window.htmlToImage || !window.jspdf) {
                    throw new Error("Librerías no cargadas");
                }

                // 1. Feedback visual
                btn.disabled = true;
                btn.innerHTML = `
                                <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                Preparando Documento...
                            `;

                // 2. Capturar gráficos actuales como imágenes
                const salesCanvas = document.getElementById('salesChart');
                const statusCanvas = document.getElementById('statusChart');

                if (salesCanvas) {
                    document.getElementById('print-chart-sales').src = salesCanvas.toDataURL('image/png');
                }
                if (statusCanvas) {
                    document.getElementById('print-chart-status').src = statusCanvas.toDataURL('image/png');
                }

                // 3. Renderizar el layout oculto
                const element = document.getElementById('print-layout');
                element.style.display = 'block'; // Mostrar temporalmente para capturar

                // Esperar un momento para que las imágenes se carguen en el src
                await new Promise(resolve => setTimeout(resolve, 300));

                const dataUrl = await htmlToImage.toPng(element, {
                    quality: 1.0,
                    pixelRatio: 2, // Mejor calidad de texto
                    backgroundColor: '#ffffff',
                    style: {
                        opacity: '1', // Force visible in capture
                        zIndex: '9999', // Ensure top stacking in capture
                        visibility: 'visible' // Double safety
                    }
                });

                // 4. Generar PDF
                const {
                    jsPDF
                } = window.jspdf;
                const pdf = new jsPDF('p', 'mm', 'a4');
                const pdfWidth = pdf.internal.pageSize.getWidth();
                const pdfHeight = pdf.internal.pageSize.getHeight();

                pdf.addImage(dataUrl, 'PNG', 0, 0, pdfWidth, pdfHeight);
                pdf.save('Reporte_Profesional_{{ date("Y-m-d") }}.pdf');

            } catch (error) {
                console.error("Error al generar PDF:", error);
                alert("No se pudo generar el documento. Por favor intente nuevamente.");
            } finally {
                document.getElementById('print-layout').style.display = 'none'; // Ocultar nuevamente
                btn.innerHTML = originalText;
                btn.disabled = false;
            }
        });
    </script>

@endsection