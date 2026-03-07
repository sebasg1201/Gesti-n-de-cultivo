<?php

namespace App\Http\Controllers;

use App\Models\TipoRiego;
use App\Models\Riego;
use Illuminate\Http\Request;


class TipoRiegoController extends Controller
{
    public function index()
    {
        $tipoRiegos = TipoRiego::with(['riegos' => function($query) {
            $query->latest('id_riego');
        }])->paginate(10);
        return view('admin.tipo_riegos.index', compact('tipoRiegos'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'tipo_riego' => 'required|string|max:255|unique:tipo_riego,tipo_riego|regex:/^[\pL\s]+$/u',
            'cant_agua_apl' => 'nullable|string|max:50',
        ]);

        $tipoRiego = TipoRiego::create([
            'tipo_riego' => $request->tipo_riego,
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
        try {
            $request->validate([
                'tipo_riego' => 'required|string|max:255|unique:tipo_riego,tipo_riego,' . $id . ',id_tipo_riego|regex:/^[\pL\s]+$/u',
                'cant_agua_apl' => 'nullable|string|max:50',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput()
                ->with('editing', true)
                ->with('edit_action', route('tipo_riegos.update', $id));
        }

        $tipoRiego = TipoRiego::findOrFail($id);

        $tipoRiego->update([
            'tipo_riego' => $request->tipo_riego,
        ]);

        if ($request->has('cant_agua_apl')) {
            $riego = Riego::where('id_tipo_riego', $id)->latest('id_riego')->first();
            if ($riego) {
                $riego->update([
                    'cant_agua_apl' => $request->cant_agua_apl,
                ]);
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
        try {
            \Illuminate\Support\Facades\DB::transaction(function () use ($id) {
                // Primero eliminamos los registros asociados en 'riego'
                Riego::where('id_tipo_riego', $id)->delete();
                
                // Luego eliminamos el Tipo de Riego
                $tipoRiego = TipoRiego::findOrFail($id);
                $tipoRiego->delete();
            });

            return redirect()->route('tipo_riegos.index')
                ->with('success', 'Tipo de riego y sus registros asociados eliminados correctamente');
        } catch (\Exception $e) {
            return redirect()->route('tipo_riegos.index')
                ->with('error', 'Ocurrió un error al intentar eliminar el tipo de riego: ' . $e->getMessage());
        }
    }
}
