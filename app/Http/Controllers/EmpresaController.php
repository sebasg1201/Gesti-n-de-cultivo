<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use App\Models\Estado;
use Illuminate\Http\Request;

class EmpresaController extends Controller
{
    public function index(Request $request)
    {
        $query = Empresa::with('estado');

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('nombre_empresa', 'like', "%{$search}%")
                    ->orWhere('nombre_repre_legal', 'like', "%{$search}%")
                    ->orWhere('id_empresa', 'like', "%{$search}%"); // Assuming NIT is id_empresa or similar
            });
        }

        // Filter by state if needed, for now just search

        $empresas = $query->paginate(10);

        // Calculate stats
        $stats = [
            'nuevas' => Empresa::where('id_estado', 1)->count(), // Assuming 1 is Pending/New
            'suspendidas' => Empresa::where('id_estado', 2)->count(), // Assuming 2 is Suspended
            'activaciones' => Empresa::where('id_estado', 3)->count(),
        ];

        return view('empresas.index', compact('empresas', 'stats'));
    }
    public function activar($id)
    {
        $empresa = Empresa::findOrFail($id);
        $empresa->id_estado = 3; // 3 = Activa
        $empresa->save();

        return redirect()->back()->with('success', 'Empresa activada con éxito.');
    }
}
