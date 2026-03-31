<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Cosecha #{{ $cosecha->id_cosecha }}</title>
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            color: #334155;
            line-height: 1.5;
            margin: 0;
            padding: 0;
        }
        .header {
            background-color: #065f46;
            color: white;
            padding: 40px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 28px;
            text-transform: uppercase;
            letter-spacing: 2px;
        }
        .header p {
            margin: 10px 0 0;
            opacity: 0.8;
            font-weight: bold;
        }
        .container {
            padding: 30px;
        }
        .section-title {
            color: #065f46;
            font-size: 14px;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 2px;
            border-bottom: 2px solid #e2e8f0;
            padding-bottom: 10px;
            margin-bottom: 20px;
            margin-top: 30px;
        }
        .kpi-grid {
            width: 100%;
            margin-bottom: 30px;
        }
        .kpi-card {
            background-color: #f8fafc;
            border: 1px solid #f1f5f9;
            padding: 20px;
            border-radius: 15px;
            text-align: center;
        }
        .kpi-value {
            font-size: 24px;
            font-weight: 900;
            display: block;
            margin-bottom: 5px;
        }
        .kpi-label {
            font-size: 9px;
            font-weight: 900;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        th {
            background-color: #f1f5f9;
            text-align: left;
            padding: 12px;
            font-size: 10px;
            text-transform: uppercase;
            font-weight: bold;
            color: #475569;
        }
        td {
            padding: 12px;
            border-bottom: 1px solid #f1f5f9;
            font-size: 12px;
        }
        .footer {
            text-align: center;
            font-size: 10px;
            color: #94a3b8;
            margin-top: 50px;
            padding: 20px;
            border-top: 1px solid #e2e8f0;
        }
        .badge {
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 10px;
            font-weight: bold;
            text-transform: uppercase;
        }
        .badge-success { background-color: #dcfce7; color: #166534; }
        .success-text { color: #059669; font-weight: bold; }
    </style>
</head>
<body>
    <div class="header">
        <h1>REPORTE DE FINALIZACIÓN</h1>
        <p>Cosecha #{{ $cosecha->id_cosecha }} - {{ $cosecha->semilla->nombre_semilla }}</p>
    </div>

    <div class="container">
        <div class="section-title">Resumen de Indicadores Clave (KPIs)</div>
        
        <table class="kpi-grid">
            <tr>
                <td class="kpi-card" style="width: 31%;">
                    <span class="kpi-value success-text">{{ number_format($stats['total_recolectado'], 1) }}</span>
                    <span class="kpi-label">Producción Total (UND)</span>
                </td>
                <td style="width: 3%;"></td>
                <td class="kpi-card" style="width: 32%;">
                    <span class="kpi-value" style="color: #2563eb;">{{ number_format($stats['tasa_exito'], 1) }}%</span>
                    <span class="kpi-label">Éxito Operativo</span>
                </td>
                <td style="width: 3%;"></td>
                <td class="kpi-card" style="width: 31%;">
                    <span class="kpi-value">{{ $stats['dias_ciclo'] }}</span>
                    <span class="kpi-label">Días Totales de Ciclo</span>
                </td>
            </tr>
        </table>

        <div class="section-title">Información del Cultivo</div>
        <table>
            <tr>
                <th>Semilla / Variedad</th>
                <td>{{ $cosecha->semilla->nombre_semilla }}</td>
                <th>Lote de Terreno</th>
                <td>{{ $cosecha->terreno->nombre }}</td>
            </tr>
            <tr>
                <th>Fecha de Siembra</th>
                <td>{{ \Carbon\Carbon::parse($cosecha->fecha_siembra)->format('d/m/Y') }}</td>
                <th>Rendimiento Estimado</th>
                <td>{{ number_format($stats['estimado'], 1) }}</td>
            </tr>
            <tr>
                <th>Total Tareas Programadas</th>
                <td>{{ $stats['total_tareas'] }}</td>
                <th>Cumplimiento Meta</th>
                <td class="success-text">{{ number_format($stats['cumplimiento'], 1) }}%</td>
            </tr>
        </table>

        <div class="section-title">Desglose de Recolecciones</div>
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Fecha de Recolección</th>
                    <th>Trabajador Encargado</th>
                    <th style="text-align: right;">Cantidad (UND)</th>
                </tr>
            </thead>
            <tbody>
                @foreach($cosecha->cultivos as $index => $cultivo)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ \Carbon\Carbon::parse($cultivo->fecha_recoleccion)->format('d/m/Y') }}</td>
                        <td>{{ $cultivo->trabajador->nombre }}</td>
                        <td style="text-align: right; font-weight: bold;">{{ number_format($cultivo->detalles->sum('cantidad'), 1) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="section-title">Validación Operativa</div>
        <div style="background-color: #f8fafc; padding: 20px; border-radius: 10px; font-size: 11px;">
            <p style="margin: 0;"><strong>Nota de Cierre:</strong> Este documento certifica la correcta finalización del ciclo productivo. Se han completado todas las labores de mantenimiento y recolección programadas con un nivel de cumplimiento del {{ number_format($stats['tasa_exito'], 1) }}%. El terreno {{ $cosecha->terreno->nombre }} ha sido liberado para uso inmediato.</p>
        </div>

        <div class="footer">
            Reporte generado automáticamente por AgroTech - {{ now()->format('d/m/Y H:i:s') }}
        </div>
    </div>
</body>
</html>
