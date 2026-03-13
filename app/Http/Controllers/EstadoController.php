<?php

namespace App\Http\Controllers;

use App\Models\Estado;
use Illuminate\Http\Request;

class EstadoController extends Controller
{
    public function index()
    {
        // Ocultar los estados 1, 2, 3 y 4 (licenciamiento)
        $estados = Estado::whereNotIn('id_estado', [1, 2, 3, 4, 5])->paginate(10);
        return view('admin.estados.index', compact('estados'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre_estado' => [
                'required',
                'string',
                'max:255',
                'unique:estado,nombre_estado',
                'regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/u'
            ],
        ], [
            'nombre_estado.regex' => 'El nombre del estado solo puede contener letras y espacios.',
            'nombre_estado.unique' => 'Ya existe un estado con ese nombre.'
        ]);

        Estado::create([
            'nombre_estado' => $request->nombre_estado,
        ]);

        return redirect()->route('estados.index')
            ->with('success', 'Estado creado correctamente.');
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'nombre_estado' => [
                    'required',
                    'string',
                    'max:255',
                    'unique:estado,nombre_estado,' . $id . ',id_estado',
                    'regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/u'
                ],
            ], [
                'nombre_estado.regex' => 'El nombre del estado solo puede contener letras y espacios.',
                'nombre_estado.unique' => 'Ya existe un estado con ese nombre.'
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput()
                ->with('editing', true)
                ->with('edit_action', route('estados.update', $id));
        }

        $estado = Estado::findOrFail($id);
        $estado->update([
            'nombre_estado' => $request->nombre_estado,
        ]);

        return redirect()->route('estados.index')
            ->with('success', 'Estado actualizado correctamente.');
    }

    public function destroy($id)
    {
        $estado = Estado::findOrFail($id);

        // Optional: Check if the estado is being used by any company before deleting
        if ($estado->empresas()->count() > 0) {
            return redirect()->route('estados.index')
                ->with('error', 'No se puede eliminar este estado porque está siendo utilizado por una o más empresas.');
        }

        $estado->delete();

        return redirect()->route('estados.index')
            ->with('success', 'Estado eliminado correctamente.');
    }
}
