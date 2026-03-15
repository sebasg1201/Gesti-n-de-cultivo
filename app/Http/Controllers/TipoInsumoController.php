<?php

namespace App\Http\Controllers;

use App\Models\TipoInsumo;
use App\Models\CatalogoInsumo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TipoInsumoController extends Controller
{
    private function getEmpresaId()
    {
        return Auth::guard('usuario')->user()->id_empresa;
    }

    public function index()
    {
        $id_empresa = $this->getEmpresaId();
        $tipoInsumos = TipoInsumo::with('catalogo')
            ->where('id_empresa', $id_empresa)
            ->paginate(10);

        return view('admin.tipo_insumos.index', compact('tipoInsumos'));
    }

    public function catalog(Request $request)
    {
        $search = $request->get('q');
        $items = CatalogoInsumo::where('nombre', 'LIKE', "%{$search}%")->get();
        return response()->json($items);
    }

    public function store(Request $request)
    {
        $idEmpresa = $this->getEmpresaId();

        $request->validate([
            'id_catalogo' => 'nullable|exists:catalogo_insumos,id',
            'nombre_insumo' => 'required|string|max:100',
            'descripcion' => 'nullable|string|max:250',
        ]);

        if ($request->filled('id_catalogo')) {
            $exists = TipoInsumo::where('id_empresa', $idEmpresa)
                ->where('id_catalogo', $request->id_catalogo)
                ->exists();

            if ($exists) {
                return redirect()->back()->with('error', 'Este tipo de insumo ya está registrado en su catálogo.');
            }
        } else {
            $exists = TipoInsumo::where('id_empresa', $idEmpresa)
                ->where('nombre_insumo', $request->nombre_insumo)
                ->exists();

            if ($exists) {
                return redirect()->back()->with('error', 'Ya exite un insumo personalizado registrado con este nombre.');
            }
        }

        TipoInsumo::create([
            'id_empresa' => $idEmpresa,
            'id_catalogo' => $request->id_catalogo ?: null,
            'nombre_insumo' => $request->nombre_insumo,
            'descripcion' => $request->descripcion,
        ]);

        return redirect()->route('admin.tipo_insumos.index')
            ->with('success', 'Tipo de insumo configurado y habilitado correctamente.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre_insumo' => 'required|string|max:100',
            'descripcion' => 'required|string|max:250',
        ]);

        $tipoInsumo = TipoInsumo::where('id_tipo_insumo', $id)
            ->where('id_empresa', $this->getEmpresaId())
            ->firstOrFail();

        $tipoInsumo->update([
            'nombre_insumo' => $request->nombre_insumo,
            'descripcion' => $request->descripcion,
        ]);

        return redirect()->route('tipo_insumos.index')
            ->with('success', 'Información del tipo de insumo actualizada.');
    }

    public function destroy($id)
    {
        $tipoInsumo = TipoInsumo::where('id_tipo_insumo', $id)
            ->where('id_empresa', $this->getEmpresaId())
            ->firstOrFail();

        // Optional: Check if the type is being used by any supply before deleting to prevent integrity issues.
        if ($tipoInsumo->insumos()->count() > 0) {
            return redirect()->route('tipo_insumos.index')
                ->with('error', 'No se puede eliminar el tipo de insumo porque actualmente está asignado a uno o más insumos registrados.');
        }

        $tipoInsumo->delete();

        return redirect()->route('tipo_insumos.index')
            ->with('success', 'Tipo de insumo eliminado de su catálogo correctamente.');
    }
}
