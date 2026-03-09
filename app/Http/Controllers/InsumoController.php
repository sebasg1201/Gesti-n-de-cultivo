<?php

namespace App\Http\Controllers;

use App\Models\Insumo;
use App\Models\Proveedor;
use App\Models\TipoInsumo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InsumoController extends Controller
{
    private function getEmpresaId()
    {
        return Auth::guard('usuario')->user()->id_empresa;
    }

    public function index(Request $request)
    {
        $id_empresa = $this->getEmpresaId();
        $query = Insumo::where('id_empresa', $id_empresa)->with(['proveedor', 'tipo']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('Nombre', 'like', "%{$search}%")
                    ->orWhereHas('tipo', function ($qTipo) use ($search) {
                        $qTipo->where('nombre_insumo', 'like', "%{$search}%");
                    })
                    ->orWhere('Calidad', 'like', "%{$search}%")
                    ->orWhere('descripcion', 'like', "%{$search}%");
            });
        }

        $insumos = $query->orderBy('ID_insumo', 'desc')->paginate(10);
        $proveedores = Proveedor::where('id_empresa', $id_empresa)->get();

        return view('admin.insumos.index', compact('insumos', 'proveedores'));
    }

    public function create()
    {
        $id_empresa = $this->getEmpresaId();
        $proveedores = Proveedor::where('id_empresa', $id_empresa)->get();
        $tiposInsumo = TipoInsumo::where('id_empresa', $id_empresa)->get();
        return view('admin.insumos.create', compact('proveedores', 'tiposInsumo'));
    }

    public function store(Request $request)
    {
        $id_empresa = $this->getEmpresaId();

        $request->validate([
            'Nombre' => 'required|string|max:255',
            'id_tipo_insumo' => 'required|exists:tipo_insumo,id_tipo_insumo',
            'Calidad' => 'nullable|string|max:255',
            'cantidad_stock' => 'required|numeric|min:0',
            'Fecha_ingreso' => 'nullable|date',
            'Fecha_vencimiento' => 'nullable|date',
            'descripcion' => 'nullable|string',
            'id_proveedor' => 'nullable|exists:proveedor,id_proveedor',
        ]);

        Insumo::create([
            'Nombre' => $request->Nombre,
            'id_tipo_insumo' => $request->id_tipo_insumo,
            'Calidad' => $request->Calidad,
            'cantidad_stock' => $request->cantidad_stock,
            'Fecha_ingreso' => $request->Fecha_ingreso,
            'Fecha_vencimiento' => $request->Fecha_vencimiento,
            'descripcion' => $request->descripcion,
            'id_proveedor' => $request->id_proveedor,
            'id_empresa' => $id_empresa,
        ]);

        return redirect()->route('admin.insumos.index')->with('success', 'Insumo creado exitosamente.');
    }

    public function edit(Insumo $insumo)
    {
        if ($insumo->id_empresa !== $this->getEmpresaId()) {
            abort(403);
        }
        $id_empresa = $this->getEmpresaId();
        $proveedores = Proveedor::where('id_empresa', $id_empresa)->get();
        $tiposInsumo = TipoInsumo::where('id_empresa', $id_empresa)->get();
        return view('admin.insumos.edit', compact('insumo', 'proveedores', 'tiposInsumo'));
    }

    public function update(Request $request, Insumo $insumo)
    {
        if ($insumo->id_empresa !== $this->getEmpresaId()) {
            abort(403);
        }

        $request->validate([
            'Nombre' => 'required|string|max:255',
            'id_tipo_insumo' => 'required|exists:tipo_insumo,id_tipo_insumo',
            'Calidad' => 'nullable|string|max:255',
            'cantidad_stock' => 'required|numeric|min:0',
            'Fecha_ingreso' => 'nullable|date',
            'Fecha_vencimiento' => 'nullable|date',
            'descripcion' => 'nullable|string',
            'id_proveedor' => 'nullable|exists:proveedor,id_proveedor',
        ]);

        $insumo->update([
            'Nombre' => $request->Nombre,
            'id_tipo_insumo' => $request->id_tipo_insumo,
            'Calidad' => $request->Calidad,
            'cantidad_stock' => $request->cantidad_stock,
            'Fecha_ingreso' => $request->Fecha_ingreso,
            'Fecha_vencimiento' => $request->Fecha_vencimiento,
            'descripcion' => $request->descripcion,
            'id_proveedor' => $request->id_proveedor,
        ]);

        return redirect()->route('admin.insumos.index')->with('success', 'Insumo actualizado exitosamente.');
    }

    public function destroy(Insumo $insumo)
    {
        if ($insumo->id_empresa !== $this->getEmpresaId()) {
            abort(403);
        }
        $insumo->delete();
        return redirect()->route('admin.insumos.index')->with('success', 'Insumo eliminado exitosamente.');
    }
}
