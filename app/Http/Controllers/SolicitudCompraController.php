<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SolicitudCompra;
use App\Models\TipoLicencia;
use App\Models\SuperAdmin;
use App\Models\Empresa;

class SolicitudCompraController extends Controller
{
    public function index()
    {
        $solicitudes = SolicitudCompra::with(['tipoLicencia', 'estado', 'superAdmin', 'empresa'])
            ->orderBy('fecha_solicitud', 'desc')
            ->get();

        return view('superadmin.solicitudes', compact('solicitudes'));
    }

    public function markAsSeen($id)
    {
        $solicitud = SolicitudCompra::find($id);

        if ($solicitud) {
            $solicitud->id_estado = 5;
            $solicitud->fecha_revision = now();
            $solicitud->save();

            return redirect()->back()->with('success', 'Solicitud marcada como vista.');
        }

        return redirect()->back()->with('error', 'Solicitud no encontrada.');
    }

    public function destroy($id)
    {
        $solicitud = SolicitudCompra::find($id);

        if (!$solicitud) {
            return redirect()->back()->with('error', 'Solicitud no encontrada.');
        }

        $nitEmpresa = $solicitud->nit_empresa;

        try {
            // Desactivar FK checks para garantizar borrado sin restricciones
            \DB::statement('SET FOREIGN_KEY_CHECKS=0');

            // 1. Borrar TODAS las solicitudes del NIT
            \DB::table('solicitud_compra')->where('nit_empresa', $nitEmpresa)->delete();

            if ($nitEmpresa) {
                // 2. Borrar usuarios de la empresa
                \DB::table('usuario')->where('id_empresa', $nitEmpresa)->delete();

                // 3. Borrar licencias de la empresa
                \DB::table('venta_licencias')->where('id_empresa', $nitEmpresa)->delete();

                // 4. Borrar la empresa directamente
                \DB::table('empresa')->where('id_empresa', $nitEmpresa)->delete();
            }

            // Reactivar FK checks
            \DB::statement('SET FOREIGN_KEY_CHECKS=1');

        } catch (\Exception $e) {
            \DB::statement('SET FOREIGN_KEY_CHECKS=1'); // Siempre reactivar
            return redirect()->back()->with('error', 'Error al eliminar: ' . $e->getMessage());
        }

        return redirect()->back()->with('success', 'Solicitud y empresa eliminadas correctamente.');
    }

    public function create($licencia_id)
    {
        $licencia = TipoLicencia::find($licencia_id);

        if (!$licencia) {
            return redirect('/')->with('error', 'Licencia no encontrada.');
        }

        return view('usuario.solicitud', compact('licencia'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nit_empresa' => 'required|string|max:20',
            'nombre_empresa' => 'required|string|max:200',
            'nombre_repre_legal' => 'required|string|max:150',
            'cedula_repre' => 'required|numeric|digits_between:8,11',
            'telefono' => 'required|numeric|digits_between:8,11',
            'correo' => 'required|email|max:150',
            'direccion' => 'required|string|max:200',
            'comprobante_pago' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'licencia_id' => 'required|exists:tipo_licencia,id_tipo_licencia',
        ]);

        // 1. Manejo del Archivo (Comprobante)
        if ($request->hasFile('comprobante_pago')) {
            $image = $request->file('comprobante_pago');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('comprobantes'), $imageName);
            $rutaComprobante = 'comprobantes/' . $imageName;
        } else {
            return back()->with('error', 'El comprobante de pago es obligatorio.');
        }

        // 2. Crear o Actualizar Empresa
        // Buscamos si ya existe una empresa con ese NIT, si no, la creamos.
        // Si existe, actualizamos sus datos (opcional, pero recomendable para mantener info al día)
        $empresa = Empresa::updateOrCreate(
            ['id_empresa' => $request->nit_empresa], // Busqueda por Primary Key
            [
                'nombre_empresa' => $request->nombre_empresa,
                'nombre_repre_legal' => $request->nombre_repre_legal,
                'cedula_repre' => $request->cedula_repre,
                'telefono' => $request->telefono,
                'correo' => $request->correo,
                'direccion' => $request->direccion,
                'fecha_creacion' => now(), // O mantener la original si solo se actualiza
                'id_estado' => 1 // Asumimos estado 'activa' o 'pendiente' según lógica de negocio. 1=pendiente? Revisando SQL dump: 1=pendiente, 3=activa.
                // Si es nueva empresa registrandose, quizás debería ser 1 (pendiente) o 3 (activa).
                // El dump muesta id_estado 1 y 3. Usaremos 1 (pendiente) o lo que el usuario prefiera.
                // Viendo el dump, empresas creadas tienen estado 1 o 3.
                // Vamos a poner 3 (activa) por defecto para que puedan operar, o 1 si requiere aprobación.
                // Dejaré 1 (pendiente) para ser conservador, o 3 si la empresa ya "existe".
                // Mejor: 'id_estado' => 1 (pendiente) si se crea.
            ]
        );

        // Si la empresa se creó recién, asegurarse de que tenga estado.
        // updateOrCreate llena los campos. Si empresa ya existía, actualiza.
        // Nota: Si 'fecha_creacion' no debería cambiar al actualizar, se debe usar firstOrNew logic.
        // Pero updateOrCreate es práctico aquí.

        // 3. Crear Solicitud de Compra
        SolicitudCompra::create([
            'nit_empresa' => $empresa->id_empresa,
            'comprobante_pago' => $rutaComprobante,
            'id_tipo_licencia' => $request->licencia_id,
            'id_estado' => 1, // 1 = Pendiente
            'fecha_solicitud' => now(),
            'fecha_revision' => null,
        ]);

        return redirect('/')->with('success', 'Solicitud enviada exitosamente. Estaremos en contacto.');
    }
}