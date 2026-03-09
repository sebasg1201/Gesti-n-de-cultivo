<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cosecha;
use App\Models\Terreno;
use App\Models\TipoSemilla;
use App\Models\Estado;
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

        $terrenos = Terreno::where('id_empresa', $id_empresa)->where('id_estado', 7)->get(); // 7 = Disponible
        $semillas = TipoSemilla::where('id_empresa', $id_empresa)->get();

        return view('admin.cosechas.index', compact('cosechas', 'terrenos', 'semillas'));
    }

    public function store(Request $request)
    {
        $id_empresa = $this->getEmpresaId();

        $request->validate([
            'id_terreno' => 'required|exists:terreno,id_terreno',
            'id_semilla' => 'required|exists:tipo_semilla,id_semilla',
            'cantidad_sembrada' => 'required|numeric|min:1',
            'fecha_siembra' => 'required|date',
        ]);

        $semilla = TipoSemilla::findOrFail($request->id_semilla);
        $terreno = Terreno::findOrFail($request->id_terreno);

        // Cambiar estado del terreno a "Ocupado" (id_estado = 8? por confirmar, pero el usuario no pidió esto aún)

        Cosecha::create([
            'id_empresa' => $id_empresa,
            'id_terreno' => $request->id_terreno,
            'id_semilla' => $request->id_semilla,
            'id_estado' => 1, // Default state
            'Cantidad' => $request->cantidad_sembrada,
            'fecha_siembra' => $request->fecha_siembra,
            'produccion_estimada' => $request->cantidad_sembrada * $semilla->rendimiento_promedio,
        ]);

        return redirect()->route('admin.cosechas.index')->with('success', 'Siembra iniciada correctamente.');
    }
}
