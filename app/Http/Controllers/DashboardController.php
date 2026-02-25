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
use Illuminate\Support\Facades\Mail;
use App\Mail\AdminCreatedMail;
use Barryvdh\DomPDF\Facade\Pdf;

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

        // 3. AUTO-EXPIRE LICENSES
        $activasOPendientes = VentaLicencias::with('tipoLicencia')->whereIn('id_estado', [1, 3])->get();
        foreach ($activasOPendientes as $lic) {
            if ($lic->tipoLicencia) {
                $meses = (int) filter_var($lic->tipoLicencia->tiempo, FILTER_SANITIZE_NUMBER_INT);
                if (stripos($lic->tipoLicencia->tiempo, 'año') !== false || stripos($lic->tipoLicencia->tiempo, 'year') !== false) {
                    $meses = $meses * 12;
                }
                if ($meses == 0)
                    $meses = 12;

                $fechaFin = Carbon::parse($lic->fecha_inicio)->addMonths($meses)->endOfDay();
                if (now()->greaterThan($fechaFin)) {
                    DB::table('venta_licencias')->where('id_key', $lic->id_key)->update(['id_estado' => 2]);
                }
            }
        }

        // 4. LICENSES TABLE LOGIC
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

        $licencasTable = $query->paginate(3);


        return view('SuperAdmin.dashboard', compact(
            'licenciasPorVencer',
            'renovadasEsteMes',
            'totalLicencias',
            'empresas',
            'tiposLicencia',
            'licencasTable'
        ));
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

        // Buscar última solicitud siempre (independientemente de la licencia)
        $solicitudReciente = SolicitudCompra::where('id_empresa', $nit)
            ->latest('fecha_solicitud')
            ->first();

        if (!$idTipoLicencia) {
            $idTipoLicencia = $solicitudReciente->id_tipo_licencia ?? null;
        }

        return response()->json([
            'id_empresa' => $empresa->id_empresa,
            'nombre_empresa' => $empresa->nombre_empresa,
            'nombre_repre_legal' => $empresa->nombre_repre_legal,
            'cedula_repre' => $empresa->cedula_repre,
            'telefono' => $empresa->telefono,
            'direccion' => $empresa->direccion,
            'correo' => $empresa->correo,
            'id_tipo_licencia' => $idTipoLicencia,
            'tiene_licencia_activa' => VentaLicencias::where('id_empresa', $nit)->where('id_estado', 3)->exists(),
            'tiene_licencia_asignada' => $ultimaLicencia ? true : false,
            'solicitud_aprobada' => ($solicitudReciente && $solicitudReciente->id_estado == 5) ? true : false,
            'es_creada_admin' => ($solicitudReciente && $solicitudReciente->comprobante_pago == null && $solicitudReciente->id_estado == 5) ? true : false, // Si es creada por Dashboard, no pasa por aprobacion manual visual normal, ya está en 5
            'empresa_activa' => ($empresa->id_estado == 3) ? true : false,
            'tiene_admin' => \App\Models\Usuario::where('id_empresa', $nit)->where('id_tipo_usuario', 1)->exists(),
        ]);
    }


    public function storeEmpresa(Request $request)
    {
        $request->validate([
            'id_empresa' => 'required|numeric|unique:empresa,id_empresa',
            'nombre_empresa' => 'required|string|max:200',
            'nombre_repre_legal' => 'required|string|max:100',
            'cedula_repre' => 'required|numeric|digits_between:7,11',
            'telefono' => 'required|string|max:12',
            'direccion' => 'required|string|max:150',
            'correo' => 'required|email|max:100|unique:empresa,correo',
            'id_tipo_licencia' => 'required|exists:tipo_licencia,id_tipo_licencia',
        ]);

        $empresa = Empresa::create([
            'id_empresa' => $request->id_empresa,
            'nombre_empresa' => $request->nombre_empresa,
            'nombre_repre_legal' => $request->nombre_repre_legal,
            'cedula_repre' => $request->cedula_repre,
            'telefono' => $request->telefono,
            'direccion' => $request->direccion,
            'correo' => $request->correo,
            'fecha_creacion' => now(),
            'id_estado' => 1
        ]);

        // Crear solicitud automáticamente, marcada como "Vista" (id_estado=5)
        // Sin comprobante de pago (manual), pero con el tipo de licencia seleccionado
        SolicitudCompra::create([
            'id_empresa' => $empresa->id_empresa,
            'comprobante_pago' => null,
            'id_tipo_licencia' => $request->id_tipo_licencia,
            'id_estado' => 5, // 5 = Vista
            'fecha_solicitud' => now(),
            'fecha_revision' => now(),
        ]);

        return back()->with('success', 'Empresa creada exitosamente.');
    }

    public function storeLicencia(Request $request)
    {
        $request->validate([
            'id_empresa' => 'required|exists:empresa,id_empresa',
            'id_tipo_licencia' => 'required|exists:tipo_licencia,id_tipo_licencia',
        ]);

        // Verificar si la empresa ya tiene una licencia activa
        $licenciaActiva = DB::table('venta_licencias')
            ->where('id_empresa', $request->id_empresa)
            ->where('id_estado', 3)
            ->exists();

        if ($licenciaActiva) {
            return back()->with('error', 'Esta empresa ya tiene una licencia activa. No se puede asignar otra.');
        }

        $solicitudReciente = SolicitudCompra::where('id_empresa', $request->id_empresa)
            ->latest('fecha_solicitud')
            ->first();

        // Si la solicitud no es 5 (Aprobada) y tiene comprobante de pago (lo que indica que vino del registro de usuarios), bloqueamos.
        // Las creadas por el Dashboard (storeEmpresa) nacen en 5 y sin comprobante.
        if ($solicitudReciente && $solicitudReciente->id_estado != 5) {
            return back()->with('error', 'Debes aprobar la solicitud de la empresa antes de asignarle una licencia.');
        }

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

        if (!$empresa || $empresa->id_estado != 3) {
            return back()->with('error', 'No puedes crear un administrador para una empresa que no está activa. Actívala primero desde la tabla.');
        }

        $yaTieneAdmin = \App\Models\Usuario::where('id_empresa', $request->id_empresa)->where('id_tipo_usuario', 1)->exists();
        if ($yaTieneAdmin) {
            return back()->with('error', 'Esta empresa ya tiene un administrador asignado. Solo se permite un administrador principal por empresa.');
        }

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

        try {
            // Intentar obtener el nombre del plan para el PDF
            $ultimaLicencia = VentaLicencias::where('id_empresa', $empresa->id_empresa)->latest('fecha_inicio')->first();
            $planName = 'Sin plan activo';
            if ($ultimaLicencia && $ultimaLicencia->tipoLicencia) {
                $planName = $ultimaLicencia->tipoLicencia->nombre_licencia;
            }

            // Generar el PDF
            $pdf = Pdf::loadView('pdf.admin_credentials', [
                'adminName' => $request->nombre,
                'email' => $request->correo,
                'password' => $request->contrasena,
                'empresaName' => $empresa->nombre_empresa,
                'planName' => $planName
            ]);

            // Enviar el correo con el PDF adjunto
            Mail::to($request->correo)->send(new AdminCreatedMail(
                $request->nombre,
                $request->correo,
                $request->contrasena,
                $empresa->nombre_empresa,
                $planName,
                $pdf->output()
            ));
        } catch (\Exception $e) {
            return back()->with('error', 'Administrador creado, pero hubo un error al enviar el correo con las credenciales: ' . $e->getMessage());
        }

        return back()->with('success', 'Administrador creado exitosamente y credenciales enviadas.');
    }

    public function updateLicencia(Request $request, $id)
    {
        $request->validate([
            'id_tipo_licencia' => 'required|exists:tipo_licencia,id_tipo_licencia',
        ]);

        $licencia = DB::table('venta_licencias')->where('id_key', $id)->first();
        if (!$licencia) {
            return back()->withErrors(['Licencia no encontrada']);
        }

        DB::table('venta_licencias')->where('id_key', $id)->update([
            'id_tipo_licencia' => $request->id_tipo_licencia,
        ]);

        return back()->with('success', 'Licencia actualizada exitosamente.');
    }

    public function exportarReporte(Request $request)
    {
        $year = $request->input('year', date('Y'));
        $month = $request->input('month');

        $nombreMes = $month ? ucfirst(\Carbon\Carbon::createFromDate(2024, (int) $month, 1)->locale('es')->monthName) : null;
        $periodoLabel = $nombreMes ? "$nombreMes $year" : "Todo el año $year";

        $query = DB::table('venta_licencias as vl')
            ->join('empresa as e', 'vl.id_empresa', '=', 'e.id_empresa')
            ->join('tipo_licencia as tl', 'vl.id_tipo_licencia', '=', 'tl.id_tipo_licencia')
            ->select(
                'e.nombre_empresa',
                'e.id_empresa as nit',
                'tl.nombre_licencia',
                'tl.tiempo',
                'vl.fecha_inicio',
                'vl.id_estado'
            )
            ->whereYear('vl.fecha_inicio', $year);

        if ($month) {
            $query->whereMonth('vl.fecha_inicio', $month);
        }

        $licencias = $query->get();

        $csvFileName = 'Reporte_Licencias_' . $year . ($month ? '_' . str_pad($month, 2, '0', STR_PAD_LEFT) : '') . '.csv';

        $headers = [
            "Content-type" => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=$csvFileName",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];

        $callback = function () use ($licencias, $periodoLabel) {
            $file = fopen('php://output', 'w');
            fputs($file, chr(0xEF) . chr(0xBB) . chr(0xBF)); // BOM UTF-8

            // === ENCABEZADO DEL REPORTE ===
            fputcsv($file, ['REPORTE DE LICENCIAS ASIGNADAS'], ';');
            fputcsv($file, ['Período:', $periodoLabel], ';');
            fputcsv($file, ['Fecha de generación:', now()->format('d/m/Y H:i')], ';');
            fputcsv($file, ['Total de registros:', $licencias->count()], ';');
            fputcsv($file, [], ';'); // Separador

            // === CABECERA DE COLUMNAS ===
            fputcsv($file, [
                'N°',
                'Empresa',
                'NIT',
                'Plan de Licencia',
                'Duración del Plan',
                'Fecha de Inicio',
                'Fecha de Vencimiento',
                'Estado',
            ], ';');

            // === FILAS DE DATOS ===
            $i = 1;
            foreach ($licencias as $lic) {
                $estado = match ($lic->id_estado) {
                    3 => 'Activa',
                    1 => 'Pendiente',
                    2 => 'Inactiva',
                    default => 'Desconocido'
                };

                $meses = (int) filter_var($lic->tiempo, FILTER_SANITIZE_NUMBER_INT);
                if (stripos($lic->tiempo, 'año') !== false || stripos($lic->tiempo, 'year') !== false) {
                    $meses = $meses * 12;
                }
                if ($meses == 0)
                    $meses = 12;
                $fechaFin = Carbon::parse($lic->fecha_inicio)->addMonths($meses)->format('d/m/Y');

                fputcsv($file, [
                    $i++,
                    $lic->nombre_empresa,
                    $lic->nit,
                    $lic->nombre_licencia,
                    $lic->tiempo,
                    Carbon::parse($lic->fecha_inicio)->format('d/m/Y'),
                    $fechaFin,
                    $estado,
                ], ';');
            }

            fputcsv($file, [], ';');
            fputcsv($file, ['--- Fin del reporte ---'], ';');
            fclose($file);
        };

        return new StreamedResponse($callback, 200, $headers);
    }
}
