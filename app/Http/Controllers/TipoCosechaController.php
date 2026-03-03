<?php

namespace App\Http\Controllers;

use App\Models\TipoCosecha;
use App\Models\TipoSemilla;
use App\Models\TipoRiego;
use Illuminate\Http\Request;

class TipoCosechaController extends Controller
{
    public function index()
    {
        $tipoCosechas = TipoCosecha::with(['semilla', 'riego'])
            ->paginate(10);

        $tipoSemillas = TipoSemilla::all();
        $tipoRiegos = TipoRiego::all();

        return view('admin.tipo_cosechas.index', [
            'cosechas' => $tipoCosechas,
            'tipoSemillas' => $tipoSemillas,
            'tipoRiegos' => $tipoRiegos
        ]);
    }

    public function create()
    {
        $tipoSemillas = TipoSemilla::all();
        $tipoRiegos = TipoRiego::all();

        return view(
            'admin.tipo_cosechas.create',
            compact('tipoSemillas', 'tipoRiegos')
        );
    }

    public function store(Request $request)
    {
        $request->validate([
            'tiempo' => 'required|integer|min:1',
            'terreno' => 'required|string|max:100',
            'id_semilla' => 'required|exists:tipo_semilla,id_semilla',
            'id_tipo_riego' => 'required|exists:tipo_riego,id_tipo_riego',

        ]);

        TipoCosecha::create([
            'tiempo' => $request->tiempo,
            'terreno' => $request->terreno,
            'id_semilla' => $request->id_semilla,
            'id_tipo_riego' => $request->id_tipo_riego,

        ]);

        return redirect()
            ->route('tipo_cosechas.index')
            ->with('success', 'Tipo de cosecha creado correctamente');
    }

    public function edit($id)
    {
        $tipoCosecha = TipoCosecha::findOrFail($id);
        $tipoSemillas = TipoSemilla::all();
        $tipoRiegos = TipoRiego::all();

        return view(
            'admin.tipo_cosechas.edit',
            compact('tipoCosecha', 'tipoSemillas', 'tipoRiegos')
        );
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'tiempo' => 'required|integer|min:1',
            'terreno' => 'required|string|max:100',
            'id_semilla' => 'required|exists:tipo_semilla,id_semilla',
            'id_tipo_riego' => 'required|exists:tipo_riego,id_tipo_riego',

        ]);

        $tipoCosecha = TipoCosecha::findOrFail($id);

        $tipoCosecha->update([
            'tiempo' => $request->tiempo,
            'terreno' => $request->terreno,
            'id_semilla' => $request->id_semilla,
            'id_tipo_riego' => $request->id_tipo_riego,

        ]);

        return redirect()
            ->route('tipo_cosechas.index')
            ->with('success', 'Tipo de cosecha actualizado correctamente');
    }

    public function destroy($id)
    {
        try {
            $tipoCosecha = TipoCosecha::findOrFail($id);
            $tipoCosecha->delete();

            return redirect()
                ->route('tipo_cosechas.index')
                ->with('success', 'Tipo de cosecha eliminado correctamente');
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() == "23000") {
                return redirect()
                    ->route('tipo_cosechas.index')
                    ->with('error', 'No se puede eliminar este tipo de cosecha porque está siendo utilizado en otros registros (ej. cosechas o fases programadas).');
            }
            return redirect()
                ->route('tipo_cosechas.index')
                ->with('error', 'Ocurrió un error al intentar eliminar el tipo de cosecha.');
        }
    }
}
