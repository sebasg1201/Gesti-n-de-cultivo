<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cosecha;
use App\Models\Terreno;
use App\Models\TipoSemilla;
use App\Models\Estado;
use App\Models\TipoRiego;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CosechaController extends Controller
{
    private function getEmpresaId()
    {
        return Auth::guard('usuario')->user()->id_empresa;
    }

    public function index()
    {
        $id_empresa = $this->getEmpresaId();

        $cosechas = Cosecha::where('id_empresa', $id_empresa)
            ->with(['terreno', 'semilla'])
            ->orderBy('id_cosecha', 'desc')
            ->paginate(10);

        $terrenos = Terreno::with('tipoSuelo')->where('id_empresa', $id_empresa)->where('id_estado', 7)->get(); // 7 = Disponible
        $semillas = TipoSemilla::where('id_empresa', $id_empresa)->get();
        $riegos = TipoRiego::where('id_empresa', $id_empresa)->get();

        return view('admin.cosechas.index', compact('cosechas', 'terrenos', 'semillas', 'riegos'));
    }

    public function store(Request $request)
    {
        $id_empresa = $this->getEmpresaId();

        $request->validate([
            'id_terreno' => 'required|exists:terreno,id_terreno',
            'id_semilla' => 'required|exists:tipo_semilla,id_semilla',
            'id_tipo_riego' => 'required|exists:tipo_riego,id_tipo_riego',
            'cantidad_sembrada' => 'required|numeric|min:1',
            'fecha_siembra' => 'required|date',
            'frecuencia_riego_dias' => 'required|integer|min:1',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $semilla = TipoSemilla::findOrFail($request->id_semilla);
        $terreno = Terreno::with('tipoSuelo')->findOrFail($request->id_terreno);
        $riego = TipoRiego::findOrFail($request->id_tipo_riego);

        $imagePath = null;
        if ($request->hasFile('imagen')) {
            $imagePath = $request->file('imagen')->store('cosechas', 'public');
        }

        $baseDays = $semilla->tiempo_base_dias ?? 0;
        $soilImpact = $terreno->tipoSuelo ? $terreno->tipoSuelo->impacto_dias : 0;
        $irrigationImpact = $riego->impacto_dias ?? 0;

        $totalDays = $baseDays + $soilImpact + $irrigationImpact;

        $fechaEstimada = \Carbon\Carbon::parse($request->fecha_siembra)->addDays($totalDays);

        // Calculate Ideal Water amount per cycle
        // formula: area_m2 * consumo_agua_ideal
        $area = $terreno->area_m2 ?? 0; // if area is not configured, water amount defaults to 0
        $consumoIdeal = $terreno->tipoSuelo ? ($terreno->tipoSuelo->consumo_agua_ideal ?? 0) : 0;
        $aguaPorRiego = $area * $consumoIdeal;

        $cosecha = Cosecha::create([
            'id_empresa' => $id_empresa,
            'id_terreno' => $request->id_terreno,
            'id_semilla' => $request->id_semilla,
            'id_estado' => 1, // Default state
            'Cantidad' => $request->cantidad_sembrada,
            'fecha_siembra' => $request->fecha_siembra,
            'frecuencia_riego_dias' => $request->frecuencia_riego_dias,
            'fecha_estimada' => $fechaEstimada->format('Y-m-d'),
            'produccion_estimada' => $request->cantidad_sembrada * $semilla->rendimiento_promedio,
            'imagenes' => $imagePath,
        ]);

        // Automated Task Generation logic
        if ($totalDays > 0) {
            $frecuencia = $request->frecuencia_riego_dias;
            $fecha_actual_bucle = \Carbon\Carbon::parse($request->fecha_siembra);
            
            // Loop until we reach fechaEstimada
            while ($fecha_actual_bucle->lessThanOrEqualTo($fechaEstimada)) {
                // Determine appropriate state (e.g. 1 = Pending)
                // Need to use default state for Riego. According to schema, if state table handles it, typically '1' represents pending.
                // Looking at standard system logic, typically pending jobs are id_estado = 1
                \App\Models\Riego::create([
                    'cant_agua_apl' => $aguaPorRiego,
                    'id_tipo_riego' => $request->id_tipo_riego,
                    'id_cosecha' => $cosecha->id_cosecha,
                    'id_estado' => 1, // 1 = Pendiente
                    'fecha_programada' => $fecha_actual_bucle->format('Y-m-d')
                ]);

                $fecha_actual_bucle->addDays($frecuencia);
            }
        }

        return redirect()->route('admin.cosechas.index')->with('success', 'Siembra iniciada y tareas de riego automáticas generadas.');
    }

    public function show($id)
    {
        $id_empresa = $this->getEmpresaId();

        $cosecha = Cosecha::where('id_empresa', $id_empresa)
            ->with(['terreno', 'terreno.tipoSuelo', 'semilla'])
            ->findOrFail($id);

        $fechaSiembra = \Carbon\Carbon::parse($cosecha->fecha_siembra);
        $fechaEstimada = $cosecha->fecha_estimada ? \Carbon\Carbon::parse($cosecha->fecha_estimada) : null;

        $now = \Carbon\Carbon::now();

        $diasTotales = 0;
        $diasTranscurridos = 0;
        $porcentaje = 0;
        $diasRestantes = 0;

        if ($fechaEstimada) {
            $diasTotales = $fechaSiembra->diffInDays($fechaEstimada);
            $diasTranscurridos = $fechaSiembra->diffInDays($now, false); // false para permitir negativos si la siembra es futura

            if ($diasTranscurridos < 0) {
                $diasTranscurridos = 0;
            }

            $porcentaje = $diasTotales > 0 ? ($diasTranscurridos / $diasTotales) * 100 : 0;

            if ($porcentaje > 100) {
                $porcentaje = 100;
            }

            $diasRestantes = $now->diffInDays($fechaEstimada, false);
        }

        // Determinar fase actual basada en porcentaje (Aproximación general)
        $faseActual = 'Siembra';
        if ($porcentaje >= 20 && $porcentaje < 50)
            $faseActual = 'Vegetativo';
        elseif ($porcentaje >= 50 && $porcentaje < 75)
            $faseActual = 'Floración';
        elseif ($porcentaje >= 75 && $porcentaje < 90)
            $faseActual = 'Llenado de Grano';
        elseif ($porcentaje >= 90)
            $faseActual = 'Cosecha';

        // Calcular cumplimiento de hidratación (Barra Azul - Progreso Ciclo)
        $riegos = \App\Models\Riego::where('id_cosecha', $id)->get();
        $totalRiegosCiclo = $riegos->count();
        $riegosCompletados = $riegos->filter(function ($riego) {
            return $riego->id_estado != 1; // 1 = Pendiente
        })->count();

        $porcentajeHidratacion = $totalRiegosCiclo > 0 
            ? ($riegosCompletados / $totalRiegosCiclo) * 100 
            : 0;
            
        return view('admin.cosechas.show', compact('cosecha', 'diasTotales', 'diasTranscurridos', 'porcentaje', 'diasRestantes', 'faseActual', 'porcentajeHidratacion', 'riegosCompletados', 'totalRiegosCiclo'));
    }
}
