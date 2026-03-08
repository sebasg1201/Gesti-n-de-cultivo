<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TerrenoController extends Controller
{
    public function index()
    {
        $id_empresa = auth()->guard('usuario')->user()->id_empresa;
        
        $terrenos = \App\Models\Terreno::with(['tipoSuelo', 'estado'])
            ->where('id_empresa', $id_empresa)
            ->paginate(10);
            
        $tipoSuelos = \App\Models\TipoSuelo::where('id_empresa', $id_empresa)->get();

        return view('admin.terreno.index', compact('terrenos', 'tipoSuelos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'ubicacion' => 'required|string|max:150',
            'Ancho' => 'required|numeric|min:1',
            'Alto' => 'required|numeric|min:1',
            'id_tipo_suelo' => 'required|exists:tipo_suelo,id_tipo_suelo'
        ]);

        $id_empresa = auth()->guard('usuario')->user()->id_empresa;

        // Check if a Terreno with same name exists for the company
        $exists = \App\Models\Terreno::where('id_empresa', $id_empresa)
            ->where('nombre', $request->nombre)
            ->exists();

        if ($exists) {
            return redirect()->back()->with('error', 'Ya existe un terreno con este nombre.');
        }

        \App\Models\Terreno::create([
            'id_empresa' => $id_empresa,
            'nombre' => $request->nombre,
            'ubicacion' => $request->ubicacion,
            'Ancho' => $request->Ancho,
            'Alto' => $request->Alto,
            'id_estado' => 7, // 7 = Disponible
            'id_tipo_suelo' => $request->id_tipo_suelo,
        ]);

        return redirect()->route('admin.terrenos.index')
            ->with('success', 'Terreno registrado correctamente.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'ubicacion' => 'required|string|max:150',
            'Ancho' => 'required|numeric|min:1',
            'Alto' => 'required|numeric|min:1',
            'id_tipo_suelo' => 'required|exists:tipo_suelo,id_tipo_suelo'
        ]);

        $terreno = \App\Models\Terreno::findOrFail($id);
        
        // Ensure the company owns the Terreno
        $id_empresa = auth()->guard('usuario')->user()->id_empresa;
        if ($terreno->id_empresa !== $id_empresa) {
            return redirect()->route('admin.terrenos.index')->with('error', 'Acceso no autorizado.');
        }

        $terreno->update([
            'nombre' => $request->nombre,
            'ubicacion' => $request->ubicacion,
            'Ancho' => $request->Ancho,
            'Alto' => $request->Alto,
            'id_tipo_suelo' => $request->id_tipo_suelo,
        ]);

        return redirect()->route('admin.terrenos.index')
            ->with('success', 'Terreno actualizado correctamente');
    }

    public function destroy($id)
    {
        $terreno = \App\Models\Terreno::findOrFail($id);
        
        $id_empresa = auth()->guard('usuario')->user()->id_empresa;
        if ($terreno->id_empresa !== $id_empresa) {
            return redirect()->route('admin.terrenos.index')->with('error', 'Acceso no autorizado.');
        }
        
        $terreno->delete();

        return redirect()->route('admin.terrenos.index')
            ->with('success', 'Terreno eliminado correctamente');
    }
}
