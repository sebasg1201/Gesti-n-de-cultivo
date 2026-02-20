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
        $query = Empresa::with('estado');

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('nombre_empresa', 'like', "%{$search}%")
                    ->orWhere('nombre_repre_legal', 'like', "%{$search}%")
                    ->orWhere('id_empresa', 'like', "%{$search}%"); // Assuming NIT is id_empresa or similar
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

        // Changed pagination to 4 as requested
        $empresas = $query->paginate(3);

        // Calculate stats
        $stats = [
            'nuevas' => Empresa::where('id_estado', 1)->count(), // Assuming 1 is Pending/New
            'suspendidas' => Empresa::where('id_estado', 2)->count(), // Assuming 2 is Suspended
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
            'nombre_empresa'    => 'required|string|max:200',
            'nombre_repre_legal' => 'required|string|max:100',
            'cedula_repre'      => 'required|numeric|digits_between:7,11',
            'telefono'          => 'required|string|max:12',
            'direccion'         => 'required|string|max:150',
            'correo'            => 'required|email|max:100|unique:empresa,correo,' . $id . ',id_empresa',
        ]);

        $empresa->update([
            'nombre_empresa'    => $request->nombre_empresa,
            'nombre_repre_legal' => $request->nombre_repre_legal,
            'cedula_repre'      => $request->cedula_repre,
            'telefono'          => $request->telefono,
            'direccion'         => $request->direccion,
            'correo'            => $request->correo,
        ]);

        return back()->with('success', 'Empresa actualizada exitosamente.');
    }

    public function activar($id)
    {
        $empresa = Empresa::findOrFail($id);


        $empresa->id_estado = 3; // Activa
        $empresa->save();

        $licencia = \App\Models\VentaLicencias::where('id_empresa', $id)
            ->orderBy('fecha_inicio', 'desc')
            ->first();

        if ($licencia) {
            $licencia->id_estado = 3; // 3 = Activa (Synced with Company)
            $licencia->fecha_inicio = now(); // Reset start time
            $licencia->save();
        }


        \App\Models\Usuario::where('id_empresa', $id)->update(['id_estado' => 3]);

        return redirect()->back()->with('success', 'Empresa, Licencia y Usuarios activados con éxito.');
    }

    public function generarExcel(Request $request)
    {
        $mes = (int) $request->input('mes', now()->month);
        $year = (int) $request->input('anio', now()->year);

        $nombreMes = \Carbon\Carbon::create()->month($mes)->locale('es')->monthName;
        $nombreMes = ucfirst($nombreMes);

        $empresas = Empresa::with(['estado'])
            ->whereMonth('fecha_creacion', $mes)
            ->whereYear('fecha_creacion', $year)
            ->get();

        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=Reporte_Empresas_{$nombreMes}_{$year}.csv",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];

        $callback = function () use ($empresas) {
            $file = fopen('php://output', 'w');

            // Add BOM for Excel UTF-8 compatibility
            fputs($file, "\xEF\xBB\xBF");

            // Header Row
            fputcsv($file, ['Empresa', 'NIT', 'Representante', 'Correo', 'Teléfono', 'Estado']);

            foreach ($empresas as $empresa) {
                $estado = 'Desconocido';
                if ($empresa->estado) {
                    $estado = $empresa->estado->nombre_estado; // Assuming relationship is loaded
                }

                fputcsv($file, [
                    $empresa->nombre_empresa,
                    $empresa->id_empresa, // NIT
                    $empresa->nombre_repre_legal,
                    $empresa->correo,
                    $empresa->telefono,
                    $estado
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
