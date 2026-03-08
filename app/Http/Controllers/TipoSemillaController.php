<?php

namespace App\Http\Controllers;

use App\Models\TipoSemilla;
use App\Models\CatalogoSemilla;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TipoSemillaController extends Controller
{
    private function getEmpresaId()
    {
        return Auth::guard('usuario')->user()->id_empresa;
    }

    public function index()
    {
        $id_empresa = auth()->guard('usuario')->user()->id_empresa;
        $tipoSemillas = TipoSemilla::with('catalogo')
            ->where('id_empresa', $id_empresa)
            ->paginate(10);

        return view('admin.tipo_semillas.index', compact('tipoSemillas'));
    }

    public function catalog(Request $request)
    {
        $search = $request->get('q');
        $seeds = CatalogoSemilla::where('nombre', 'LIKE', "%{$search}%")->get();
        return response()->json($seeds);
    }

    public function store(Request $request)
    {
        $idEmpresa = $this->getEmpresaId();

        $request->validate([
            'id_catalogo' => 'required|exists:catalogo_semillas,id',
            'nombre_semilla' => 'required|string|max:100',
            'descripcion' => 'nullable|string|max:250',
        ]);

        $catalogItem = CatalogoSemilla::findOrFail($request->id_catalogo);
        $id_empresa = auth()->guard('usuario')->user()->id_empresa;

        $exists = TipoSemilla::where('id_empresa', $id_empresa)
            ->where('id_catalogo', $catalogItem->id)
            ->exists();

        if ($exists) {
            return redirect()->back()->with('error', 'Esta variedad de semilla ya está registrada en su inventario.');
        }

        TipoSemilla::create([
            'id_empresa' => $id_empresa,
            'id_catalogo' => $catalogItem->id,
            'nombre_semilla' => $request->nombre_semilla,
            'tiempo_base_dias' => $catalogItem->tiempo_base_dias, // PREDETERMINADO
            'descripcion' => $request->descripcion ?? $catalogItem->descripcion,
            'rendimiento_promedio' => $catalogItem->rendimiento_promedio, // PREDETERMINADO
        ]);

        return redirect()->route('tipo_semillas.index')
            ->with('success', 'Semilla configurada y añadida correctamente.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre_semilla' => 'required|string|max:100',
            'descripcion' => 'required|string|max:250',
        ]);

        $tipoSemilla = TipoSemilla::findOrFail($id);

        // Only allow updating custom name and description
        $tipoSemilla->update([
            'nombre_semilla' => $request->nombre_semilla,
            'descripcion' => $request->descripcion,
        ]);

        return redirect()->route('tipo_semillas.index')
            ->with('success', 'Información de la semilla actualizada.');
    }

    public function destroy($id)
    {
        $tipoSemilla = TipoSemilla::where('id_semilla', $id)
            ->where('id_empresa', $this->getEmpresaId())
            ->firstOrFail();

        $tipoSemilla->delete();

        return redirect()->route('tipo_semillas.index')
            ->with('success', 'Semilla eliminada de su catálogo correctamente.');
    }
}
