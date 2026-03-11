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

        // Cambiar automáticamente estado Pendiente a En Progreso
        \App\Models\FaseProgramada::where('documento_trabajador', $usuario->documento)
            ->where('id_estado', 1) // 1 = Pendiente
            ->update(['id_estado' => 8]); // 8 = En Proceso

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

            \App\Models\FaseProgramada::create([
                'descripcion' => 'Riego: ' . ($request->observaciones ?? ''),
                'fecha_programada' => $request->fecha_programada,
                'id_estado' => 1,
                'id_cosecha' => $request->id_cosecha,
                'documento_trabajador' => $request->documento_trabajador
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

            \App\Models\FaseProgramada::create([
                'descripcion' => 'Aplicación de Insumo: ' . ($insumo->Nombre ?? 'N/A'),
                'fecha_programada' => $request->fecha_programada,
                'id_estado' => 1,
                'id_cosecha' => $request->id_cosecha,
                'documento_trabajador' => $request->documento_trabajador
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
}
