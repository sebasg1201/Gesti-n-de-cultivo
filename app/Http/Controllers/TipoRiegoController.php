<?php

namespace App\Http\Controllers;

use App\Models\TipoRiego;
use App\Models\CatalogoRiego;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TipoRiegoController extends Controller
{
    private function getEmpresaId()
    {
        return Auth::guard('usuario')->user()->id_empresa;
    }

    public function index()
    {
        $id_empresa = $this->getEmpresaId();
        $tipoRiegos = TipoRiego::with('catalogo')
            ->where('id_empresa', $id_empresa)
            ->paginate(10);

        return view('admin.tipo_riegos.index', compact('tipoRiegos'));
    }

    public function catalog(Request $request)
    {
        $search = $request->get('q');
        $riegos = CatalogoRiego::where('nombre', 'LIKE', "%{$search}%")->get();
        return response()->json($riegos);
    }

    public function store(Request $request)
    {
        $idEmpresa = $this->getEmpresaId();

        $request->validate([
            'id_catalogo' => 'required|exists:catalogo_riegos,id',
            'tipo_riego' => 'required|string|max:100',
        ]);

        // Fetch catalog item for data integrity
        $catalogItem = CatalogoRiego::findOrFail($request->id_catalogo);

        // Check already registered
        $exists = TipoRiego::where('id_empresa', $idEmpresa)
            ->where('id_catalogo', $request->id_catalogo)
            ->exists();

        if ($exists) {
            return redirect()->back()->with('error', 'Este sistema de riego ya está configurado en su catálogo de empresa.');
        }

        TipoRiego::create([
            'id_empresa' => $idEmpresa,
            'id_catalogo' => $request->id_catalogo,
            'tipo_riego' => $request->tipo_riego,
            'impacto_dias' => $catalogItem->impacto_dias, // FROM CATALOG
        ]);

        return redirect()->route('tipo_riegos.index')
            ->with('success', 'Sistema de riego habilitado correctamente.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tipo_riego' => 'required|string|max:100',
        ]);

        $tipoRiego = TipoRiego::where('id_tipo_riego', $id)
            ->where('id_empresa', $this->getEmpresaId())
            ->firstOrFail();

        $tipoRiego->update([
            'tipo_riego' => $request->tipo_riego,
        ]);

        return redirect()->route('tipo_riegos.index')
            ->with('success', 'Configuración de riego actualizada.');
    }

    public function destroy($id)
    {
        $tipoRiego = TipoRiego::where('id_tipo_riego', $id)
            ->where('id_empresa', $this->getEmpresaId())
            ->firstOrFail();

        $tipoRiego->delete();

        return redirect()->route('tipo_riegos.index')
            ->with('success', 'Sistema de riego eliminado correctamente.');
    }
}
