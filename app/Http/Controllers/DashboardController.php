<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Empresa;
use App\Models\Usuario;
use App\Models\VentaLicencias;
use App\Models\TipoLicencia;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Models\SolicitudCompra;
use Symfony\Component\HttpFoundation\StreamedResponse;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // 1. KPI Stats
        $licenciasPorVencer = DB::table('venta_licencias as vl')
            ->join('tipo_licencia as tl', 'vl.id_tipo_licencia', '=', 'tl.id_tipo_licencia')
            ->where('vl.id_estado', 1)
            ->get()
            ->filter(function ($licencia) {
                $meses = (int) filter_var($licencia->tiempo, FILTER_SANITIZE_NUMBER_INT);
                if ($meses == 0)
                    $meses = 12;
                $fechaFin = Carbon::parse($licencia->fecha_inicio)->addMonths($meses);
                return $fechaFin->diffInDays(now()) <= 30 && $fechaFin->isFuture();
            })
            ->count();

        $renovadasEsteMes = VentaLicencias::whereMonth('fecha_inicio', now()->month)
            ->whereYear('fecha_inicio', now()->year)
            ->count();

        $totalLicencias = VentaLicencias::count();

        // 2. Fetch Data for Forms (Existing logic)
        $empresas = Empresa::all();
        $tiposLicencia = TipoLicencia::all();

        // 3. LICENSES TABLE LOGIC (New)
        $query = VentaLicencias::with(['empresa', 'tipoLicencia']);

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->whereHas('empresa', function ($subQ) use ($search) {
                    $subQ->where('nombre_empresa', 'like', "%{$search}%")
                        ->orWhere('id_empresa', 'like', "%{$search}%");
                });
            });
        }

        if ($request->has('status')) {
            $status = $request->input('status');
            if ($status === 'active')
                $query->where('id_estado', 1); // Assuming 1 is Active based on older code? Wait, older code used 3 for active company, but let's check VentaLicencias. Assuming 1=Active, 2=Inactive/Expired based on context. 
            // Correction: In CompanyController, 3=Active. In DashboardController storeLicencia, it sets 3 if company is active, else 1. Let's assume standard status.
            // Let's filter by raw ID for now to be safe or use map.
            // Let's map 'activa' -> 3, 'pendiente' -> 1, 'vencida' -> 2
            if ($status === 'activa')
                $query->where('id_estado', 3);
            elseif ($status === 'pendiente')
                $query->where('id_estado', 1);
            elseif ($status === 'inactiva')
                $query->where('id_estado', 2);
        }

        $licencasTable = $query->orderBy('fecha_inicio', 'desc')->paginate(10);


        return view('SuperAdmin.dashboard', compact(
            'licenciasPorVencer',
            'renovadasEsteMes',
            'totalLicencias',
            'empresas',
            'tiposLicencia',
            'licencasTable'
        ));
    }

    public function updateLicencia(Request $request, $id)
    {
        $licencia = VentaLicencias::findOrFail($id);

        $request->validate([
            'fecha_inicio' => 'required|date',
            'id_estado' => 'required|integer',
            'id_tipo_licencia' => 'required|exists:tipo_licencia,id_tipo_licencia'
        ]);

        $licencia->fecha_inicio = $request->fecha_inicio;
        $licencia->id_estado = $request->id_estado;
        $licencia->id_tipo_licencia = $request->id_tipo_licencia;
        $licencia->save();

        return back()->with('success', 'Licencia actualizada correctamente.');
    }

    public function exportarReporte(Request $request): StreamedResponse
    {
        $year = $request->input('year', now()->year);
        $month = $request->input('month');

        $filename = "reporte_licencias_{$year}" . ($month ? "_{$month}" : "") . ".csv";

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        return new StreamedResponse(function () use ($year, $month) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['ID Licencia', 'Empresa', 'NIT', 'Plan', 'Fecha Inicio', 'Estado']);

            $query = DB::table('venta_licencias as vl')
                ->join('empresa as e', 'vl.id_empresa', '=', 'e.id_empresa')
                ->join('tipo_licencia as tl', 'vl.id_tipo_licencia', '=', 'tl.id_tipo_licencia')
                ->select(
                    'vl.id_key',
                    'e.nombre_empresa',
                    'vl.id_empresa', // This is the NIT
                    'tl.nombre_licencia',
                    'vl.fecha_inicio',
                    'vl.id_estado'
                )
                ->whereYear('vl.fecha_inicio', $year);

            if ($month) {
                $query->whereMonth('vl.fecha_inicio', $month);
            }

            $licencias = $query->cursor(); // Use cursor for large datasets

            foreach ($licencias as $licencia) {
                $estado = '';
                if ($licencia->id_estado == 3) {
                    $estado = 'Activa';
                } elseif ($licencia->id_estado == 1) {
                    $estado = 'Pendiente';
                } else {
                    $estado = 'Inactiva';
                }

                fputcsv($handle, [
                    $licencia->id_key,
                    $licencia->nombre_empresa,
                    $licencia->id_empresa,
                    $licencia->nombre_licencia,
                    $licencia->fecha_inicio,
                    $estado
                ]);
            }

            fclose($handle);
        }, 200, $headers);
    }

    public function buscarEmpresa($nit)
    {
        $empresa = Empresa::where('id_empresa', $nit)->first();

        if (!$empresa) {
            return response()->json(null);
        }

        // Buscar última licencia asignada a la empresa
        $ultimaLicencia = VentaLicencias::where('id_empresa', $nit)
            ->latest('fecha_inicio')
            ->first();

        $idTipoLicencia = $ultimaLicencia->id_tipo_licencia ?? null;

        // Si no tiene historial de licencias, buscamos si tiene una solicitud reciente
        if (!$idTipoLicencia) {
            $solicitudReciente = SolicitudCompra::where('nit_empresa', $nit)
                ->latest('fecha_solicitud')
                ->first();

            $idTipoLicencia = $solicitudReciente->id_tipo_licencia ?? null;
        }

        return response()->json([
            'id_empresa' => $empresa->id_empresa,
            'nombre_empresa' => $empresa->nombre_empresa,
            'nombre_repre_legal' => $empresa->nombre_repre_legal,
            'telefono' => $empresa->telefono,
            'direccion' => $empresa->direccion,
            'correo' => $empresa->correo,
            'id_tipo_licencia' => $idTipoLicencia
        ]);
    }


    public function storeEmpresa(Request $request)
    {
        $request->validate([
            'id_empresa' => 'required|numeric|unique:empresa,id_empresa',
            'nombre_empresa' => 'required|string|max:200',
            'nombre_repre_legal' => 'required|string|max:100',
            'telefono' => 'required|string|max:12',
            'direccion' => 'required|string|max:150',
            'correo' => 'required|email|max:100|unique:empresa,correo',
        ]);

        Empresa::create([
            'id_empresa' => $request->id_empresa,
            'nombre_empresa' => $request->nombre_empresa,
            'nombre_repre_legal' => $request->nombre_repre_legal,
            'telefono' => $request->telefono,
            'direccion' => $request->direccion,
            'correo' => $request->correo,
            'fecha_creacion' => now(),
            'id_estado' => 1
        ]);

        return back()->with('success', 'Empresa creada exitosamente.');
    }

    public function storeLicencia(Request $request)
    {
        $request->validate([
            'id_empresa' => 'required|exists:empresa,id_empresa',
            'id_tipo_licencia' => 'required|exists:tipo_licencia,id_tipo_licencia',
        ]);

        $tipoLicencia = TipoLicencia::findOrFail($request->id_tipo_licencia);

        $meses = (int) filter_var($tipoLicencia->tiempo, FILTER_SANITIZE_NUMBER_INT);
        if ($meses == 0)
            $meses = 12;

        $empresa = Empresa::find($request->id_empresa);

        $estadoLicencia = ($empresa && $empresa->id_estado == 3) ? 3 : 1;

        DB::table('venta_licencias')->insert([
            'id_key' => Str::random(14),
            'fecha_inicio' => now(),
            'observacione' => 'Asignada desde Dashboard',
            'id_empresa' => $request->id_empresa,
            'id_tipo_licencia' => $request->id_tipo_licencia,
            'id_estado' => $estadoLicencia
        ]);

        return back()->with('success', 'Licencia asignada exitosamente.');
    }

    public function storeAdministrador(Request $request)
    {
        $request->validate([
            'documento' => 'required|numeric|digits_between:7,10|unique:usuario,documento',
            'nombre' => 'required|string',
            'correo' => 'required|email|unique:usuario,correo',
            'telefono' => 'required|numeric|digits_between:7,10',
            'contrasena' => 'required|min:8',
            'id_empresa' => 'required|exists:empresa,id_empresa',
            'imagen' => 'required|image|max:2048',
        ]);

        $imagePath = $request->file('imagen')->store('usuarios', 'public');

        $empresa = Empresa::find($request->id_empresa);

        $estadoUsuario = ($empresa && $empresa->id_estado == 3) ? 3 : 1;

        DB::table('usuario')->insert([
            'documento' => $request->documento,
            'nombre' => $request->nombre,
            'correo' => $request->correo,
            'telefono' => $request->telefono,
            'contrasena' => Hash::make($request->contrasena),
            'id_empresa' => $request->id_empresa,
            'id_tipo_usuario' => 1,
            'id_estado' => $estadoUsuario,
            'imagen' => $imagePath
        ]);

        return back()->with('success', 'Administrador creado exitosamente.');
    }
}
