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
        // Show types belonging to this company OR those that are global (id_empresa NULL)
        $tipoInsumos = TipoInsumo::where(function($query) use ($id_empresa) {
                $query->where('id_empresa', $id_empresa)
                      ->orWhereNull('id_empresa');
            })
            ->paginate(10);

        return view('admin.tipo_insumos.index', compact('tipoInsumos'));
    }

    public function store(Request $request)
    {
        $idEmpresa = $this->getEmpresaId();

        $request->validate([
            'nombre' => 'required|string|max:50',
        ]);

        $exists = TipoInsumo::where('nombre', $request->nombre)
            ->where(function($query) use ($idEmpresa) {
                $query->where('id_empresa', $idEmpresa)
                      ->orWhereNull('id_empresa');
            })
            ->exists();

        if ($exists) {
            return redirect()->back()->with('error', 'Este tipo de insumo ya existe.');
        }

        TipoInsumo::create([
            'id_empresa' => $idEmpresa,
            'nombre' => $request->nombre,
        ]);

        return redirect()->route('tipo_insumos.index')
            ->with('success', 'Tipo de insumo creado correctamente.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:50',
        ]);

        $tipoInsumo = TipoInsumo::where('id_tipo_insumo', $id)
            ->where('id_empresa', $this->getEmpresaId())
            ->firstOrFail();

        $tipoInsumo->update([
            'nombre' => $request->nombre,
        ]);

        return redirect()->route('tipo_insumos.index')
            ->with('success', 'Tipo de insumo actualizado.');
    }

    public function destroy($id)
    {
        $tipoInsumo = TipoInsumo::where('id_tipo_insumo', $id)
            ->where('id_empresa', $this->getEmpresaId())
            ->firstOrFail();

        // Verificar si hay elementos en el catálogo global vinculados a este tipo
        $contadorCatalogos = $tipoInsumo->catalogos()->count();
        if ($contadorCatalogos > 0) {
            return redirect()->route('tipo_insumos.index')
                ->with('error', "No se puede eliminar la categoría. Existen $contadorCatalogos producto(s) en el catálogo global registrados bajo este tipo.");
        }

        try {
            $tipoInsumo->delete();
            return redirect()->route('tipo_insumos.index')
                ->with('success', 'Categoría de insumo eliminada correctamente.');
        } catch (\Exception $e) {
            return redirect()->route('tipo_insumos.index')
                ->with('error', 'No se pudo eliminar la categoría debido a una restricción de registros asociados.');
        }
    }
}
