<?php

namespace App\Http\Controllers;

use App\Models\TipoSemilla;
use Illuminate\Http\Request;

class TipoSemillaController extends Controller
{
    public function index()
    {
        $tipoSemillas = TipoSemilla::paginate(10);
        return view('admin.tipo_semillas.index', compact('tipoSemillas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'Tipo_semilla' => [
                'required',
                'string',
                'max:255',
                'unique:tipo_semilla,Tipo_semilla',
                'regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/u'
            ],
        ], [
            'Tipo_semilla.regex' => 'El tipo de semilla solo puede contener letras y espacios.'
        ]);

        TipoSemilla::create([
            'Tipo_semilla' => $request->Tipo_semilla,
        ]);

        return redirect()->route('tipo_semillas.index')
            ->with('success', 'Tipo de semilla creado correctamente');
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'Tipo_semilla' => [
                    'required',
                    'string',
                    'max:255',
                    'unique:tipo_semilla,Tipo_semilla,' . $id . ',id_semilla',
                    'regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/u'
                ],
            ], [
                'Tipo_semilla.regex' => 'El tipo de semilla solo puede contener letras y espacios.'
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput()
                ->with('editing', true)
                ->with('edit_action', route('tipo_semillas.update', $id));
        }

        $tipoSemilla = TipoSemilla::findOrFail($id);

        $tipoSemilla->update([
            'Tipo_semilla' => $request->Tipo_semilla,
        ]);

        return redirect()->route('tipo_semillas.index')
            ->with('success', 'Tipo de semilla actualizado correctamente');
    }

    public function destroy($id)
    {
        $tipoSemilla = TipoSemilla::findOrFail($id);
        $tipoSemilla->delete();

        return redirect()->route('tipo_semillas.index')
            ->with('success', 'Tipo de semilla eliminado correctamente');
    }
}
