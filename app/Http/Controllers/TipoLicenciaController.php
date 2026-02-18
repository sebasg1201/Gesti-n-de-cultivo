<?php

namespace App\Http\Controllers;

use App\Models\TipoLicencia;
use Illuminate\Http\Request;

class TipoLicenciaController extends Controller
{
    public function index()
    {
        $licencias = TipoLicencia::paginate(10);
        return view('SuperAdmin.tipo_licencias', compact('licencias'));
    }

    public function create()
    {
        return view('SuperAdmin.create_licencia');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre_licencia' => 'required|string|max:100',
            'tiempo' => 'required|string|max:50',
            'descripcion' => 'nullable|string|max:255',
            'precio' => 'required|numeric|min:0'
        ]);

        TipoLicencia::create([
            'nombre_licencia' => $request->nombre_licencia,
            'tiempo' => $request->tiempo,
            'descripcion' => $request->descripcion,
            'precio' => $request->precio,
            'id_estado' => 1
        ]);

        return redirect()->route('licencias.index')
            ->with('success', 'Licencia creada correctamente');
    }

    public function edit($id)
    {
        $licencia = TipoLicencia::findOrFail($id);
        return view('SuperAdmin.edit_licencia', compact('licencia'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre_licencia' => 'required|string|max:100',
            'tiempo' => 'required|string|max:50',
            'descripcion' => 'nullable|string|max:255',
            'precio' => 'required|numeric|min:0'
        ]);

        $licencia = TipoLicencia::findOrFail($id);

        $licencia->update([
            'nombre_licencia' => $request->nombre_licencia,
            'tiempo' => $request->tiempo,
            'descripcion' => $request->descripcion,
            'precio' => $request->precio
        ]);

        return redirect()->route('licencias.index')
            ->with('success', 'Licencia actualizada correctamente');
    }

    public function destroy($id)
    {
        $licencia = TipoLicencia::findOrFail($id);
        $licencia->delete();

        return redirect()->route('licencias.index')
            ->with('success', 'Licencia eliminada correctamente');
    }
}
