<?php

namespace App\Http\Controllers;

use App\Models\TipoCosecha;
use App\Models\TipoSemilla;
use App\Models\TipoRiego;
use App\Models\Cosecha;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TipoCosechaController extends Controller
{
    private function getEmpresaId()
    {
        return Auth::guard('usuario')->user()->id_empresa;
    }

    public function index()
    {
        $idEmpresa = $this->getEmpresaId();

        $tipoCosechas = TipoCosecha::with(['semilla', 'riego'])
            ->where('id_empresa', $idEmpresa)
            ->paginate(10);

        $tipoSemillas = TipoSemilla::where('id_empresa', $idEmpresa)->get();
        $tipoRiegos = TipoRiego::where('id_empresa', $idEmpresa)->get();

        return view('admin.tipo_cosechas.index', [
            'cosechas' => $tipoCosechas,
            'tipoSemillas' => $tipoSemillas,
            'tipoRiegos' => $tipoRiegos,
        ]);
    }

    public function create()
    {
        $idEmpresa = $this->getEmpresaId();
        $tipoSemillas = TipoSemilla::where('id_empresa', $idEmpresa)->get();
        $tipoRiegos = TipoRiego::where('id_empresa', $idEmpresa)->get();

        return view('admin.tipo_cosechas.create', compact('tipoSemillas', 'tipoRiegos'));
    }

    public function store(Request $request)
    {
        $idEmpresa = $this->getEmpresaId();

        $request->validate([
            'tiempo' => 'required|integer|min:1',
            'terreno' => 'required|string|max:100',
            'id_semilla' => 'required|exists:tipo_semilla,id_semilla',
            'id_tipo_riego' => 'required|exists:tipo_riego,id_tipo_riego',
        ]);

        $tipoCosecha = TipoCosecha::create([
            'tiempo' => $request->tiempo,
            'terreno' => $request->terreno,
            'id_semilla' => $request->id_semilla,
            'id_tipo_riego' => $request->id_tipo_riego,
            'id_empresa' => $idEmpresa,
        ]);

        // Si se envían datos de cosecha, crear el registro de cosecha también
        if ($request->filled('cantidad') || $request->filled('fecha_inicio')) {
            Cosecha::create([
                'Cantidad' => $request->cantidad ?? 0,
                'fecha_inicio' => $request->fecha_inicio ?? now()->toDateString(),
                'fecha_fin' => $request->fecha_fin,
                'id_tipo_cosecha' => $tipoCosecha->id_tipo_cosecha,
                'id_empresa' => $idEmpresa,
            ]);
        }

        return redirect()
            ->route('tipo_cosechas.index')
            ->with('success', 'Tipo de cosecha creado correctamente');
    }

    public function edit($id)
    {
        $idEmpresa = $this->getEmpresaId();
        $tipoCosecha = TipoCosecha::where('id_tipo_cosecha', $id)
            ->where('id_empresa', $idEmpresa)
            ->firstOrFail();

        $tipoSemillas = TipoSemilla::where('id_empresa', $idEmpresa)->get();
        $tipoRiegos = TipoRiego::where('id_empresa', $idEmpresa)->get();

        return view('admin.tipo_cosechas.edit', compact('tipoCosecha', 'tipoSemillas', 'tipoRiegos'));
    }

    public function update(Request $request, $id)
    {
        $idEmpresa = $this->getEmpresaId();
        $tipoCosecha = TipoCosecha::where('id_tipo_cosecha', $id)
            ->where('id_empresa', $idEmpresa)
            ->firstOrFail();

        $request->validate([
            'tiempo' => 'required|integer|min:1',
            'terreno' => 'required|string|max:100',
            'id_semilla' => 'required|exists:tipo_semilla,id_semilla',
            'id_tipo_riego' => 'required|exists:tipo_riego,id_tipo_riego',
        ]);

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
        $idEmpresa = $this->getEmpresaId();
        try {
            $tipoCosecha = TipoCosecha::where('id_tipo_cosecha', $id)
                ->where('id_empresa', $idEmpresa)
                ->firstOrFail();

            $tipoCosecha->delete();

            return redirect()
                ->route('tipo_cosechas.index')
                ->with('success', 'Tipo de cosecha eliminado correctamente');
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() == "23000") {
                return redirect()
                    ->route('tipo_cosechas.index')
                    ->with('error', 'No se puede eliminar este tipo de cosecha porque está siendo utilizado en otros registros.');
            }
            return redirect()
                ->route('tipo_cosechas.index')
                ->with('error', 'Ocurrió un error al intentar eliminar el tipo de cosecha.');
        }
    }
}
