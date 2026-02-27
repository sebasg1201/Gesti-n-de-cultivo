<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\SolicitudCompra;
use App\Models\TipoLicencia;
use App\Models\SuperAdmin;
use App\Models\Empresa;

class SolicitudCompraController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $query = SolicitudCompra::with(['tipoLicencia', 'estado', 'superAdmin', 'empresa']);

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('id_empresa', 'LIKE', "%{$search}%")
                    ->orWhereHas('empresa', function ($q2) use ($search) {
                        $q2->where('nombre_empresa', 'LIKE', "%{$search}%")
                            ->orWhere('correo', 'LIKE', "%{$search}%");
                    });
            });
        }

        $solicitudes = $query->orderBy('fecha_solicitud', 'desc')->paginate(3);

        return view('superadmin.solicitudes', compact('solicitudes'));
    }

    public function markAsSeen($id)
    {
        $solicitud = SolicitudCompra::find($id);

        if ($solicitud) {
            $solicitud->id_estado = 5;
            $solicitud->fecha_revision = now();
            $solicitud->save();

            return redirect()->back()->with('success', 'Solicitud marcada como vista.');
        }

        return redirect()->back()->with('error', 'Solicitud no encontrada.');
    }

    public function aprobar($id)
    {
        $solicitud = SolicitudCompra::find($id);

        if (!$solicitud) {
            return redirect()->back()->with('error', 'Solicitud no encontrada.');
        }

        // 1. Actualizar estado de la solicitud a Aprobado (5)
        $solicitud->id_estado = 5;
        $solicitud->fecha_revision = now();
        $solicitud->save();

        return redirect()->back()->with('success', 'Solicitud aprobada.');
    }

    public function destroy($id)
    {
        $solicitud = SolicitudCompra::find($id);

        if (!$solicitud) {
            return redirect()->back()->with('error', 'Solicitud no encontrada.');
        }

        $idEmpresa = $solicitud->id_empresa;

        try {
            // Desactivar FK checks para garantizar borrado sin restricciones
            \DB::statement('SET FOREIGN_KEY_CHECKS=0');

            // 1. Borrar TODAS las solicitudes de la empresa
            \DB::table('solicitud_compra')->where('id_empresa', $idEmpresa)->delete();

            if ($idEmpresa) {
                // 2. Borrar usuarios de la empresa
                \DB::table('usuario')->where('id_empresa', $idEmpresa)->delete();

                // 3. Borrar licencias de la empresa
                \DB::table('venta_licencias')->where('id_empresa', $idEmpresa)->delete();

                // 4. Borrar la empresa directamente
                \DB::table('empresa')->where('id_empresa', $idEmpresa)->delete();
            }

            // Reactivar FK checks
            \DB::statement('SET FOREIGN_KEY_CHECKS=1');

        } catch (\Exception $e) {
            \DB::statement('SET FOREIGN_KEY_CHECKS=1'); // Siempre reactivar
            return redirect()->back()->with('error', 'Error al eliminar: ' . $e->getMessage());
        }

        return redirect()->back()->with('success', 'Solicitud y empresa eliminadas correctamente.');
    }

    public function create($licencia_id)
    {
        $licencia = TipoLicencia::find($licencia_id);

        if (!$licencia) {
            return redirect('/')->with('error', 'Licencia no encontrada.');
        }

        return view('usuario.solicitud', compact('licencia'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_empresa' => 'required|string|max:20',
            'nombre_empresa' => 'required|string|max:200',
            'nombre_repre_legal' => 'required|string|max:150',
            'cedula_repre' => 'required|numeric|digits_between:8,11',
            'telefono' => 'required|numeric|digits_between:8,11',
            'correo' => 'required|email|max:150',
            'direccion' => 'required|string|max:200',
            'comprobante_pago' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'licencia_id' => 'required|exists:tipo_licencia,id_tipo_licencia',
        ]);

        // 1. Manejo del Archivo (Comprobante)
        if ($request->hasFile('comprobante_pago')) {
            $image = $request->file('comprobante_pago');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('comprobantes'), $imageName);
            $rutaComprobante = 'comprobantes/' . $imageName;
        } else {
            return back()->with('error', 'El comprobante de pago es obligatorio.');
        }

        // 2. Crear o Actualizar Empresa
        $empresa = Empresa::updateOrCreate(
            ['id_empresa' => $request->id_empresa],
            [
                'nombre_empresa' => $request->nombre_empresa,
                'nombre_repre_legal' => $request->nombre_repre_legal,
                'cedula_repre' => $request->cedula_repre,
                'telefono' => $request->telefono,
                'correo' => $request->correo,
                'direccion' => $request->direccion,
                'fecha_creacion' => now(),
                'id_estado' => 1, // 1 = pendiente
            ]
        );

        // 3. Crear Solicitud de Compra
        SolicitudCompra::create([
            'id_empresa' => $empresa->id_empresa,
            'comprobante_pago' => $rutaComprobante,
            'id_tipo_licencia' => $request->licencia_id,
            'id_estado' => 1, // 1 = Pendiente
            'fecha_solicitud' => now(),
            'fecha_revision' => null,
        ]);

        return redirect('/')->with('success', 'Solicitud enviada exitosamente. Estaremos en contacto.');
    }

    public function exportarReporte(\Illuminate\Http\Request $request)
    {
        $year = $request->input('year', date('Y'));
        $month = $request->input('month');

        $nombreMes = $month ? ucfirst(\Carbon\Carbon::createFromDate(2024, (int) $month, 1)->locale('es')->monthName) : null;
        $periodoLabel = $nombreMes ? "$nombreMes $year" : "Todo el año $year";

        $query = SolicitudCompra::with(['empresa', 'tipoLicencia', 'estado'])
            ->whereYear('fecha_solicitud', $year);

        if ($month) {
            $query->whereMonth('fecha_solicitud', $month);
        }

        $solicitudes = $query->orderBy('fecha_solicitud', 'desc')->get();

        $csvFileName = 'Reporte_Solicitudes_' . $year . ($month ? '_' . str_pad($month, 2, '0', STR_PAD_LEFT) : '') . '.csv';

        $headers = [
            "Content-type" => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=$csvFileName",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];

        $callback = function () use ($solicitudes, $periodoLabel) {
            $file = fopen('php://output', 'w');
            fputs($file, chr(0xEF) . chr(0xBB) . chr(0xBF)); // BOM UTF-8

            // === ENCABEZADO DEL REPORTE ===
            fputcsv($file, ['REPORTE DE SOLICITUDES DE COMPRA'], ';');
            fputcsv($file, ['Período:', $periodoLabel], ';');
            fputcsv($file, ['Fecha de generación:', now()->format('d/m/Y H:i')], ';');
            fputcsv($file, ['Total de registros:', $solicitudes->count()], ';');
            fputcsv($file, [], ';');

            // === CABECERA DE COLUMNAS ===
            fputcsv($file, [
                'N°',
                'Empresa',
                'NIT',
                'Representante Legal',
                'Correo Electrónico',
                'Teléfono',
                'Plan Solicitado',
                'Fecha de Solicitud',
                'Estado',
            ], ';');

            // === FILAS DE DATOS ===
            $i = 1;
            foreach ($solicitudes as $sol) {
                $empresa = $sol->empresa;
                $estado = $sol->estado ? $sol->estado->nombre_estado : 'Desconocido';
                fputcsv($file, [
                    $i++,
                    $empresa->nombre_empresa ?? 'N/A',
                    $sol->id_empresa,
                    $empresa->nombre_repre_legal ?? 'N/A',
                    $empresa->correo ?? 'N/A',
                    $empresa->telefono ?? 'N/A',
                    $sol->tipoLicencia->nombre_licencia ?? 'N/A',
                    \Carbon\Carbon::parse($sol->fecha_solicitud)->format('d/m/Y'),
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