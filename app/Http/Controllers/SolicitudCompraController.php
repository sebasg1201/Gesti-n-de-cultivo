<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SolicitudCompra;
use App\Models\TipoLicencia;
use App\Models\SuperAdmin;
use Carbon\Carbon;

class SolicitudCompraController extends Controller
{
    public function index()
    {
        $solicitudes = SolicitudCompra::with(['tipoLicencia', 'estado', 'superAdmin'])->orderBy('fecha_solicitud', 'desc')->get();
        return view('superadmin.solicitudes', compact('solicitudes'));
    }

    public function markAsSeen($id)
    {
        $solicitud = SolicitudCompra::find($id);
        if ($solicitud) {
            $solicitud->id_estado = 5; // Visto
            $solicitud->fecha_revision = \Carbon\Carbon::now();
            $solicitud->save();
            return redirect()->back()->with('success', 'Solicitud marcada como vista.');
        }
        return redirect()->back()->with('error', 'Solicitud no encontrada.');
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
        \Illuminate\Support\Facades\Log::info('SolicitudCompra store initiated', $request->all());

        $request->validate([
            'nit_empresa' => 'required|numeric|digits_between:8,15|unique:solicitud_compra,nit_empresa',
            'nombre_empresa' => 'required|max:200|unique:solicitud_compra,nombre_empresa',
            'nombre_repre_legal' => 'required|max:150',
            'telefono' => 'required|numeric|digits_between:7,10|unique:solicitud_compra,telefono',
            'correo' => 'required|email|max:150|unique:solicitud_compra,correo',
            'direccion' => 'required|max:200',
            'comprobante_pago' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'licencia_id' => 'required|exists:tipo_licencia,id_tipo_licencia',
        ]);

        // Handle File Upload
        if ($request->hasFile('comprobante_pago')) {
            $image = $request->file('comprobante_pago');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('comprobantes'), $imageName);
            $comprobantePath = 'comprobantes/' . $imageName;
        }


        $superAdmin = SuperAdmin::first();
        $superAdminId = $superAdmin ? $superAdmin->id_super_admin : 0; // Fallback or handle error

        SolicitudCompra::create([
            'nit_empresa' => $request->nit_empresa,
            'nombre_empresa' => $request->nombre_empresa,
            'nombre_repre_legal' => $request->nombre_repre_legal,
            'telefono' => $request->telefono,
            'correo' => $request->correo,
            'direccion' => $request->direccion,
            'comprobante_pago' => $comprobantePath,
            'id_super_admin' => $superAdminId,
            'id_estado' => 1, // Pendiente
            'fecha_solicitud' => Carbon::now(),
            'id_tipo_licencia' => $request->licencia_id,
        ]);

        return redirect('/')->with('success', 'Solicitud enviada exitosamente. Estaremos en contacto.');
    }
}
