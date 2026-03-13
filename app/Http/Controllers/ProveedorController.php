<?php

namespace App\Http\Controllers;

use App\Models\Proveedor;
use App\Models\EntradaInsumo;
use App\Models\Insumo;
use App\Models\TipoSemilla;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProveedorController extends Controller
{
    private function getEmpresaId()
    {
        return Auth::guard('usuario')->user()->id_empresa;
    }

    public function index(Request $request)
    {
        $id_empresa = $this->getEmpresaId();
        $query = Proveedor::where('id_empresa', $id_empresa);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nombre', 'like', "%{$search}%")
                    ->orWhere('producto', 'like', "%{$search}%")
                    ->orWhere('contacto', 'like', "%{$search}%");
            });
        }

        $proveedores = $query->orderBy('id_proveedor', 'desc')->paginate(10);

        // Cargar insumos y semillas para el modal de entrada
        $insumosParaEntrada = Insumo::where('id_empresa', $id_empresa)->get();
        $semillasParaEntrada = TipoSemilla::where('id_empresa', $id_empresa)->get();

        return view('admin.proveedores.index', compact('proveedores', 'insumosParaEntrada', 'semillasParaEntrada'));
    }

    public function store(Request $request)
    {
        $id_empresa = $this->getEmpresaId();

        $request->validate([
            'nombre' => 'required|string|max:100',
            'producto' => 'nullable|string|max:100',
            'contacto' => 'nullable|string|max:50',
        ]);

        Proveedor::create([
            'nombre' => $request->nombre,
            'producto' => $request->producto,
            'contacto' => $request->contacto,
            'id_empresa' => $id_empresa,
        ]);

        return redirect()->route('admin.proveedores.index')->with('success', 'Proveedor registrado exitosamente.');
    }

    public function storeEntrada(Request $request, $id)
    {
        $id_empresa = $this->getEmpresaId();
        $proveedor = Proveedor::where('id_proveedor', $id)->where('id_empresa', $id_empresa)->firstOrFail();

        $request->validate([
            'tipo_item' => 'required|in:insumo,semilla',
            'id_item' => 'required',
            'cantidad_recibida' => 'required|numeric|min:0.01',
            'precio_unitario' => 'nullable|numeric|min:0',
            'fecha_vencimiento' => 'nullable|date',
        ]);

        DB::beginTransaction();
        try {
            $id_insumo = null;
            $id_semilla = null;

            if ($request->tipo_item === 'insumo') {
                $id_insumo = $request->id_item;
                $item = Insumo::where('ID_insumo', $id_insumo)->where('id_empresa', $id_empresa)->firstOrFail();
                // El stock_actual se actualiza ahora mediante el trigger trg_entrada_insumo de la BD
                if ($request->filled('fecha_vencimiento')) {
                    $item->Fecha_vencimiento = $request->fecha_vencimiento;
                }
                $item->save();
            } else {
                $id_semilla = $request->id_item;
                $item = TipoSemilla::where('id_semilla', $id_semilla)->where('id_empresa', $id_empresa)->firstOrFail();
                // El stock_actual se actualiza ahora mediante el trigger trg_entrada_insumo de la BD
                $item->save();
            }

            EntradaInsumo::create([
                'id_proveedor' => $proveedor->id_proveedor,
                'id_insumo' => $id_insumo,
                'id_semilla' => $id_semilla,
                'id_empresa' => $id_empresa,
                'cantidad_recibida' => $request->cantidad_recibida,
                'fecha_entrada' => now(),
                'precio_unitario' => $request->precio_unitario,
            ]);

            DB::commit();
            return redirect()->route('admin.proveedores.index')->with('success', 'Entrada de inventario registrada y stock actualizado.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Error al procesar la entrada: ' . $e->getMessage());
        }
    }

    public function historial($id)
    {
        $id_empresa = $this->getEmpresaId();
        $entradas = EntradaInsumo::with(['insumo', 'semilla'])
            ->where('id_proveedor', $id)
            ->where('id_empresa', $id_empresa)
            ->orderBy('fecha_entrada', 'desc')
            ->get();

        return response()->json($entradas);
    }

    public function update(Request $request, $id)
    {
        $id_empresa = $this->getEmpresaId();
        $proveedor = Proveedor::where('id_proveedor', $id)->where('id_empresa', $id_empresa)->firstOrFail();

        $request->validate([
            'nombre' => 'required|string|max:100',
            'producto' => 'nullable|string|max:100',
            'contacto' => 'nullable|string|max:50',
        ]);

        $proveedor->update([
            'nombre' => $request->nombre,
            'producto' => $request->producto,
            'contacto' => $request->contacto,
        ]);

        return redirect()->route('admin.proveedores.index')->with('success', 'Proveedor actualizado correctamente.');
    }

    public function destroy($id)
    {
        $id_empresa = $this->getEmpresaId();
        $proveedor = Proveedor::where('id_proveedor', $id)->where('id_empresa', $id_empresa)->firstOrFail();

        $proveedor->delete();
        return redirect()->route('admin.proveedores.index')->with('success', 'Proveedor eliminado.');
    }
}
