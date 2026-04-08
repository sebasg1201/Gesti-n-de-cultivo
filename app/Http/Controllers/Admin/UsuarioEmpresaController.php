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
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

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

        // VALIDACIÓN DE HISTORIAL: No permitir borrar si ya tiene actividad
        $tieneFases = \App\Models\FaseProgramada::where('documento_trabajador', $usuario->documento)->exists();
        $tieneSalarios = \App\Models\Salario::where('documento_trabajador', $usuario->documento)->exists();
        $tieneRiegos = \App\Models\Riego::where('documento_trabajador', $usuario->documento)->exists();
        $tieneInsumos = \App\Models\InsumoCosecha::where('documento_trabajador', $usuario->documento)->exists();
        $tieneRegistros = \App\Models\RegistroTrabajo::where('documento_trabajador', $usuario->documento)->exists();
        $tieneCosechas = \App\Models\Cultivo::where('documento_trabajador', $usuario->documento)->exists();

        if ($tieneFases || $tieneSalarios || $tieneRiegos || $tieneInsumos || $tieneRegistros || $tieneCosechas) {
            return redirect()->back()->with('error', 'No se puede eliminar a este trabajador porque ya tiene un historial de actividades, pagos o registros en la finca. Para darlo de baja, por favor cambia su estado a "Suspendido" en la opción de Editar.');
        }

        \Illuminate\Support\Facades\DB::transaction(function () use ($usuario) {
            // Solo se llega aquí si NO tiene historial (por seguridad adicional mantenemos el clean-up por si hay algo huérfano)
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

        // Pagos/Salarios registrados para este usuario (Paginados)
        $salarios = \App\Models\Salario::where('documento_trabajador', $documento)
            ->with('tipoSalario')
            ->orderBy('fecha_pago', 'desc')
            ->paginate(7, ['*'], 'page_salarios');

        // Obtener tareas asignadas (Fases, Riegos, Insumos) con su evidencia
        $fases = \App\Models\FaseProgramada::where('documento_trabajador', $documento)
            ->with(['terreno', 'estado', 'registroTrabajo'])
            ->get()
            ->map(function ($item) {
                $item->tipo_actividad = 'Fase';
                // Limpiar descripción de metadatos técnicos entre corchetes
                $descLimpia = trim(explode('[', $item->descripcion)[0]);
                $item->titulo = $descLimpia;
                $item->descripcion = $descLimpia;
                $item->fecha_prog = $item->fecha_programada;
                return $item;
            });

        $riegos = \App\Models\Riego::where('documento_trabajador', $documento)
            ->with(['cosecha.terreno', 'estado', 'registroTrabajo'])
            ->get()
            ->map(function ($item) {
                $item->tipo_actividad = 'Riego';
                $terreno = $item->cosecha->terreno->nombre_terreno ?? 'Área de Cultivo';
                $item->titulo = "Riego - $terreno";
                $item->fecha_prog = $item->fecha_programada;
                return $item;
            });

        $insumosArr = \App\Models\InsumoCosecha::where('documento_trabajador', $documento)
            ->with(['cosecha.terreno', 'estado', 'registroTrabajo'])
            ->get()
            ->map(function ($item) {
                $item->tipo_actividad = 'Insumo';
                $terreno = $item->cosecha->terreno->nombre_terreno ?? 'Lote General';
                $item->titulo = "Aplicación de Insumo - $terreno";
                $item->fecha_prog = $item->fecha_programada;
                return $item;
            });

        // Unificar actividades
        $allActividades = collect()
            ->concat($fases)
            ->concat($riegos)
            ->concat($insumosArr)
            ->sortByDesc(function ($item) {
                return $item->fecha_prog;
            });

        foreach ($allActividades as $act) {
            // Asignar evidencia directamente desde la relación
            $act->evidencia = $act->registroTrabajo;

            if ($act->evidencia) {
                // Calcular si fue a tiempo comparando fecha de reporte vs fecha programada
                $fechaReal = $act->evidencia->fecha_trabajada;
                $act->a_tiempo = strtotime($fechaReal) <= strtotime($act->fecha_prog);
            } else {
                $act->a_tiempo = null;
            }
        }

        // Paginación Manual para la colección combinada
        $perPage = 7;
        $currentPage = Paginator::resolveCurrentPage('page_actividades');
        $items = $allActividades->slice(($currentPage - 1) * $perPage, $perPage)->all();

        $actividades = new LengthAwarePaginator($items, $allActividades->count(), $perPage, $currentPage, [
            'path' => Paginator::resolveCurrentPath(),
            'query' => request()->query(),
            'pageName' => 'page_actividades'
        ]);

        return view('admin.usuarios.asignar_trabajo', compact('usuario', 'tiposSalario', 'salarios', 'actividades'));
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
            'selected_tasks' => $request->id_salario ? 'nullable|string' : 'required|string', // Requerido para pagos nuevos
        ]);

        return \Illuminate\Support\Facades\DB::transaction(function () use ($request, $usuario) {
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
                $salario = \App\Models\Salario::create([
                    'documento_trabajador' => $usuario->documento,
                    'descripcion_pago' => $request->descripcion_pago,
                    'cantidad_pago' => $request->cantidad_pago,
                    'unidad_pago' => $request->unidad_pago,
                    'fecha_pago' => now(),
                    'estado' => 'activo',
                    'id_tipo_salario' => $request->id_tipo_salario,
                    'visto_trabajador' => 0 // Asegurar que sea no visto
                ]);
                $mensaje = 'Pago asignado exitosamente al trabajador.';
            }

            // Procesar tareas seleccionadas si hay alguna
            if ($request->filled('selected_tasks')) {
                $tasks = json_decode($request->selected_tasks, true);
                if (is_array($tasks)) {
                    $countLinked = 0;
                    foreach ($tasks as $task) {
                        $taskId = $task['id'] ?? null;
                        $taskType = $task['type'] ?? null;

                        if ($taskId && $taskType) {
                            // Solo vincular si no tiene ya un id_salario (o si es el mismo salario actual)
                            switch ($taskType) {
                                case 'Fase':
                                    $affected = \App\Models\FaseProgramada::where('id_fase_programada', $taskId)
                                        ->where(function ($q) use ($salario) {
                                            $q->whereNull('id_salario')->orWhere('id_salario', $salario->id_salario);
                                        })
                                        ->update(['id_salario' => $salario->id_salario]);
                                    if ($affected) $countLinked++;
                                    break;
                                case 'Riego':
                                    $affected = \App\Models\Riego::where('id_riego', $taskId)
                                        ->where(function ($q) use ($salario) {
                                            $q->whereNull('id_salario')->orWhere('id_salario', $salario->id_salario);
                                        })
                                        ->update(['id_salario' => $salario->id_salario]);
                                    if ($affected) $countLinked++;
                                    break;
                                case 'Insumo':
                                    $affected = \App\Models\InsumoCosecha::where('id_insumo_cosecha', $taskId)
                                        ->where(function ($q) use ($salario) {
                                            $q->whereNull('id_salario')->orWhere('id_salario', $salario->id_salario);
                                        })
                                        ->update(['id_salario' => $salario->id_salario]);
                                    if ($affected) $countLinked++;
                                    break;
                            }
                        }
                    }
                    if ($countLinked > 0) {
                        $mensaje .= ' Se vincularon ' . $countLinked . ' tareas al pago.';
                    }
                }
            }

            return redirect()->back()->with('success', $mensaje);
        });
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

        $callback = function () use ($salarios, $columns) {
            $file = fopen('php://output', 'w');
            // Añadir BOM para que Excel detecte UTF-8
            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));

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
