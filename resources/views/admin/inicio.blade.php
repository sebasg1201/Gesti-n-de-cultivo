@extends('layouts.admin')

@section('title', 'Reporte de Estadísticas')

@section('content')

<div class="flex justify-between items-center mb-6">
    <h3 class="text-xl font-bold text-gray-800">Resumen del Sistema</h3>
    <!-- Mover html2pdf para no depender de layouts u otras vistas -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <button onclick="downloadReport()" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-2 px-4 rounded-xl shadow-md transition-colors flex items-center gap-2">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
        </svg>
        Descargar reportes
    </button>
</div>

<div id="report-content" class="space-y-6 p-6" style="background-color: #ffffff; color: #1f2937;">

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        <!-- Bar Chart -->
        <div class="p-6 rounded-3xl shadow-lg border flex flex-col justify-center items-center" style="background-color: #ffffff; border-color: #f3f4f6;">
            <h4 class="text-lg font-bold mb-4 self-start" style="color: #374151;">Registros por Categoría</h4>
            <div class="w-full relative h-64">
                <canvas id="barChart"></canvas>
            </div>
        </div>

        <!-- Doughnut Chart -->
        <div class="p-6 rounded-3xl shadow-lg border flex flex-col justify-center items-center" style="background-color: #ffffff; border-color: #f3f4f6;">
            <h4 class="text-lg font-bold mb-4 self-start" style="color: #374151;">Distribución del Sistema</h4>
            <div class="w-full relative h-64 flex justify-center">
                <canvas id="doughnutChart"></canvas>
            </div>
        </div>

    </div>

    <!-- Category Summary Cards -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-6">
        <div class="rounded-2xl p-4 border text-center" style="background-color: #ecfdf5; border-color: #d1fae5;">
            <p class="text-xs font-bold uppercase tracking-wider mb-1" style="color: #059669;">Cosechas</p>
            <p class="text-3xl font-black" style="color: #065f46;">{{ $stats['cosechas'] }}</p>
        </div>
        <div class="rounded-2xl p-4 border text-center" style="background-color: #eff6ff; border-color: #dbeafe;">
            <p class="text-xs font-bold uppercase tracking-wider mb-1" style="color: #2563eb;">Riegos</p>
            <p class="text-3xl font-black" style="color: #1e40af;">{{ $stats['riegos'] }}</p>
        </div>
        <div class="rounded-2xl p-4 border text-center" style="background-color: #fefce8; border-color: #fef08a;">
            <p class="text-xs font-bold uppercase tracking-wider mb-1" style="color: #ca8a04;">Semillas</p>
            <p class="text-3xl font-black" style="color: #854d0e;">{{ $stats['semillas'] }}</p>
        </div>
        <div class="rounded-2xl p-4 border text-center" style="background-color: #faf5ff; border-color: #f3e8ff;">
            <p class="text-xs font-bold uppercase tracking-wider mb-1" style="color: #9333ea;">Usuarios</p>
            <p class="text-3xl font-black" style="color: #6b21a8;">{{ $stats['usuarios'] }}</p>
        </div>
    </div>

    <!-- Job Status Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
        <div class="rounded-2xl p-4 border text-center shadow-sm" style="background-color: #f9fafb; border-color: #e5e7eb;">
            <p class="text-xs font-bold uppercase tracking-wider mb-1" style="color: #6b7280;">Pendientes</p>
            <p class="text-3xl font-black" style="color: #374151;">{{ $stats['trabajos_pendientes'] }}</p>
        </div>
        <div class="rounded-2xl p-4 border text-center shadow-sm" style="background-color: #fff7ed; border-color: #fed7aa;">
            <p class="text-xs font-bold uppercase tracking-wider mb-1" style="color: #f97316;">En Proceso</p>
            <p class="text-3xl font-black" style="color: #c2410c;">{{ $stats['trabajos_en_proceso'] }}</p>
        </div>
        <div class="rounded-2xl p-4 border text-center shadow-sm" style="background-color: #f0fdf4; border-color: #bbf7d0;">
            <p class="text-xs font-bold uppercase tracking-wider mb-1" style="color: #16a34a;">Realizados</p>
            <p class="text-3xl font-black" style="color: #166534;">{{ $stats['trabajos_realizados'] }}</p>
        </div>
    </div>

    <!-- Job Status Chart -->
    <div class="p-6 rounded-3xl shadow-lg border flex flex-col justify-center items-center mt-6" style="background-color: #ffffff; border-color: #f3f4f6;">
        <h4 class="text-lg font-bold mb-4 self-start" style="color: #374151;">Estado de Trabajos (Fases Programadas)</h4>
        <div class="w-full relative h-64 flex justify-center">
            <canvas id="doughnutTrabajosChart"></canvas>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const dataStats = {
        cosechas: @json($stats['cosechas']),
        riegos: @json($stats['riegos']),
        semillas: @json($stats['semillas']),
        usuarios: @json($stats['usuarios']),
        pendientes: @json($stats['trabajos_pendientes']),
        enProceso: @json($stats['trabajos_en_proceso']),
        realizados: @json($stats['trabajos_realizados'])
    };

    // Disabling animations globally makes html2canvas capture the chart reliably
    Chart.defaults.animation = false;

    // Draw Bar Chart
    const ctxBar = document.getElementById('barChart').getContext('2d');
    new Chart(ctxBar, {
        type: 'bar',
        data: {
            labels: ['Cosechas', 'Riegos', 'Semillas', 'Usuarios'],
            datasets: [{
                label: 'Cantidad Registrada',
                data: [dataStats.cosechas, dataStats.riegos, dataStats.semillas, dataStats.usuarios],
                backgroundColor: [
                    'rgba(16, 185, 129, 0.8)', // Emerald
                    'rgba(59, 130, 246, 0.8)', // Blue
                    'rgba(234, 179, 8, 0.8)', // Yellow
                    'rgba(168, 85, 247, 0.8)' // Purple
                ],
                borderRadius: 8,
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        borderDash: [5, 5]
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

    // Draw Main System Doughnut Chart
    const ctxDoughnut = document.getElementById('doughnutChart').getContext('2d');
    new Chart(ctxDoughnut, {
        type: 'doughnut',
        data: {
            labels: ['Cosechas', 'Riegos', 'Semillas', 'Usuarios'],
            datasets: [{
                data: [dataStats.cosechas, dataStats.riegos, dataStats.semillas, dataStats.usuarios],
                backgroundColor: [
                    'rgba(16, 185, 129, 0.8)', // Emerald
                    'rgba(59, 130, 246, 0.8)', // Blue
                    'rgba(234, 179, 8, 0.8)', // Yellow
                    'rgba(168, 85, 247, 0.8)' // Purple
                ],
                borderWidth: 2,
                borderColor: '#ffffff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '65%',
            plugins: {
                legend: {
                    position: 'right'
                }
            }
        }
    });

    // Draw Jobs Doughnut Chart
    const ctxJobs = document.getElementById('doughnutTrabajosChart').getContext('2d');
    new Chart(ctxJobs, {
        type: 'doughnut',
        data: {
            labels: ['Pendientes', 'En Proceso', 'Realizados'],
            datasets: [{
                data: [dataStats.pendientes, dataStats.enProceso, dataStats.realizados],
                backgroundColor: [
                    'rgba(156, 163, 175, 0.8)', // Gray for pending
                    'rgba(249, 115, 22, 0.8)', // Orange for in-progress
                    'rgba(34, 197, 94, 0.8)' // Green for completed
                ],
                borderWidth: 2,
                borderColor: '#ffffff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '65%',
            plugins: {
                legend: {
                    position: 'right'
                }
            }
        }
    });

    function downloadReport() {
        // Guardar estilos originales para restaurar después
        const element = document.getElementById('report-content');
        const originalStyle = element.getAttribute('style') || '';

        // Forzar un ancho fijo y layout de columna única para el PDF
        // Esto evita que las gráficas se encimen al capturar desde pantallas anchas
        element.style.width = '800px';
        element.style.flexDirection = 'column';
        element.style.display = 'flex';

        // Forzar a los grids internos a ser de una sola columna también
        const grids = element.querySelectorAll('.grid');
        const originalGrids = [];
        grids.forEach(grid => {
            originalGrids.push({
                el: grid,
                className: grid.className
            });
            grid.classList.remove('md:grid-cols-2', 'md:grid-cols-3', 'md:grid-cols-4', 'grid-cols-2');
            grid.classList.add('grid-cols-1');
        });

        window.scrollTo(0, 0);

        const button = document.querySelector('button[onclick="downloadReport()"]');
        const originalText = button.innerHTML;

        button.innerHTML = 'Generando PDF...';
        button.disabled = true;

        html2canvas(element, {
            scale: 2,
            useCORS: true,
            logging: false,
            width: 800,
            windowWidth: 800,
            x: 0,
            y: 0,
            scrollX: 0,
            scrollY: 0
        }).then(canvas => {
            // Restaurar estilos originales inmediatamente
            element.setAttribute('style', originalStyle);
            originalGrids.forEach(item => {
                item.el.className = item.className;
            });
            try {
                const imgData = canvas.toDataURL('image/jpeg', 1.0);

                // Access jsPDF from the window.jspdf namespace
                const {
                    jsPDF
                } = window.jspdf;

                // Calculate dimensions to fit content
                // A4 width is 595.28 pt
                const imgWidth = 595.28;
                const imgHeight = (canvas.height * imgWidth) / canvas.width;

                // Create PDF with dynamic height to avoid clipping
                const pdf = new jsPDF('p', 'pt', [imgWidth, imgHeight]);

                pdf.addImage(imgData, 'JPEG', 0, 0, imgWidth, imgHeight);
                pdf.save('reporte_estadisticas_agrimanager.pdf');

                button.innerHTML = originalText;
                button.disabled = false;
            } catch (e) {
                console.error('Error procesando PDF', e);
                alert('Error al procesar el documento PDF: ' + e.message);
                button.innerHTML = originalText;
                button.disabled = false;
            }
        }).catch(err => {
            console.error('Error generando PDF:', err);
            alert('Error generando PDF: ' + (err.message || err));
            button.innerHTML = originalText;
            button.disabled = false;
        });
    }
</script>
@endpush