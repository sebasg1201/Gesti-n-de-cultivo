<?php

namespace App\Http\Controllers;

use App\Models\TipoSuelo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TipoSueloController extends Controller
{
    private function getEmpresaId()
    {
        return Auth::guard('usuario')->user()->id_empresa;
    }
    public function index()
    {
        $id_empresa = $this->getEmpresaId();
        $tipoSuelos = TipoSuelo::with('catalogo')
            ->where('id_empresa', $id_empresa)
            ->paginate(10);

        return view('admin.tipo_suelos.index', compact('tipoSuelos'));
    }

    public function catalog(Request $request)
    {
        $search = $request->get('q');
        $suelos = \App\Models\CatalogoSuelo::where('nombre', 'LIKE', "%{$search}%")->get();
        return response()->json($suelos);
    }

    public function store(Request $request)
    {
        $id_empresa = $this->getEmpresaId();
        $request->validate([
            'id_catalogo' => 'required|exists:catalogo_suelos,id',
            'nombre' => 'required|string|max:100',
        ]);

        $catalogItem = \App\Models\CatalogoSuelo::findOrFail($request->id_catalogo);

        // Check if already registered
        $exists = TipoSuelo::where('id_empresa', $id_empresa)
            ->where('id_catalogo', $catalogItem->id)
            ->exists();

        if ($exists) {
            return redirect()->back()->with('error', 'Este tipo de suelo ya está configurado en su empresa.');
        }

        TipoSuelo::create([
            'id_empresa' => $id_empresa,
            'id_catalogo' => $catalogItem->id,
            'nombre' => $request->nombre, // Custom farm name for soil
            'impacto_dias' => $catalogItem->impacto_dias, // STRICTLY from catalog
        ]);

        return redirect()->route('tipo_suelos.index')
            ->with('success', 'Suelo configurado correctamente.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
        ]);

        $tipoSuelo = TipoSuelo::where('id_tipo_suelo', $id)
            ->where('id_empresa', $this->getEmpresaId())
            ->firstOrFail();

        $tipoSuelo->update($request->all());

        return redirect()->route('tipo_suelos.index')
            ->with('success', 'Tipo de suelo actualizado correctamente');
    }

    public function destroy($id)
    {
        $tipoSuelo = TipoSuelo::where('id_tipo_suelo', $id)
            ->where('id_empresa', $this->getEmpresaId())
            ->firstOrFail();

        $tipoSuelo->delete();

        return redirect()->route('tipo_suelos.index')
            ->with('success', 'Tipo de suelo eliminado correctamente');
    }
}
