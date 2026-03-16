<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cultivo;
use App\Models\Cosecha;
use App\Models\Producto;
use App\Models\DetalleProductoCultivo;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CultivoController extends Controller
{
    private function getEmpresaId()
    {
        return Auth::guard('usuario')->user()->id_empresa;
    }

    public function index(Request $request)
    {
        $id_empresa = $this->getEmpresaId();
        $id_semilla = $request->query('id_semilla');

        $semillaSeleccionada = null;
        if ($id_semilla) {
            $semillaSeleccionada = \App\Models\TipoSemilla::where('id_empresa', $id_empresa)->findOrFail($id_semilla);
            
            $cosechas = Cosecha::where('id_empresa', $id_empresa)
                ->where('id_semilla', $id_semilla)
                ->where('id_estado', '!=', 14) // No terminadas
                ->with(['semilla', 'terreno'])
                ->orderBy('fecha_siembra', 'desc')
                ->get();
                
            return view('admin.cultivos.index', compact('cosechas', 'semillaSeleccionada'));
        }

        // Si no hay semilla seleccionada, mostrar categorías (Variedades)
        // Obtenemos solo las variedades que tienen cosechas activas
        $categorias = \App\Models\TipoSemilla::where('id_empresa', $id_empresa)
            ->whereHas('cosechas', function($q) {
                $q->where('id_estado', '!=', 14);
            })
            ->withCount(['cosechas' => function($q) {
                $q->where('id_estado', '!=', 14);
            }])
            ->get()
            ->map(function($cat) {
                // Buscar la primera cosecha con imagen para usarla como portada de la categoría
                $cosechaConImagen = \App\Models\Cosecha::where('id_semilla', $cat->id_semilla)
                    ->whereNotNull('imagenes')
                    ->where('id_estado', '!=', 14)
                    ->first();
                
                $cat->imagen_portada = $cosechaConImagen ? $cosechaConImagen->imagenes : null;
                return $cat;
            });

        return view('admin.cultivos.index', compact('categorias'));
    }

    public function create(Request $request)
    {
        $id_empresa = $this->getEmpresaId();
        $id_cosecha = $request->query('id_cosecha');

        $cosecha = null;
        $productoReferencia = '';

        if ($id_cosecha) {
            $cosecha = Cosecha::where('id_empresa', $id_empresa)
                ->with(['semilla', 'terreno'])
                ->findOrFail($id_cosecha);
            
            // Sugerir nombre de producto basado en la semilla
            $productoReferencia = $cosecha->semilla->nombre_semilla ?? '';
        }

        $trabajadores = Usuario::where('id_empresa', $id_empresa)
            ->where('id_tipo_usuario', 3) // 3 = trabajador
            ->get();

        return view('admin.cultivos.create', compact('cosecha', 'trabajadores', 'id_cosecha', 'productoReferencia'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_cosecha' => 'required|exists:cosecha,id_cosecha',
            'documento_trabajador' => 'required|exists:usuario,documento',
            'fecha_recoleccion' => 'required|date',
            'cantidad' => 'required|numeric|min:0.1',
            'calidad' => 'required|string|max:50',
            'nombre_producto' => 'required|string|max:100',
            'codigo_referencia' => 'nullable|string|max:50',
            'observaciones' => 'nullable|string'
        ]);

        $id_empresa = $this->getEmpresaId();
        $cosecha = Cosecha::where('id_empresa', $id_empresa)->findOrFail($request->id_cosecha);

        try {
            DB::beginTransaction();

            // 1. Crear el producto (o buscarlo si ya existe uno con ese nombre y código)
            $producto = Producto::create([
                'nombre' => $request->nombre_producto,
                'Codigo_Referencia' => $request->codigo_referencia ?? 'REF-' . time(),
                'descripcion' => 'Producto recolectado de la cosecha #' . $cosecha->id_cosecha
            ]);

            // 2. Crear el registro de cultivo
            $cultivo = Cultivo::create([
                'fecha_recoleccion' => $request->fecha_recoleccion,
                'id_cosecha' => $cosecha->id_cosecha,
                'documento_trabajador' => $request->documento_trabajador,
                'observaciones' => $request->observaciones
            ]);

            // 3. Crear el detalle del producto en el cultivo
            DetalleProductoCultivo::create([
                'id_cultivo' => $cultivo->id_cultivo,
                'id_producto' => $producto->id_producto,
                'cantidad' => $request->cantidad,
                'calidad' => $request->calidad
            ]);

            // 4. Finalización manual desde la vista de cosecha
            DB::commit();

            return redirect()->route('admin.cultivos.index')->with('success', 'Recolección registrada exitosamente.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Error al registrar la recolección: ' . $e->getMessage())->withInput();
        }
    }

    public function finalize($id)
    {
        $id_empresa = $this->getEmpresaId();
        $cosecha = Cosecha::where('id_empresa', $id_empresa)->findOrFail($id);

        try {
            DB::beginTransaction();

            $cosecha->id_estado = 14; // Finalizado/Recolectado
            $cosecha->save();

            if ($cosecha->terreno) {
                $cosecha->terreno->id_estado = 7; // Disponible
                $cosecha->terreno->save();
            }

            DB::commit();
            return redirect()->route('admin.cosechas.show', $id)->with('success', 'Cosecha finalizada y terreno liberado correctamente.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Error al finalizar la cosecha: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        $id_empresa = $this->getEmpresaId();

        $cultivo = Cultivo::whereHas('cosecha', function ($query) use ($id_empresa) {
            $query->where('id_empresa', $id_empresa);
        })
        ->with(['cosecha.semilla', 'trabajador', 'detalles.producto', 'cosecha.terreno'])
        ->findOrFail($id);
            
        // Get all sister harvests for the same mother Cosecha
        $historialCosecha = Cultivo::with(['detalles.producto', 'trabajador'])
            ->where('id_cosecha', $cultivo->id_cosecha)
            ->orderBy('fecha_recoleccion', 'desc')
            ->get();

        return view('admin.cultivos.show', compact('cultivo', 'historialCosecha'));
    }
    public function cosechaDetail($id)
    {
        $id_empresa = $this->getEmpresaId();

        $cosecha = Cosecha::where('id_empresa', $id_empresa)
            ->with(['semilla', 'terreno', 'cultivos.detalles.producto', 'cultivos.trabajador'])
            ->findOrFail($id);

        return view('admin.cultivos.cosecha_detail', compact('cosecha'));
    }
}
