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

class DashboardController extends Controller
{
    public function index()
    {
        $licenciasPorVencer = DB::table('venta_licencias as vl')
            ->join('tipo_licencia as tl', 'vl.id_tipo_licencia', '=', 'tl.id_tipo_licencia')
            ->where('vl.id_estado', 1)
            ->get()
            ->filter(function ($licencia) {

                $meses = (int) filter_var($licencia->tiempo, FILTER_SANITIZE_NUMBER_INT);
                if ($meses == 0) $meses = 12;

                $fechaFin = Carbon::parse($licencia->fecha_inicio)->addMonths($meses);

                return $fechaFin->diffInDays(now()) <= 30 && $fechaFin->isFuture();
            })
            ->count();

        $renovadasEsteMes = VentaLicencias::whereMonth('fecha_inicio', now()->month)
            ->whereYear('fecha_inicio', now()->year)
            ->count();

        $totalLicencias = VentaLicencias::count();

        $empresas = Empresa::all();
        $tiposLicencia = TipoLicencia::all();

        return view('SuperAdmin.dashboard', compact(
            'licenciasPorVencer',
            'renovadasEsteMes',
            'totalLicencias',
            'empresas',
            'tiposLicencia'
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
            'id_empresa' => 'required|numeric|digits_between:8,12|unique:empresa,id_empresa',
            'nombre_empresa' => 'required|string|max:200',
            'nombre_repre_legal' => 'required|string|max:100',
            'telefono' => 'required|numeric|digits_between:10,15',
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
        if ($meses == 0) $meses = 12;

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
            'documento' => 'required|numeric|digits_between:8,12|unique:usuario,documento',
            'nombre' => 'required|string|max:150',
            'correo' => 'required|email|unique:usuario,correo',
            'telefono' => 'required|numeric|digits_between:10,15',
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
