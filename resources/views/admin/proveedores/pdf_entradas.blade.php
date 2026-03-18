<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Entradas de Proveedores</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #10b981;
            padding-bottom: 10px;
        }
        .header h1 {
            color: #064e3b;
            margin: 0 0 5px 0;
            font-size: 24px;
        }
        .header p {
            margin: 0;
            color: #6b7280;
            font-size: 12px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #e5e7eb;
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f9fafb;
            color: #059669;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 10px;
        }
        td {
            color: #1f2937;
        }
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .font-bold {
            font-weight: bold;
        }
        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 10px;
            color: #9ca3af;
        }
    </style>
</head>
<body>

    <div class="header">
        <h1>Reporte de Entradas de Proveedores</h1>
        <p>Generado el: {{ now()->format('d/m/Y H:i A') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                @if($isGrouped)
                    <th>Proveedor</th>
                    <th>Especialidad</th>
                    <th class="text-center">Entradas Totales</th>
                    <th class="text-right">Valor Acumulado</th>
                    <th class="text-right">Última Actividad</th>
                @else
                    <th>Fecha</th>
                    <th>Proveedor</th>
                    <th>Producto</th>
                    <th class="text-center">Cant.</th>
                    <th class="text-right">Val. Unit.</th>
                    <th class="text-right">Val. Total</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @forelse($entradas as $entrada)
                @if($isGrouped)
                    <tr>
                        <td class="font-bold">{{ $entrada->nombre }}</td>
                        <td>{{ $entrada->especialidad ?? 'General' }}</td>
                        <td class="text-center">{{ $entrada->total_registros }}</td>
                        <td class="text-right font-bold">${{ number_format($entrada->valor_total, 2) }}</td>
                        <td class="text-right">{{ \Carbon\Carbon::parse($entrada->ultima_fecha)->format('d/m/Y') }}</td>
                    </tr>
                @else
                    @php
                        $isSemilla = !!$entrada->id_semilla;
                        $nombreProducto = $isSemilla ? ($entrada->semilla->nombre_semilla ?? 'Semilla Desconocida') : ($entrada->insumo->Nombre ?? 'Insumo Desconocido');
                        $unidad = $isSemilla ? 'KG' : 'UNID';
                    @endphp
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($entrada->fecha_entrada)->format('d/m/Y') }}</td>
                        <td class="font-bold">{{ $entrada->proveedor->nombre ?? 'N/A' }}</td>
                        <td>{{ $nombreProducto }}</td>
                        <td class="text-center">{{ number_format($entrada->cantidad_recibida, 0) }} {{ $unidad }}</td>
                        <td class="text-right">${{ number_format($entrada->precio_unitario, 2) }}</td>
                        <td class="text-right font-bold">${{ number_format($entrada->cantidad_recibida * $entrada->precio_unitario, 2) }}</td>
                    </tr>
                @endif
            @empty
                <tr>
                    <td colspan="6" class="text-center">No se encontraron registros de entradas.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        Software de Gestión de Cultivos &copy; {{ date('Y') }}
    </div>

</body>
</html>
