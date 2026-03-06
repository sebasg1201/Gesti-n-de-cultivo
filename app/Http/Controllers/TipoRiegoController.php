<?php

namespace App\Http\Controllers;

use App\Models\TipoRiego;
use App\Models\Riego;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TipoRiegoController extends Controller
{
    private function getEmpresaId()
    {
        return Auth::guard('usuario')->user()->id_empresa;
    }

    public function index()
    {
        $tipoRiegos = TipoRiego::with([
            'riegos' => function ($query) {
                $query->latest('id_riego');
            }
        ])
            ->where('id_empresa', $this->getEmpresaId())
            ->paginate(10);

        return view('admin.tipo_riegos.index', compact('tipoRiegos'));
    }

    public function store(Request $request)
    {
        $idEmpresa = $this->getEmpresaId();

        $request->validate([
            'tipo_riego' => [
                'required',
                'string',
                'max:255',
                \Illuminate\Validation\Rule::unique('tipo_riego', 'tipo_riego')
                    ->where('id_empresa', $idEmpresa),
                'regex:/^[\pL\s]+$/u',
            ],
            'cant_agua_apl' => 'nullable|string|max:50',
        ]);

        $tipoRiego = TipoRiego::create([
            'tipo_riego' => $request->tipo_riego,
            'id_empresa' => $idEmpresa,
        ]);

        if ($request->cant_agua_apl) {
            Riego::create([
                'fecha' => now()->toDateString(),
                'cant_agua_apl' => $request->cant_agua_apl,
                'id_tipo_riego' => $tipoRiego->id_tipo_riego,
            ]);
        }

        return redirect()->route('tipo_riegos.index')
            ->with('success', 'Tipo de riego creado correctamente');
    }

    public function update(Request $request, $id)
    {
        $idEmpresa = $this->getEmpresaId();
        $tipoRiego = TipoRiego::where('id_tipo_riego', $id)
            ->where('id_empresa', $idEmpresa)
            ->firstOrFail();

        try {
            $request->validate([
                'tipo_riego' => [
                    'required',
                    'string',
                    'max:255',
                    \Illuminate\Validation\Rule::unique('tipo_riego', 'tipo_riego')
                        ->ignore($id, 'id_tipo_riego')
                        ->where('id_empresa', $idEmpresa),
                    'regex:/^[\pL\s]+$/u',
                ],
                'cant_agua_apl' => 'nullable|string|max:50',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput()
                ->with('editing', true)
                ->with('edit_action', route('tipo_riegos.update', $id));
        }

        $tipoRiego->update([
            'tipo_riego' => $request->tipo_riego,
        ]);

        if ($request->has('cant_agua_apl')) {
            $riego = Riego::where('id_tipo_riego', $id)->latest('id_riego')->first();
            if ($riego) {
                $riego->update(['cant_agua_apl' => $request->cant_agua_apl]);
            } else {
                Riego::create([
                    'fecha' => now()->toDateString(),
                    'cant_agua_apl' => $request->cant_agua_apl,
                    'id_tipo_riego' => $id,
                ]);
            }
        }

        return redirect()->route('tipo_riegos.index')
            ->with('success', 'Tipo de riego actualizado correctamente');
    }

    public function destroy($id)
    {
        $tipoRiego = TipoRiego::where('id_tipo_riego', $id)
            ->where('id_empresa', $this->getEmpresaId())
            ->firstOrFail();

        \Illuminate\Support\Facades\DB::transaction(function () use ($tipoRiego, $id) {
            Riego::where('id_tipo_riego', $id)->delete();
            $tipoRiego->delete();
        });

        return redirect()->route('tipo_riegos.index')
            ->with('success', 'Tipo de riego y sus registros asociados eliminados correctamente');
    }
}
