<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use App\Models\Estado;
use App\Models\TipoLicencia;
use Illuminate\Http\Request;

class EmpresaController extends Controller
{
    public function index(Request $request)
    {
        $query = Empresa::with(['estado', 'licencia']);

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('nombre_empresa', 'like', "%{$search}%")
                    ->orWhere('nombre_repre_legal', 'like', "%{$search}%")
                    ->orWhere('id_empresa', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->has('status')) {
            $status = $request->input('status');
            if ($status === 'activa') {
                $query->where('id_estado', 3);
            } elseif ($status === 'pendiente') {
                $query->where('id_estado', 1);
            } elseif ($status === 'bloqueada') {
                $query->where('id_estado', 2);
            }
        }

        $empresas = $query->paginate(3);

        // Calculate stats
        $stats = [
            'nuevas' => Empresa::where('id_estado', 1)->count(),
            'suspendidas' => Empresa::where('id_estado', 2)->count(),
            'activaciones' => Empresa::where('id_estado', 3)->count(),
        ];

        $allEmpresas = Empresa::select('id_empresa', 'nombre_empresa')->get();
        $tiposLicencia = TipoLicencia::all();

        return view('SuperAdmin.index', compact('empresas', 'stats', 'allEmpresas', 'tiposLicencia'));
    }

    public function update(Request $request, $id)
    {
        $empresa = Empresa::findOrFail($id);

        $request->validate([
            'nombre_empresa' => 'required|string|max:200',
            'nombre_repre_legal' => 'required|string|max:100',
            'cedula_repre' => 'required|numeric|digits_between:7,11',
            'telefono' => 'required|string|max:12',
            'direccion' => 'required|string|max:150',
            'correo' => 'required|email|max:100|unique:empresa,correo,' . $id . ',id_empresa',
        ]);

        $empresa->update([
            'nombre_empresa' => $request->nombre_empresa,
            'nombre_repre_legal' => $request->nombre_repre_legal,
            'cedula_repre' => $request->cedula_repre,
            'telefono' => $request->telefono,
            'direccion' => $request->direccion,
            'correo' => $request->correo,
        ]);

        return back()->with('success', 'Empresa actualizada exitosamente.');
    }

    public function activar($id)
    {
        $empresa = Empresa::findOrFail($id);

        // Prevenir re-activación si ya está activa
        if ($empresa->id_estado == 3) {
            return redirect()->back()->with('error', 'Esta empresa ya está activa.');
        }

        $licencia = \App\Models\VentaLicencias::where('id_empresa', $id)
            ->orderBy('fecha_inicio', 'desc')
            ->first();

        if (!$licencia) {
            return redirect()->back()->with('error', 'No puedes activar una empresa sin antes asignarle una licencia en el Dashboard.');
        }

        $empresa->id_estado = 3; // Activa
        $empresa->save();

        $licencia->id_estado = 3; // 3 = Activa
        $licencia->fecha_inicio = now();
        $licencia->save();

        return redirect()->back()->with('success', 'Empresa y Licencia activadas con éxito.');
    }

    public function generarExcel(Request $request)
    {
        $mes = (int) $request->input('mes', now()->month);
        $year = (int) $request->input('anio', now()->year);

        $nombreMes = \Carbon\Carbon::createFromDate(2024, (int) $mes, 1)->locale('es')->monthName;
        $nombreMes = ucfirst($nombreMes);

        $empresas = Empresa::with(['estado'])
            ->whereMonth('fecha_creacion', $mes)
            ->whereYear('fecha_creacion', $year)
            ->get();

        $headers = [
            "Content-type" => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=Reporte_Empresas_{$nombreMes}_{$year}.csv",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];

        $callback = function () use ($empresas, $nombreMes, $year) {
            $file = fopen('php://output', 'w');

            // BOM para compatibilidad UTF-8 en Excel
            fputs($file, "\xEF\xBB\xBF");

            // === SECCIÓN DE ENCABEZADO DEL REPORTE ===
            fputcsv($file, ['REPORTE DE EMPRESAS REGISTRADAS'], ';');
            fputcsv($file, ['Período:', "$nombreMes $year"], ';');
            fputcsv($file, ['Fecha de generación:', now()->format('d/m/Y H:i')], ';');
            fputcsv($file, ['Total de registros:', $empresas->count()], ';');
            fputcsv($file, [], ';'); // Fila vacía separadora

            // === CABECERA DE COLUMNAS ===
            fputcsv($file, [
                'N°',
                'Nombre de la Empresa',
                'NIT',
                'Representante Legal',
                'Cédula Representante',
                'Correo Electrónico',
                'Teléfono',
                'Dirección',
                'Fecha de Registro',
                'Estado',
            ], ';');

            // === DATOS ===
            $i = 1;
            foreach ($empresas as $empresa) {
                $estado = $empresa->estado ? $empresa->estado->nombre_estado : 'Desconocido';
                fputcsv($file, [
                    $i++,
                    $empresa->nombre_empresa,
                    $empresa->id_empresa,
                    $empresa->nombre_repre_legal,
                    $empresa->cedula_repre ?? 'N/A',
                    $empresa->correo,
                    $empresa->telefono,
                    $empresa->direccion,
                    $empresa->fecha_creacion ? \Carbon\Carbon::parse($empresa->fecha_creacion)->format('d/m/Y') : 'N/A',
                    $estado,
                ], ';');
            }

            fputcsv($file, [], ';');
            fputcsv($file, ['--- Fin del reporte ---'], ';');

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
