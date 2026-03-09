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

        // Cambiar estado del terreno a "Ocupado" (id_estado = 8? por confirmar, pero el usuario no pidió esto aún)

        Cosecha::create([
            'id_empresa' => $id_empresa,
            'id_terreno' => $request->id_terreno,
            'id_semilla' => $request->id_semilla,
            'id_estado' => 1, // Default state
            'Cantidad' => $request->cantidad_sembrada,
            'fecha_siembra' => $request->fecha_siembra,
            'fecha_estimada' => $fechaEstimada->format('Y-m-d'),
            'produccion_estimada' => $request->cantidad_sembrada * $semilla->rendimiento_promedio,
            'imagenes' => $imagePath,
        ]);

        return redirect()->route('admin.cosechas.index')->with('success', 'Siembra iniciada correctamente.');
    }
}
