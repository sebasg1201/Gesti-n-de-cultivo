@extends('layouts.barra_lateral')

@section('content')
<!-- Containers reverted to standard layout -->
<div id="reports-container" class="space-y-10 p-2">

    <div class="relative flex flex-col sm:flex-row sm:justify-between sm:items-end gap-6 pb-6 border-b border-gray-100 dark:border-emerald-950/20">
        <div>
            <span class="text-xs font-bold text-green-600 dark:text-emerald-400 uppercase tracking-widest bg-green-50 dark:bg-emerald-950/30 px-3 py-1 rounded-full">Analytics Real-time</span>
            <h1 class="text-4xl font-extrabold text-green-800 dark:text-emerald-500 tracking-tight mt-2 transition-colors">
                Panel De <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-600 to-green-500">Reportes .</span>
            </h1>
            <p class="text-slate-500 dark:text-slate-400 font-medium mt-1">
                Monitoreo inteligente de licencias y estados empresariales.
            </p>
        </div>

        <div class="flex items-center gap-4">
            <div class="hidden md:flex flex-col items-end">
                <span class="text-[10px] font-bold text-gray-400 dark:text-slate-500 uppercase">Fecha de corte</span>
                <span class="text-sm font-semibold text-slate-700 dark:text-emerald-50 italic transition-colors">{{ now()->format('d M, Y') }}</span>
            </div>

            <button id="downloadPdfBtn"
                class="group relative inline-flex items-center justify-center px-6 py-3 font-bold text-white transition-all duration-300 rounded-2xl focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#006b58] 
                bg-gradient-to-r from-[#34d399] via-[#22c55e] to-[#16a34a] 
hover:from-[#22c55e] hover:via-[#16a34a] hover:to-[#15803d] hover:-translate-y-0.5 active:scale-95">

                <div class="absolute inset-0 w-full h-full rounded-2xl bg-white/10 opacity-0 group-hover:opacity-100 transition-opacity"></div>

                <svg class="w-5 h-5 mr-2 relative z-10 transition-transform group-hover:translate-y-0.5"
                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                </svg>

                <span class="relative z-10">Exportar Informe</span>
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

        <div class="group relative overflow-hidden bg-white dark:bg-slate-900 border border-slate-100 dark:border-emerald-950/10 rounded-3xl p-7 shadow-sm dark:shadow-none transition-all duration-300 hover:shadow-2xl dark:hover:bg-slate-800/50 hover:border-red-100 dark:hover:border-red-900/20">
            <div class="absolute -right-4 -top-4 w-24 h-24 bg-red-50 dark:bg-red-950/20 rounded-full transition-transform group-hover:scale-150 duration-500"></div>

            <div class="relative flex flex-col h-full">
                <div class="flex justify-between items-start">
                    <div class="p-3 bg-red-500 rounded-2xl shadow-lg shadow-red-200 text-white">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M12 9v3m0 4h.01M10.29 3.86l-7.2 12.48A2 2 0 005 20h14a2 2 0 001.71-3.66l-7.2-12.48a2 2 0 00-3.42 0z" />
                        </svg>
                    </div>
                </div>

                <div class="mt-8">
                    <h3 class="text-5xl font-black text-slate-800 dark:text-emerald-50 tracking-tighter transition-colors">{{ $licenciasPorVencer ?? 0 }}</h3>
                    <p class="text-slate-400 dark:text-slate-500 font-bold text-sm uppercase mt-1 tracking-wide transition-colors">Licencias por vencer</p>
                </div>
            </div>
        </div>

        <div class="group relative overflow-hidden bg-white dark:bg-slate-900 border border-slate-100 dark:border-emerald-950/10 rounded-3xl p-7 shadow-sm dark:shadow-none transition-all duration-300 hover:shadow-2xl dark:hover:bg-slate-800/50 hover:border-emerald-100 dark:hover:border-emerald-900/20">
            <div class="absolute -right-4 -top-4 w-24 h-24 bg-emerald-50 dark:bg-emerald-950/20 rounded-full transition-transform group-hover:scale-150 duration-500"></div>

            <div class="relative flex flex-col h-full">
                <div class="flex justify-between items-start">
                    <div class="p-3 bg-emerald-500 rounded-2xl shadow-lg shadow-emerald-200 text-white">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M4 4v6h6M20 20v-6h-6M5 19a9 9 0 0114-7M19 5a9 9 0 00-14 7" />
                        </svg>
                    </div>
                </div>

                <div class="mt-8">
                    <h3 class="text-5xl font-black text-slate-800 dark:text-emerald-50 tracking-tighter transition-colors">{{ $renovadasEsteMes ?? 0 }}</h3>
                    <p class="text-slate-400 dark:text-slate-500 font-bold text-sm uppercase mt-1 tracking-wide transition-colors">Renovadas este mes</p>
                </div>
            </div>
        </div>

        <div class="group relative overflow-hidden bg-gradient-to-br from-[#004d3d] to-[#006b58] rounded-3xl p-7 shadow-xl transition-all duration-300 hover:-translate-y-2">
            <div class="absolute right-0 bottom-0 opacity-10 transform translate-x-4 translate-y-4">
                <svg class="w-32 h-32 text-white" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M3 7h18M6 7v13m12-13v13M9 7v13m6-13v13" />
                </svg>
            </div>

            <div class="relative flex flex-col h-full">
                <div class="p-3 bg-white/20 backdrop-blur-md rounded-2xl w-fit text-white border border-white/10">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                </div>

                <div class="mt-8 text-white">
                    <h3 class="text-5xl font-black tracking-tighter">{{ $totalLicencias ?? 0 }}</h3>
                    <p class="text-emerald-100/80 font-bold text-sm uppercase mt-1 tracking-wide">Total Licencias Global</p>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div class="bg-white dark:bg-slate-900 border border-slate-100 dark:border-emerald-950/10 p-4 rounded-2xl flex items-center justify-between hover:border-indigo-200 dark:hover:border-indigo-900/30 transition-colors">
            <div>
                <p class="text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest">Total Empresas</p>
                <p class="text-xl font-bold text-slate-800 dark:text-emerald-50">{{ $totalEmpresas ?? 0 }}</p>
            </div>
            <div class="h-8 w-1 bg-slate-100 dark:bg-slate-800 rounded-full"></div>
        </div>

        <div class="bg-white dark:bg-slate-900 border border-slate-100 dark:border-emerald-950/10 p-4 rounded-2xl flex items-center justify-between hover:border-emerald-200 dark:hover:border-emerald-900/30 transition-colors">
            <div>
                <p class="text-[10px] font-black text-emerald-500 uppercase tracking-widest">Activas</p>
                <p class="text-xl font-bold text-slate-800 dark:text-emerald-50">{{ $empresasActivas ?? 0 }}</p>
            </div>
            <div class="h-8 w-1 bg-emerald-500/20 rounded-full"></div>
        </div>

        <div class="bg-white dark:bg-slate-900 border border-slate-100 dark:border-emerald-950/10 p-4 rounded-2xl flex items-center justify-between hover:border-amber-200 dark:hover:border-amber-900/30 transition-colors">
            <div>
                <p class="text-[10px] font-black text-amber-500 uppercase tracking-widest">Pendientes</p>
                <p class="text-xl font-bold text-slate-800 dark:text-emerald-50">{{ $empresasNuevas ?? 0 }}</p>
            </div>
            <div class="h-8 w-1 bg-amber-500/20 rounded-full"></div>
        </div>

        <div class="bg-white dark:bg-slate-900 border border-slate-100 dark:border-emerald-950/10 p-4 rounded-2xl flex items-center justify-between hover:border-red-200 dark:hover:border-red-900/30 transition-colors">
            <div>
                <p class="text-[10px] font-black text-red-500 uppercase tracking-widest">Suspendidas</p>
                <p class="text-xl font-bold text-slate-800 dark:text-emerald-50">{{ $empresasSuspendidas ?? 0 }}</p>
            </div>
            <div class="h-8 w-1 bg-red-500/20 rounded-full"></div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <div class="bg-white dark:bg-slate-900 border border-slate-100 dark:border-emerald-950/10 p-8 rounded-[2rem] shadow-sm relative overflow-hidden transition-colors">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-xl font-bold tracking-tight">

                    <span class="text-slate-800 dark:text-emerald-50 transition-colors">
                        Tendencia
                    </span>

                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-600 to-green-500">
                        de Renovación
                    </span>

                </h3>
                <select class="text-xs font-bold border-none bg-slate-50 dark:bg-slate-950 text-slate-700 dark:text-emerald-400 rounded-lg focus:ring-0 transition-colors">
                    <option>Últimos 6 meses</option>
                </select>
            </div>
            <div class="h-72 w-full">
                <canvas id="salesChart"></canvas>
            </div>
        </div>

        <div class="bg-white dark:bg-slate-900 border border-slate-100 dark:border-emerald-950/10 p-8 rounded-[2rem] shadow-sm transition-colors">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-xl font-bold tracking-tight">

                    <span class="text-slate-800 dark:text-emerald-50 transition-colors">
                        Distribución
                    </span>

                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-600 to-green-500">
                        de Estados
                    </span>

                </h3>
            </div>
            <div class="h-72 flex justify-center items-center">
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
    document.addEventListener('DOMContentLoaded', function() {
        // Obtenemos los datos con fallbacks seguros
        const chartData = JSON.parse(document.getElementById('chart-data')?.getAttribute('data-json') || '[]');
        const statusDistribution = JSON.parse(document.getElementById('status-data')?.getAttribute('data-json') || '[]');

        // Configuración de colores Premium
        const isDark = document.documentElement.classList.contains('dark');
        const Colors = {
            primary: '#2ea059ff', // Indigo
            success: '#10b981', // Emerald
            warning: '#f59e0b', // Amber
            danger: '#ef4444', // Red
            textMain: isDark ? '#ecfdf5' : '#1e293b',
            textMuted: isDark ? '#64748b' : '#94a3b8',
            grid: isDark ? 'rgba(16, 185, 129, 0.05)' : 'rgba(241, 245, 249, 1)',
            cardBg: isDark ? '#0f172a' : '#ffffff'
        };

        /* =========================================
           PLUGIN: CENTRO DEL DONUT CUSTOMIZADO
        ========================================== */
        const centerTextPlugin = {
            id: 'centerText',
            beforeDraw(chart) {
                const {
                    width,
                    height,
                    ctx
                } = chart;
                ctx.restore();

                const total = chart.data.datasets[0].data.reduce((a, b) => a + b, 0);

                // Texto Numérico
                ctx.font = "700 32px 'Plus Jakarta Sans', sans-serif";
                ctx.textBaseline = "middle";
                ctx.textAlign = "center";
                ctx.fillStyle = Colors.textMain;
                ctx.fillText(total, width / 2, height / 2 - 5);

                // Texto Etiqueta
                ctx.font = "600 12px sans-serif";
                ctx.fillStyle = Colors.textMuted;
                ctx.fillText("TOTAL", width / 2, height / 2 + 25);

                ctx.save();
            }
        };

        /* =========================================
           1. LINE CHART: NEBULA STYLE
        ========================================== */
        const salesCanvas = document.getElementById('salesChart');
        if (salesCanvas) {
            const ctx = salesCanvas.getContext('2d');

            // Gradiente de área suave
            const areaGradient = ctx.createLinearGradient(0, 0, 0, 400);
            areaGradient.addColorStop(0, 'rgba(99, 102, 241, 0.2)');
            areaGradient.addColorStop(0.6, 'rgba(99, 102, 241, 0.02)');
            areaGradient.addColorStop(1, 'rgba(99, 102, 241, 0)');

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
                    datasets: [{
                        label: 'Licencias',
                        data: chartData,
                        fill: true,
                        backgroundColor: areaGradient,
                        borderColor: Colors.primary,
                        borderWidth: 4,
                        pointRadius: 0, // Escondidos por defecto para minimalismo
                        pointHoverRadius: 6,
                        pointHoverBackgroundColor: Colors.primary,
                        pointHoverBorderColor: '#fff',
                        pointHoverBorderWidth: 3,
                        tension: 0.4, // Curvatura suave
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
                            mode: 'index',
                            intersect: false,
                            backgroundColor: '#1e293b',
                            titleFont: {
                                size: 14,
                                weight: 'bold'
                            },
                            padding: 12,
                            cornerRadius: 12,
                            displayColors: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: Colors.grid,
                                drawBorder: false
                            },
                            ticks: {
                                color: Colors.textMuted,
                                font: {
                                    size: 11
                                }
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                color: Colors.textMuted,
                                font: {
                                    size: 11
                                }
                            }
                        }
                    }
                }
            });
        }

        /* =========================================
           2. DOUGHNUT CHART: GLASS STYLE
        ========================================== */
        const statusCanvas = document.getElementById('statusChart');
        if (statusCanvas) {
            const ctx = statusCanvas.getContext('2d');

            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ['Pendientes', 'Suspendidas', 'Activas'],
                    datasets: [{
                        data: statusDistribution,
                        backgroundColor: [
                            Colors.warning,
                            Colors.danger,
                            Colors.success
                        ],
                        hoverOffset: 20,
                        borderWidth: 8,
                        borderColor: Colors.cardBg, // Espaciado entre segmentos
                        borderRadius: 10, // Bordes redondeados en los segmentos
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '80%', // Más delgado para verse más pro
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                usePointStyle: true,
                                padding: 25,
                                font: {
                                    size: 12,
                                    weight: '600'
                                },
                                color: Colors.textMain
                            }
                        },
                        tooltip: {
                            backgroundColor: '#1e293b',
                            padding: 15,
                            cornerRadius: 12
                        }
                    },
                    animation: {
                        animateScale: true,
                        animateRotate: true,
                        duration: 2000,
                        easing: 'easeOutQuart'
                    }
                },
                plugins: [centerTextPlugin]
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
    document.getElementById('downloadPdfBtn').addEventListener('click', async function() {
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