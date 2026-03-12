<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    public function index()
    {
        $usuario = auth()->guard('usuario')->user();

        if (!$usuario) {
            return redirect()->route('usuario.login');
        }

        // Si es supervisor (2) o trabajador (3), redirigir a su propio dashboard
        if (in_array($usuario->id_tipo_usuario, [2, 3])) {
            return redirect()->route('trabajador.dashboard');
        }

        $id_empresa = $usuario->id_empresa;

        $stats = [
            'cosechas' => \App\Models\Cosecha::where('id_empresa', $id_empresa)->count(),
            'riegos' => \App\Models\TipoRiego::count(),
            'semillas' => \App\Models\TipoSemilla::where('id_empresa', $id_empresa)->count(),
            'usuarios' => \App\Models\Usuario::where('id_empresa', $id_empresa)->count(),
        ];

        // Trabajos agrupados por estado
        $stats['trabajos_pendientes'] = \App\Models\FaseProgramada::whereHas('usuario', function ($q) use ($id_empresa) {
            $q->where('id_empresa', $id_empresa);
        })->where('id_estado', 1)->count(); // 1 = Pendiente

        $stats['trabajos_en_proceso'] = \App\Models\FaseProgramada::whereHas('usuario', function ($q) use ($id_empresa) {
            $q->where('id_empresa', $id_empresa);
        })->where('id_estado', 8)->count(); // 8 = En Proceso

        $stats['trabajos_realizados'] = \App\Models\FaseProgramada::whereHas('usuario', function ($q) use ($id_empresa) {
            $q->where('id_empresa', $id_empresa);
        })->where('id_estado', 9)->count(); // 9 = Realizado

        return view('admin.inicio', compact('stats'));
    }

    public function configuracion()
    {
        return view('admin.configuracion.index');
    }

    public function trabajadorInicio()
    {
        $usuario = auth()->guard('usuario')->user();

        // 1. Fase Programada
        $fases = \App\Models\FaseProgramada::with(['cosecha.semilla', 'cosecha.terreno.tipoSuelo'])
            ->where('documento_trabajador', $usuario->documento)
            ->get()->map(function($t) { $t->tipo_tarea = 'fase'; return $t; });

        // 2. Riego
        $riegos = \App\Models\Riego::with(['cosecha.semilla', 'cosecha.terreno.tipoSuelo', 'tipoRiego'])
            ->where('documento_trabajador', $usuario->documento)
            ->get()->map(function($t) { 
                $t->tipo_tarea = 'riego'; 
                $t->descripcion = $t->observaciones ?: ('Riego: ' . ($t->tipoRiego?->tipo_riego ?? 'General'));
                return $t; 
            });

        // 3. Insumos
        $insumos = \App\Models\InsumoCosecha::with(['cosecha.semilla', 'cosecha.terreno.tipoSuelo', 'insumo'])
            ->where('documento_trabajador', $usuario->documento)
            ->get()->map(function($t) { 
                $t->tipo_tarea = 'insumo'; 
                $t->descripcion = 'Aplicación de Insumo: ' . ($t->insumo?->Nombre ?? 'Desconocido');
                return $t; 
            });

        // Unificar y Agrupar
        $tareas = $fases->concat($riegos)->concat($insumos)
            ->sortBy('fecha_programada')
            ->groupBy('id_cosecha');

        return view('trabajadores.trabajador_dashboard', compact('tareas'));
    }

    public function finalizarTarea($id, $tipo)
    {
        $usuario = auth()->guard('usuario')->user();
        
        $model = $this->getTaskModel($tipo);
        $idField = $this->getTaskIdField($tipo);

        $tarea = $model::where($idField, $id)
            ->where('documento_trabajador', $usuario->documento)
            ->firstOrFail();

        $tarea->update(['id_estado' => 9]); // 9 = Realizado

        return redirect()->route('trabajador.dashboard')->with('success', 'Tarea marcada como finalizada correctamente.');
    }

    public function actualizarEstadoTarea(Request $request, $id, $tipo)
    {
        $usuario = auth()->guard('usuario')->user();

        $request->validate([
            'id_estado' => 'required|integer|in:1,8,9'
        ]);

        $model = $this->getTaskModel($tipo);
        $idField = $this->getTaskIdField($tipo);

        $tarea = $model::where($idField, $id)
            ->where('documento_trabajador', $usuario->documento)
            ->firstOrFail();

        $tarea->update(['id_estado' => $request->id_estado]);

        return redirect()->route('trabajador.dashboard')->with('success', 'Estado de la tarea actualizado correctamente.');
    }

    private function getTaskModel($tipo)
    {
        switch ($tipo) {
            case 'riego': return \App\Models\Riego::class;
            case 'insumo': return \App\Models\InsumoCosecha::class;
            default: return \App\Models\FaseProgramada::class;
        }
    }

    private function getTaskIdField($tipo)
    {
        switch ($tipo) {
            case 'riego': return 'id_riego';
            case 'insumo': return 'id_insumo_cosecha';
            default: return 'id_fase';
        }
    }

    public function tareasCategorizadas()
    {
        $usuario = auth()->guard('usuario')->user();
        $id_empresa = $usuario->id_empresa;

        // Fetch tasks linked to harvests of this company
        $riego = \App\Models\Riego::whereHas('cosecha', function ($q) use ($id_empresa) {
            $q->where('id_empresa', $id_empresa);
        })->with(['usuario', 'cosecha.semilla', 'tipoRiego'])->get();

        $insumoCosecha = \App\Models\InsumoCosecha::whereHas('cosecha', function ($q) use ($id_empresa) {
            $q->where('id_empresa', $id_empresa);
        })->with(['usuario', 'cosecha.semilla', 'insumo'])->get();

        // Standardize descripcion and type for the view
        foreach($riego as $t) {
            $t->tipo_referencia = 'riego';
            $t->descripcion = ($t->tipoRiego?->tipo_riego ?? 'Riego') . ": " . ($t->observaciones ?? 'Sin observaciones');
        }

        foreach($insumoCosecha as $t) {
            $t->tipo_referencia = 'insumo';
            $insumoNombre = $t->insumo?->Nombre ?? 'Insumo';
            $t->descripcion = "Aplicación: " . $insumoNombre . " (" . ($t->cantidad_usada ?? 0) . ")";
        }

        // Fases general: fetch those NOT linked to Riego or InsumoCosecha specifically by keyword 
        // to avoid duplication since store methods create double records.
        $general = \App\Models\FaseProgramada::whereHas('cosecha', function ($q) use ($id_empresa) {
            $q->where('id_empresa', $id_empresa);
        })->with(['usuario', 'cosecha.semilla'])
        ->get()
        ->map(function($t) {
            $t->tipo_referencia = 'general';
            return $t;
        })
        ->reject(function($t) {
            $desc = strtolower($t->descripcion);
            return str_contains($desc, 'riego') || str_contains($desc, 'insumo') || str_contains($desc, 'fertilizante') || str_contains($desc, 'fumigación') || str_contains($desc, 'abono');
        });

        // Dropdown data
        $trabajadores = \App\Models\Usuario::where('id_empresa', $id_empresa)
            ->where('id_tipo_usuario', 3)
            ->get();
        
        $cosechas = \App\Models\Cosecha::where('id_empresa', $id_empresa)
            ->with(['semilla', 'terreno'])
            ->get();

        $tiposRiego = \App\Models\TipoRiego::all();

        $catalogoInsumos = \App\Models\Insumo::where('id_empresa', $id_empresa)->get();

        return view('admin.tareas.index', compact('riego', 'insumoCosecha', 'general', 'trabajadores', 'cosechas', 'tiposRiego', 'catalogoInsumos'));
    }

    public function storeRiego(Request $request)
    {
        try {
            $request->validate([
                'id_cosecha' => 'required|exists:cosecha,id_cosecha',
                'documento_trabajador' => 'required|exists:usuario,documento',
                'id_tipo_riego' => 'required|exists:tipo_riego,id_tipo_riego',
                'cant_agua_apl' => 'required|numeric',
                'fecha_programada' => 'required|date',
                'observaciones' => 'nullable|string'
            ]);

            \App\Models\Riego::create([
                'id_cosecha' => $request->id_cosecha,
                'documento_trabajador' => $request->documento_trabajador,
                'id_tipo_riego' => $request->id_tipo_riego,
                'cant_agua_apl' => $request->cant_agua_apl,
                'fecha_programada' => $request->fecha_programada,
                'observaciones' => $request->observaciones ?? '',
                'id_estado' => 1
            ]);

            return redirect()->back()->with('success', 'Tarea de riego asignada correctamente.');
        } catch (\Exception $e) {
            Log::error("Error en storeRiego: " . $e->getMessage());
            return redirect()->back()->with('error', 'Error en base de datos: ' . $e->getMessage())->withInput();
        }
    }

    public function storeInsumo(Request $request)
    {
        try {
            $request->validate([
                'id_cosecha' => 'required|exists:cosecha,id_cosecha',
                'documento_trabajador' => 'required|exists:usuario,documento',
                'id_insumo' => 'required|exists:insumo,ID_insumo',
                'cantidad_usada' => 'required|numeric',
                'fecha_programada' => 'required|date'
            ]);

            $insumo = \App\Models\Insumo::find($request->id_insumo);

            \App\Models\InsumoCosecha::create([
                'id_cosecha' => $request->id_cosecha,
                'documento_trabajador' => $request->documento_trabajador,
                'id_insumo' => $request->id_insumo,
                'cantidad_usada' => $request->cantidad_usada,
                'fecha_programada' => $request->fecha_programada,
                'id_estado' => 1,
                'impacto_dias' => 0
            ]);

            return redirect()->back()->with('success', 'Tarea de insumo asignada correctamente.');
        } catch (\Exception $e) {
            Log::error("Error en storeInsumo: " . $e->getMessage());
            return redirect()->back()->with('error', 'Error en base de datos: ' . $e->getMessage())->withInput();
        }
    }

    public function storeGeneral(Request $request)
    {
        try {
            $request->validate([
                'descripcion' => 'required|string|max:255',
                'id_cosecha' => 'required|exists:cosecha,id_cosecha',
                'documento_trabajador' => 'required|exists:usuario,documento',
                'fecha_programada' => 'required|date'
            ]);

            \App\Models\FaseProgramada::create([
                'descripcion' => $request->descripcion,
                'fecha_programada' => $request->fecha_programada,
                'id_estado' => 1,
                'id_cosecha' => $request->id_cosecha,
                'documento_trabajador' => $request->documento_trabajador
            ]);

            return redirect()->back()->with('success', 'Fase programada asignada correctamente.');
        } catch (\Exception $e) {
            Log::error("Error en storeGeneral: " . $e->getMessage());
            return redirect()->back()->with('error', 'Error en base de datos: ' . $e->getMessage())->withInput();
        }
    }

    public function trabajadorCalendario()
    {
        return view('trabajadores.calendario');
    }

    public function getEventosCalendario()
    {
        $usuario = auth()->guard('usuario')->user();
        $eventos = [];

        // 1. Fase Programada
        $fases = \App\Models\FaseProgramada::with(['cosecha.semilla'])
            ->where('documento_trabajador', $usuario->documento)
            ->get();
        foreach ($fases as $fase) {
            $nombreCultivo = $fase->cosecha && $fase->cosecha->semilla 
                ? $fase->cosecha->semilla->nombre_semilla 
                : 'Cultivo';
            
            $resumenFase = $fase->cosecha && $fase->cosecha->semilla 
                ? $fase->cosecha->semilla->descripcion 
                : 'Realizar labores de mantenimiento para la fase de ' . $fase->descripcion;

            $eventos[] = [
                'id' => 'fase_' . $fase->id_fase,
                'title' => 'Fase: ' . $fase->descripcion,
                'start' => $fase->fecha_programada,
                'color' => $fase->id_estado == 9 ? '#10b981' : ($fase->id_estado == 8 ? '#f59e0b' : '#3b82f6'),
                'extendedProps' => [
                    'tipo' => 'fase',
                    'descripcion' => $fase->descripcion,
                    'cultivo' => $nombreCultivo,
                    'resumen' => $resumenFase,
                    'estado' => $fase->id_estado
                ]
            ];
        }

        // 2. Riego
        $riegos = \App\Models\Riego::where('documento_trabajador', $usuario->documento)->get();
        foreach ($riegos as $riego) {
            $eventos[] = [
                'id' => 'riego_' . $riego->id_riego,
                'title' => 'Riego: ' . ($riego->observaciones ?: 'Programado'),
                'start' => $riego->fecha_programada,
                'color' => '#0ea5e9',
                'extendedProps' => [
                    'tipo' => 'riego',
                    'descripcion' => $riego->observaciones,
                    'estado' => $riego->id_estado
                ]
            ];
        }

        // 3. Insumos
        $insumos = \App\Models\InsumoCosecha::with('insumo')->where('documento_trabajador', $usuario->documento)->get();
        foreach ($insumos as $insumo) {
            $eventos[] = [
                'id' => 'insumo_' . $insumo->id_insumo_cosecha,
                'title' => 'Insumo: ' . ($insumo->insumo->Nombre ?? 'Aplicación'),
                'start' => $insumo->fecha_programada,
                'color' => '#8b5cf6',
                'extendedProps' => [
                    'tipo' => 'insumo',
                    'descripcion' => 'Aplicación de ' . ($insumo->insumo->Nombre ?? 'insumo'),
                    'estado' => $insumo->id_estado
                ]
            ];
        }

        // 4. Días Trabajados (Marcados manualmente)
        $registros = \App\Models\RegistroTrabajo::where('documento_trabajador', $usuario->documento)->get();
        foreach ($registros as $reg) {
            $eventos[] = [
                'id' => 'registro_' . $reg->id_registro_trabajo,
                'title' => 'Día Trabajado',
                'start' => $reg->fecha_trabajada,
                'rendering' => 'background',
                'color' => '#dcfce7', // Un verde muy claro para el fondo
                'allDay' => true,
                'extendedProps' => [
                    'tipo' => 'registro',
                    'observacion' => $reg->observacion,
                    'foto_url' => $reg->foto_evidencia ? asset('uploads/' . $reg->foto_evidencia) : null
                ]
            ];
        }

        return response()->json($eventos);
    }

    public function storeRegistroTrabajo(Request $request)
    {
        $usuario = auth()->guard('usuario')->user();

        $request->validate([
            'fecha_trabajada' => 'required|date',
            'observacion' => 'nullable|string|max:500',
            'foto_evidencia' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048'
        ]);

        // Verificar si ya registró ese día
        $existe = \App\Models\RegistroTrabajo::where('documento_trabajador', $usuario->documento)
            ->where('fecha_trabajada', $request->fecha_trabajada)
            ->exists();

        if ($existe) {
            return response()->json(['error' => 'Ya has registrado trabajo para este día.'], 422);
        }

        $imagePath = null;
        if ($request->hasFile('foto_evidencia')) {
            $imagePath = $request->file('foto_evidencia')->store('evidencias', 'public');
        }

        \App\Models\RegistroTrabajo::create([
            'documento_trabajador' => $usuario->documento,
            'fecha_trabajada' => $request->fecha_trabajada,
            'observacion' => $request->observacion,
            'id_insumo_cosecha' => $request->id_insumo_cosecha ?? null,
            'estado_aprobacion' => 'pendiente',
            'foto_evidencia' => $imagePath
        ]);

        return response()->json(['success' => 'Día de trabajo registrado correctamente.']);
    }
}
