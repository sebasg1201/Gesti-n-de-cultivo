<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TerrenoController extends Controller
{
    private function getEmpresaId()
    {
        return Auth::guard('usuario')->user()->id_empresa;
    }
    public function index()
    {
        $id_empresa = $this->getEmpresaId();

        $terrenos = \App\Models\Terreno::with(['tipoSuelo', 'estado'])
            ->where('id_empresa', $id_empresa)
            ->paginate(10);

        $tipoSuelos = \App\Models\TipoSuelo::where('id_empresa', $id_empresa)->get();
        $estados = \App\Models\Estado::all();

        return view('admin.terreno.index', compact('terrenos', 'tipoSuelos', 'estados'));
    }

    public function store(Request $request)
    {
        $id_empresa = $this->getEmpresaId();

        $request->validate([
            'nombre' => 'required|string|max:100',
            'ubicacion' => 'required|string|max:150',
            'Ancho' => 'required|numeric|min:1',
            'Alto' => 'required|numeric|min:1',
            'id_tipo_suelo' => 'required|exists:tipo_suelo,id_tipo_suelo'
        ]);

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
        $id_empresa = $this->getEmpresaId();

        $request->validate([
            'nombre' => 'required|string|max:100',
            'ubicacion' => 'required|string|max:150',
            'Ancho' => 'required|numeric|min:1',
            'Alto' => 'required|numeric|min:1',
            'id_tipo_suelo' => 'required|exists:tipo_suelo,id_tipo_suelo',
            'id_estado' => 'required|exists:estado,id_estado'
        ]);

        $terreno = \App\Models\Terreno::where('id_terreno', $id)
            ->where('id_empresa', $id_empresa)
            ->firstOrFail();

        $terreno->update([
            'nombre' => $request->nombre,
            'ubicacion' => $request->ubicacion,
            'Ancho' => $request->Ancho,
            'Alto' => $request->Alto,
            'id_tipo_suelo' => $request->id_tipo_suelo,
            'id_estado' => $request->id_estado,
        ]);

        return redirect()->route('admin.terrenos.index')
            ->with('success', 'Terreno actualizado correctamente');
    }

    public function destroy($id)
    {
        $id_empresa = $this->getEmpresaId();

        $terreno = \App\Models\Terreno::where('id_terreno', $id)
            ->where('id_empresa', $id_empresa)
            ->firstOrFail();

        $terreno->delete();

        return redirect()->route('admin.terrenos.index')
            ->with('success', 'Terreno eliminado correctamente');
    }
}
