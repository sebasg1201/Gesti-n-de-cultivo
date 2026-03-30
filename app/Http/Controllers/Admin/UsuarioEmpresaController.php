<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Usuario;
use App\Models\TipoUsuario;
use App\Models\Cosecha;
use App\Models\FaseProgramada;
use App\Models\TipoCosecha;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Mail\WelcomeWorker;

class UsuarioEmpresaController extends Controller
{
    public function index()
    {
        $admin = Auth::guard('usuario')->user();

        // Obtener usuarios de la misma empresa que sean Supervisor (2) o Trabajador (3)
        $usuarios = Usuario::where('id_empresa', $admin->id_empresa)
            ->whereIn('id_tipo_usuario', [2, 3])
            ->paginate(10);

        return view('admin.usuarios.index', compact('usuarios'));
    }

    public function create()
    {
        // Solo permitir crear Supervisor (2) y Trabajador (3)
        $roles = TipoUsuario::whereIn('id_tipo_usuario', [2, 3])->get();
        return view('admin.usuarios.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $admin = Auth::guard('usuario')->user();

        $request->validate([
            'documento' => 'required|numeric|digits_between:6,10|unique:usuario,documento',
            'nombre' => 'required|string|max:150',
            'correo' => [
                'required',
                'email',
                'unique:usuario,correo',
                'regex:/^[a-zA-Z0-9._%+-]+@gmail\.com$/'
            ],
            'telefono' => 'required|numeric|regex:/^3\d{9}$/',
            'contrasena' => 'required|string|min:8',
            'id_tipo_usuario' => 'required|in:2,3',
            'imagen' => 'nullable|image|max:2048'
        ], [
            'correo.regex' => 'El correo debe ser de dominio @gmail.com (sin errores tipo "gmial").',
            'telefono.regex' => 'El teléfono debe tener 10 dígitos y empezar por 3.'
        ]);

        $imagePath = null;
        if ($request->hasFile('imagen')) {
            $imagePath = $request->file('imagen')->store('usuarios', 'public');
        }

        $usuario = Usuario::create([
            'documento' => $request->documento,
            'nombre' => $request->nombre,
            'correo' => $request->correo,
            'telefono' => $request->telefono,
            'contrasena' => Hash::make($request->contrasena),
            'id_tipo_usuario' => $request->id_tipo_usuario,
            'id_empresa' => $admin->id_empresa,
            'id_estado' => 1, // Activo por defecto
            'imagen' => $imagePath
        ]);

        // Enviar correo de bienvenida con PDF
        try {
            $pdf = Pdf::loadView('emails.welcome_worker_pdf', [
                'usuario' => $usuario,
                'password' => $request->contrasena
            ]);
            
            Mail::to($usuario->correo)->send(new WelcomeWorker($usuario, $request->contrasena, $pdf->output()));
        } catch (\Exception $e) {
            // Log error or notify admin, but don't stop the user creation process
            \Illuminate\Support\Facades\Log::error('Error enviando correo de bienvenida: ' . $e->getMessage());
        }

        return redirect()->route('admin.usuarios.index')->with('success', 'Usuario creado correctamente.');
    }

    public function edit($documento)
    {
        $admin = Auth::guard('usuario')->user();

        $usuario = Usuario::where('documento', $documento)
            ->where('id_empresa', $admin->id_empresa)
            ->whereIn('id_tipo_usuario', [2, 3])
            ->firstOrFail();

        $roles = TipoUsuario::whereIn('id_tipo_usuario', [2, 3])->get();
        $estados = \App\Models\Estado::whereIn('id_estado', [1, 3, 8])->get(); // Pendiente, Activa, Suspendido

        return view('admin.usuarios.edit', compact('usuario', 'roles', 'estados'));
    }

    public function update(Request $request, $documento)
    {
        $admin = Auth::guard('usuario')->user();

        $usuario = Usuario::where('documento', $documento)
            ->where('id_empresa', $admin->id_empresa)
            ->firstOrFail();

        $request->validate([
            'nombre' => 'required|string|max:150',
            'correo' => [
                'required',
                'email',
                'unique:usuario,correo,' . $usuario->documento . ',documento',
                'regex:/^[a-zA-Z0-9._%+-]+@gmail\.com$/'
            ],
            'telefono' => 'required|numeric|regex:/^3\d{9}$/',
            'id_tipo_usuario' => 'required|in:2,3',
            'id_estado' => 'required|exists:estado,id_estado',
            'imagen' => 'nullable|image|max:2048'
        ], [
            'correo.regex' => 'El correo debe ser de dominio @gmail.com (sin errores tipo "gmial").',
            'telefono.regex' => 'El teléfono debe tener 10 dígitos y empezar por 3.'
        ]);

        $data = $request->only(['nombre', 'correo', 'telefono', 'id_tipo_usuario', 'id_estado']);

        if ($request->filled('contrasena')) {
            $request->validate(['contrasena' => 'string|min:8']);
            $data['contrasena'] = Hash::make($request->contrasena);
        }

        if ($request->hasFile('imagen')) {
            if ($usuario->imagen) {
                Storage::disk('public')->delete($usuario->imagen);
            }
            $data['imagen'] = $request->file('imagen')->store('usuarios', 'public');
        }

        $usuario->update($data);

        return redirect()->route('admin.usuarios.index')->with('success', 'Usuario actualizado correctamente.');
    }

    public function destroy($documento)
    {
        $admin = Auth::guard('usuario')->user();

        $usuario = Usuario::where('documento', $documento)
            ->where('id_empresa', $admin->id_empresa)
            ->whereIn('id_tipo_usuario', [2, 3])
            ->firstOrFail();

        \Illuminate\Support\Facades\DB::transaction(function () use ($usuario) {
            // Eliminar registros relacionados para evitar errores de clave foránea
            \App\Models\FaseProgramada::where('documento_trabajador', $usuario->documento)->delete();
            \App\Models\Salario::where('documento_trabajador', $usuario->documento)->delete();
            \App\Models\Riego::where('documento_trabajador', $usuario->documento)->delete();
            \App\Models\InsumoCosecha::where('documento_trabajador', $usuario->documento)->delete();
            \App\Models\RegistroTrabajo::where('documento_trabajador', $usuario->documento)->delete();

            // Eliminar imagen si existe
            if ($usuario->imagen) {
                Storage::disk('public')->delete($usuario->imagen);
            }

            // Eliminar al usuario
            $usuario->delete();
        });

        return redirect()->route('admin.usuarios.index')->with('success', 'Usuario y sus tareas asociadas eliminados correctamente.');
    }

    public function asignarTrabajo($documento)
    {
        $admin = Auth::guard('usuario')->user();

        $usuario = Usuario::where('documento', $documento)
            ->where('id_empresa', $admin->id_empresa)
            ->whereIn('id_tipo_usuario', [2, 3])
            ->firstOrFail();

        // Tipos de salario disponibles
        $tiposSalario = \App\Models\TipoSalario::all();

        // Pagos/Salarios registrados para este usuario
        $salarios = \App\Models\Salario::where('documento_trabajador', $documento)
            ->with('tipoSalario')
            ->orderBy('fecha_pago', 'desc')
            ->get();

        // Obtener tareas asignadas (Fases, Riegos, Insumos)
        $fases = \App\Models\FaseProgramada::where('documento_trabajador', $documento)
            ->with(['terreno', 'estado'])
            ->get()
            ->map(function($item) {
                $item->tipo_actividad = 'Fase';
                $item->titulo = $item->descripcion;
                $item->fecha_prog = $item->fecha_programada;
                return $item;
            });

        $riegos = \App\Models\Riego::where('documento_trabajador', $documento)
            ->with(['cosecha.terreno', 'estado'])
            ->get()
            ->map(function($item) {
                $item->tipo_actividad = 'Riego';
                $item->titulo = 'Riego - ' . ($item->cosecha->terreno->nombre_terreno ?? 'N/A');
                $item->fecha_prog = $item->fecha_programada;
                return $item;
            });

        $insumosArr = \App\Models\InsumoCosecha::where('documento_trabajador', $documento)
            ->with(['cosecha.terreno', 'estado'])
            ->get()
            ->map(function($item) {
                $item->tipo_actividad = 'Insumo';
                $item->titulo = 'Aplicación de Insumo';
                $item->fecha_prog = $item->fecha_programada;
                return $item;
            });

        // Obtener registros de asistencia/evidencia
        $registros = \App\Models\RegistroTrabajo::where('documento_trabajador', $documento)
            ->orderBy('fecha_trabajada', 'desc')
            ->get();

        // Unificar actividades para la vista
        $actividades = collect()
            ->concat($fases)
            ->concat($riegos)
            ->concat($insumosArr)
            ->sortByDesc('fecha_prog');

        // Asociar evidencias por fecha y determinar cumplimiento
        foreach ($actividades as $act) {
            $matchingReg = $registros->first(function($reg) use ($act) {
                return $reg->fecha_trabajada == $act->fecha_prog;
            });

            if ($matchingReg) {
                $act->evidencia = $matchingReg;
                // Calculamos si fue a tiempo
                // Si es Insumo, tiene fecha_realizacion propia o usamos la del registro
                $fechaReal = $act->fecha_realizacion ?? $matchingReg->fecha_trabajada;
                $act->a_tiempo = strtotime($fechaReal) <= strtotime($act->fecha_prog);
            } else {
                $act->evidencia = null;
                $act->a_tiempo = null;
            }
        }

        return view('admin.usuarios.asignar_trabajo', compact('usuario', 'tiposSalario', 'salarios', 'actividades', 'registros'));
    }

    public function storeTrabajo(Request $request, $documento)
    {
        $admin = Auth::guard('usuario')->user();

        // Verificar que el usuario pertenece a la empresa
        $usuario = Usuario::where('documento', $documento)
            ->where('id_empresa', $admin->id_empresa)
            ->firstOrFail();

        $request->validate([
            'id_salario' => 'nullable|exists:salario,id_salario',
            'descripcion_pago' => 'nullable|string|max:255',
            'cantidad_pago' => 'required|numeric|min:0',
            'unidad_pago' => 'nullable|string|max:50',
            'id_tipo_salario' => 'nullable|exists:tipo_salario,id_tipo_salario',
        ]);

        if ($request->id_salario) {
            $salario = \App\Models\Salario::where('id_salario', $request->id_salario)
                ->where('documento_trabajador', $usuario->documento)
                ->firstOrFail();
            
            $salario->update([
                'descripcion_pago' => $request->descripcion_pago,
                'cantidad_pago' => $request->cantidad_pago,
                'unidad_pago' => $request->unidad_pago,
                'id_tipo_salario' => $request->id_tipo_salario
            ]);
            $mensaje = 'Pago actualizado exitosamente.';
        } else {
            \App\Models\Salario::create([
                'documento_trabajador' => $usuario->documento,
                'descripcion_pago' => $request->descripcion_pago,
                'cantidad_pago' => $request->cantidad_pago,
                'unidad_pago' => $request->unidad_pago,
                'fecha_pago' => now(),
                'estado' => 'activo',
                'id_tipo_salario' => $request->id_tipo_salario
            ]);
            $mensaje = 'Pago asignado exitosamente al trabajador.';
        }

        return redirect()->route('admin.usuarios.asignar_trabajo', $usuario->documento)
            ->with('success', $mensaje);
    }

    public function exportPagos($documento)
    {
        $admin = Auth::guard('usuario')->user();
        $usuario = Usuario::where('documento', $documento)
            ->where('id_empresa', $admin->id_empresa)
            ->firstOrFail();

        $salarios = \App\Models\Salario::where('documento_trabajador', $documento)
            ->with('tipoSalario')
            ->orderBy('fecha_pago', 'desc')
            ->get();

        $fileName = 'Reporte_Pagos_' . str_replace(' ', '_', $usuario->nombre) . '_' . date('Y-m-d') . '.csv';

        $headers = [
            "Content-type"        => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = ['ID Pago', 'Descripcion', 'Monto', 'Unidad', 'Tipo/Frecuencia', 'Estado', 'Fecha de Pago'];

        $callback = function() use($salarios, $columns) {
            $file = fopen('php://output', 'w');
            // Añadir BOM para que Excel detecte UTF-8
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            
            fputcsv($file, $columns, ';');

            foreach ($salarios as $salario) {
                fputcsv($file, [
                    $salario->id_salario,
                    $salario->descripcion_pago,
                    $salario->cantidad_pago,
                    $salario->unidad_pago,
                    $salario->tipoSalario ? $salario->tipoSalario->tipo_salario : 'General',
                    $salario->estado,
                    $salario->fecha_pago
                ], ';');
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
