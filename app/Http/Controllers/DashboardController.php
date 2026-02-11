<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Empresa;
use App\Models\Usuario;
use App\Models\VentaLicencias;
use App\Models\TipoLicencia;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // --- REPORTS LOGIC ---

        // 1. Licencias Por Vencer
        $licenciasPorVencer = DB::table('venta_licencias as vl')
            ->join('tipo_licencia as tl', 'vl.id_tipo_licencia', '=', 'tl.id_tipo_licencia')
            ->where('vl.id_estado', 1) // Assuming 1 is Active
            ->get()
            ->filter(function ($licencia) {
                // Parse duration from 'tiempo' string, e.g., "12 Meses"
                $meses = (int) filter_var($licencia->tiempo, FILTER_SANITIZE_NUMBER_INT);
                if ($meses == 0)
                    $meses = 12; // Default
    
                $fechaFin = Carbon::parse($licencia->fecha_inicio)->addMonths($meses);
                return $fechaFin->diffInDays(now()) <= 30 && $fechaFin->isFuture();
            })
            ->count();


        // 2. Renovadas este mes (Purchased/Started this month)
        $renovadasEsteMes = VentaLicencias::whereMonth('fecha_inicio', Carbon::now()->month)
            ->whereYear('fecha_inicio', Carbon::now()->year)
            ->count();

        // 3. Total Licencias (Count of all licenses)
        $totalLicencias = DB::table('venta_licencias')->count();

        // --- DATA FOR FORMS ---
        $empresas = Empresa::all(); // For dropdowns
        $tiposLicencia = TipoLicencia::all();

        return view('SuperAdmin.dashboard', compact(
            'licenciasPorVencer',
            'renovadasEsteMes',
            'totalLicencias',
            'empresas',
            'tiposLicencia'
        ));
    }

    public function storeEmpresa(Request $request)
    {
        $request->validate([
            'id_empresa' => 'required|numeric|unique:empresa,id_empresa', // NIT
            'nombre_empresa' => 'required|string|max:200',
            'nombre_repre_legal' => 'required|string|max:100', // Added field
            'telefono' => 'required|string|max:12',
            'direccion' => 'required|string|max:150',
            'correo' => 'required|email|max:100|unique:empresa,correo',
        ]);

        $empresa = new Empresa();
        $empresa->id_empresa = $request->id_empresa;
        $empresa->nombre_empresa = $request->nombre_empresa;
        $empresa->nombre_repre_legal = $request->nombre_repre_legal;
        $empresa->telefono = $request->telefono;
        $empresa->direccion = $request->direccion;
        $empresa->correo = $request->correo;
        $empresa->fecha_creacion = now(); // Automatic date
        $empresa->id_estado = 1; // Pendiente
        $empresa->save();

        return redirect()->back()->with('success', 'Empresa creada exitosamente.');
    }

    public function storeLicencia(Request $request)
    {
        $request->validate([
            'id_empresa' => 'required|exists:empresa,id_empresa',
            'id_tipo_licencia' => 'required|exists:tipo_licencia,id_tipo_licencia',
        ]);

        // Calculate dates
        $tipoLicencia = TipoLicencia::find($request->id_tipo_licencia);
        $meses = (int) filter_var($tipoLicencia->tiempo, FILTER_SANITIZE_NUMBER_INT);
        if ($meses == 0)
            $meses = 12; // Fallback

        $fechaInicio = now();


        $empresa = Empresa::find($request->id_empresa);
        $estadoLicencia = 1; // Default to Pending

        if ($empresa) {

            if ($empresa->id_estado == 3) {
                $estadoLicencia = 3;
            }
        }

        DB::table('venta_licencias')->insert([
            'id_key' => \Illuminate\Support\Str::random(14),
            'fecha_inicio' => $fechaInicio,
            'observacione' => 'Asignada desde Dashboard',
            'id_empresa' => $request->id_empresa,
            'id_tipo_licencia' => $request->id_tipo_licencia,
            'id_estado' => $estadoLicencia
        ]);


        return redirect()->back()->with('success', 'Licencia asignada exitosamente.');
    }

    public function storeAdministrador(Request $request)
    {
        $request->validate([
            'documento' => 'required|numeric|unique:usuario,documento',
            'nombre' => 'required|string',
            'correo' => 'required|email|unique:usuario,correo',
            'telefono' => 'required|string',
            'contrasena' => 'required|min:6',
            'id_empresa' => 'required|exists:empresa,id_empresa',
            'imagen' => 'required|image|max:2048', // Image validation
        ]);

        // Handle Image Upload
        if ($request->hasFile('imagen')) {
            $imagePath = $request->file('imagen')->store('usuarios', 'public');
        } else {
            $imagePath = 'default.png';
        }

        // Determine admin status
        $empresa = Empresa::find($request->id_empresa);
        $estadoUsuario = 1; // Default: Pending

        if ($empresa && $empresa->id_estado == 3) {
            $estadoUsuario = 3; // Active if company is active
        }

        // Logic to create admin user
        DB::table('usuario')->insert([
            'documento' => $request->documento,
            'nombre' => $request->nombre,
            'correo' => $request->correo,
            'telefono' => $request->telefono,
            'contrasena' => Hash::make($request->contrasena),
            'id_empresa' => $request->id_empresa,
            'id_tipo_usuario' => 1, // Admin type
            'id_estado' => $estadoUsuario,
            'imagen' => $imagePath
        ]);

        return redirect()->back()->with('success', 'Administrador creado exitosamente.');
    }
}
