<?php

namespace App\Http\Controllers;

use App\Models\Insumo;
use App\Models\CatalogoInsumo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class InsumoController extends Controller
{
    private function getEmpresaId()
    {
        return Auth::guard('usuario')->user()->id_empresa;
    }

    public function index()
    {
        $id_empresa = $this->getEmpresaId();

        $insumos = Insumo::with(['catalogo.tipoInsumo'])
            ->where('id_empresa', $id_empresa)
            ->paginate(10);

        $tiposInsumo = \App\Models\TipoInsumo::all();

        return view('admin.insumos.index', compact('insumos', 'tiposInsumo'));
    }

    public function catalog(Request $request)
    {
        $search = $request->get('q');

        $insumosCatalogo = CatalogoInsumo::with('tipoInsumo')
            ->where('nombre_comercial', 'LIKE', "%{$search}%")
            ->orWhere('descripcion', 'LIKE', "%{$search}%")
            ->get();

        return response()->json($insumosCatalogo);
    }

    public function store(Request $request)
    {
        $idEmpresa = $this->getEmpresaId();

        $request->validate([
            'id_catalogo_insumo' => 'nullable|exists:catalogo_insumos,id_catalogo_insumo',
            'nombre' => 'required|string|max:100',
            'descripcion' => 'nullable|string|max:250',
            'categoria_manual' => 'nullable|exists:tipo_insumo,id_tipo_insumo',
            'impacto_dias' => 'nullable|integer',
        ]);

        if ($request->filled('id_catalogo_insumo')) {
            $exists = Insumo::where('id_empresa', $idEmpresa)
                ->where('id_catalogo_insumo', $request->id_catalogo_insumo)
                ->exists();

            if ($exists) {
                return redirect()->back()->with('error', 'Este insumo ya está registrado en su inventario.');
            }
        }
        
        Insumo::create([
            'id_empresa' => $idEmpresa,
            'id_catalogo_insumo' => $request->id_catalogo_insumo ?: null,
            'Nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'impacto_dias' => $request->impacto_dias ?? 0,
            'stock_actual' => 0,
            'cantidad_stock' => 0,
        ]);

        return redirect()->route('insumos.index')
            ->with('success', 'Insumo configurado y añadido a su inventario (con stock inicial de 0).');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'descripcion' => 'nullable|string|max:250',
            'impacto_dias' => 'nullable|integer',
        ]);

        $insumo = Insumo::where('ID_insumo', $id)
            ->where('id_empresa', $this->getEmpresaId())
            ->firstOrFail();

        $insumo->update([
            'Nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'impacto_dias' => $request->impacto_dias ?? 0,
        ]);

        return redirect()->route('insumos.index')
            ->with('success', 'Información del insumo actualizada.');
    }

    public function destroy($id)
    {
        $insumo = Insumo::where('ID_insumo', $id)
            ->where('id_empresa', $this->getEmpresaId())
            ->firstOrFail();

        $insumo->delete();

        return redirect()->route('insumos.index')
            ->with('success', 'Insumo eliminado de su inventario correctamente.');
    }
}
