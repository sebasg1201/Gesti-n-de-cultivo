<?php

namespace App\Http\Controllers;

use App\Models\TipoSemilla;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TipoSemillaController extends Controller
{
    private function getEmpresaId()
    {
        return Auth::guard('usuario')->user()->id_empresa;
    }

    public function index()
    {
        $tipoSemillas = TipoSemilla::where('id_empresa', $this->getEmpresaId())
            ->paginate(10);
        return view('admin.tipo_semillas.index', compact('tipoSemillas'));
    }

    public function store(Request $request)
    {
        $idEmpresa = $this->getEmpresaId();

        $request->validate([
            'Tipo_semilla' => [
                'required',
                'string',
                'max:255',
                \Illuminate\Validation\Rule::unique('tipo_semilla', 'Tipo_semilla')
                    ->where('id_empresa', $idEmpresa),
                'regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/u'
            ],
        ], [
            'Tipo_semilla.regex' => 'El tipo de semilla solo puede contener letras y espacios.'
        ]);

        TipoSemilla::create([
            'Tipo_semilla' => $request->Tipo_semilla,
            'id_empresa' => $idEmpresa,
        ]);

        return redirect()->route('tipo_semillas.index')
            ->with('success', 'Tipo de semilla creado correctamente');
    }

    public function update(Request $request, $id)
    {
        $idEmpresa = $this->getEmpresaId();
        $tipoSemilla = TipoSemilla::where('id_semilla', $id)
            ->where('id_empresa', $idEmpresa)
            ->firstOrFail();

        try {
            $request->validate([
                'Tipo_semilla' => [
                    'required',
                    'string',
                    'max:255',
                    \Illuminate\Validation\Rule::unique('tipo_semilla', 'Tipo_semilla')
                        ->ignore($id, 'id_semilla')
                        ->where('id_empresa', $idEmpresa),
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

        $tipoSemilla->update([
            'Tipo_semilla' => $request->Tipo_semilla,
        ]);

        return redirect()->route('tipo_semillas.index')
            ->with('success', 'Tipo de semilla actualizado correctamente');
    }

    public function destroy($id)
    {
        $tipoSemilla = TipoSemilla::where('id_semilla', $id)
            ->where('id_empresa', $this->getEmpresaId())
            ->firstOrFail();

        $tipoSemilla->delete();

        return redirect()->route('tipo_semillas.index')
            ->with('success', 'Tipo de semilla eliminado correctamente');
    }
}
