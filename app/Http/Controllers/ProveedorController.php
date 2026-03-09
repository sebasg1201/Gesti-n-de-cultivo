<?php

namespace App\Http\Controllers;

use App\Models\Proveedor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProveedorController extends Controller
{
    private function getEmpresaId()
    {
        return Auth::guard('usuario')->user()->id_empresa;
    }

    public function index(Request $request)
    {
        $id_empresa = $this->getEmpresaId();
        $query = Proveedor::where('id_empresa', $id_empresa);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nombre', 'like', "%{$search}%")
                    ->orWhere('correo', 'like', "%{$search}%");
            });
        }

        $proveedores = $query->orderBy('id_proveedor', 'desc')->paginate(10);
        return view('admin.proveedores.index', compact('proveedores'));
    }

    public function create()
    {
        return view('admin.proveedores.create');
    }

    public function store(Request $request)
    {
        $id_empresa = $this->getEmpresaId();

        $request->validate([
            'nombre' => 'required|string|max:255',
            'correo' => 'nullable|email|max:255',
            'telefono' => 'nullable|string|max:20',
        ]);

        Proveedor::create([
            'nombre' => $request->nombre,
            'correo' => $request->correo,
            'telefono' => $request->telefono,
            'id_empresa' => $id_empresa,
        ]);

        return redirect()->route('admin.proveedores.index')->with('success', 'Proveedor creado exitosamente.');
    }

    public function show(Proveedor $proveedor)
    {
        // View handled by index modal
    }

    public function edit(Proveedor $proveedor)
    {
        if ($proveedor->id_empresa !== $this->getEmpresaId()) {
            abort(403);
        }
        return view('admin.proveedores.edit', compact('proveedor'));
    }

    public function update(Request $request, Proveedor $proveedor)
    {
        if ($proveedor->id_empresa !== $this->getEmpresaId()) {
            abort(403);
        }

        $request->validate([
            'nombre' => 'required|string|max:255',
            'correo' => 'nullable|email|max:255',
            'telefono' => 'nullable|string|max:20',
        ]);

        $proveedor->update([
            'nombre' => $request->nombre,
            'correo' => $request->correo,
            'telefono' => $request->telefono,
        ]);

        return redirect()->route('admin.proveedores.index')->with('success', 'Proveedor actualizado exitosamente.');
    }

    public function destroy(Proveedor $proveedor)
    {
        if ($proveedor->id_empresa !== $this->getEmpresaId()) {
            abort(403);
        }
        $proveedor->delete();
        return redirect()->route('admin.proveedores.index')->with('success', 'Proveedor eliminado exitosamente.');
    }
}
