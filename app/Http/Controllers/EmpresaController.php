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
        $empresas = $query->paginate(4);

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
    public function generarReporte(Request $request)
    {
        $mes = (int) $request->input('mes', now()->month);
        $year = (int) $request->input('anio', now()->year);

        // Stats for the specific month
        $nuevas = Empresa::whereMonth('fecha_creacion', $mes)->whereYear('fecha_creacion', $year)->where('id_estado', 1)->count();
        $activas = Empresa::whereMonth('fecha_creacion', $mes)->whereYear('fecha_creacion', $year)->where('id_estado', 3)->count();
        $bloqueadas = Empresa::whereMonth('fecha_creacion', $mes)->whereYear('fecha_creacion', $year)->where('id_estado', 2)->count();
        $total = $nuevas + $activas + $bloqueadas;

        $nombreMes = \Carbon\Carbon::create()->month($mes)->locale('es')->monthName;
        $nombreMes = ucfirst($nombreMes);

        // SVG Dimensions
        $width = 500;
        $height = 300;
        $margin = 50;
        $barWidth = 60;
        $maxVal = max($nuevas, $activas, $bloqueadas, 1); // Avoid div by zero
        $scale = ($height - 2 * $margin) / $maxVal;

        // Colors
        $colorNuevas = '#FCD34D'; // Yellow-300
        $colorActivas = '#34D399'; // Green-400
        $colorBloqueadas = '#F87171'; // Red-400

        // Calculate Heights
        $hNuevas = $nuevas * $scale;
        $hActivas = $activas * $scale;
        $hBloqueadas = $bloqueadas * $scale;

        $svg = '<?xml version="1.0" encoding="UTF-8" standalone="no"?>';
        $svg .= '<svg width="' . $width . '" height="' . $height . '" xmlns="http://www.w3.org/2000/svg">';

        // Background
        $svg .= '<rect width="100%" height="100%" fill="white" />';

        // Title
        $svg .= '<text x="' . $width / 2 . '" y="30" font-family="Arial" font-size="18" font-weight="bold" text-anchor="middle">Reporte de Empresas - ' . $nombreMes . ' ' . $year . '</text>';
        $svg .= '<text x="' . $width / 2 . '" y="50" font-family="Arial" font-size="12" fill="gray" text-anchor="middle">Total Registradas: ' . $total . '</text>';

        // Axis
        $svg .= '<line x1="' . $margin . '" y1="' . $height - $margin . '" x2="' . $width - $margin . '" y2="' . $height - $margin . '" stroke="black" stroke-width="2"/>'; // X Axis
        $svg .= '<line x1="' . $margin . '" y1="' . $margin . '" x2="' . $margin . '" y2="' . $height - $margin . '" stroke="black" stroke-width="2"/>'; // Y Axis

        // Bars
        // 1. Pendientes
        $x1 = $margin + 50;
        $y1 = $height - $margin - $hNuevas;
        $svg .= '<rect x="' . $x1 . '" y="' . $y1 . '" width="' . $barWidth . '" height="' . $hNuevas . '" fill="' . $colorNuevas . '"/>';
        $svg .= '<text x="' . $x1 + $barWidth / 2 . '" y="' . $y1 - 5 . '" font-family="Arial" font-size="12" text-anchor="middle">' . $nuevas . '</text>';
        $svg .= '<text x="' . $x1 + $barWidth / 2 . '" y="' . $height - $margin + 15 . '" font-family="Arial" font-size="10" text-anchor="middle">Pendientes</text>';

        // 2. Activas
        $x2 = $x1 + $barWidth + 50;
        $y2 = $height - $margin - $hActivas;
        $svg .= '<rect x="' . $x2 . '" y="' . $y2 . '" width="' . $barWidth . '" height="' . $hActivas . '" fill="' . $colorActivas . '"/>';
        $svg .= '<text x="' . $x2 + $barWidth / 2 . '" y="' . $y2 - 5 . '" font-family="Arial" font-size="12" text-anchor="middle">' . $activas . '</text>';
        $svg .= '<text x="' . $x2 + $barWidth / 2 . '" y="' . $height - $margin + 15 . '" font-family="Arial" font-size="10" text-anchor="middle">Activas</text>';

        // 3. Bloqueadas
        $x3 = $x2 + $barWidth + 50;
        $y3 = $height - $margin - $hBloqueadas;
        $svg .= '<rect x="' . $x3 . '" y="' . $y3 . '" width="' . $barWidth . '" height="' . $hBloqueadas . '" fill="' . $colorBloqueadas . '"/>';
        $svg .= '<text x="' . $x3 + $barWidth / 2 . '" y="' . $y3 - 5 . '" font-family="Arial" font-size="12" text-anchor="middle">' . $bloqueadas . '</text>';
        $svg .= '<text x="' . $x3 + $barWidth / 2 . '" y="' . $height - $margin + 15 . '" font-family="Arial" font-size="10" text-anchor="middle">Bloqueadas</text>';

        $svg .= '</svg>';

        return response($svg, 200)
            ->header('Content-Type', 'image/svg+xml')
            ->header('Content-Disposition', 'attachment; filename="Reporte_Empresas_' . $nombreMes . '.svg"');
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
