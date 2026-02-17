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
        $solicitudes = SolicitudCompra::with(['tipoLicencia', 'estado', 'superAdmin'])
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
        'cedula_repre' => 'required||numeric|digits_between:8,11',
        'telefono' => 'required|numeric|digits_between:8,11',
        'correo' => 'required|email|max:150',
        'direccion' => 'required|string|max:200',
        'comprobante_pago' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        'licencia_id' => 'required|exists:tipo_licencia,id_tipo_licencia',
    ]);



        //CREAR EMPRESA


        $empresa = Empresa::firstOrCreate(
            ['id_empresa' => $request->nit_empresa],
            [
                'nombre_empresa' => $request->nombre_empresa,
                'nombre_repre_legal' => $request->nombre_repre_legal,
                'cedula_repre' => $request->cedula_repre, // ✅ CORREGIDO
                'telefono' => $request->telefono,
                'correo' => $request->correo,
                'direccion' => $request->direccion,
                'id_estado' => 1,
                'fecha_creacion' => now()
            ]
        );


        //GUARDAR COMPROBANTE


        $image = $request->file('comprobante_pago');
        $imageName = time() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('comprobantes'), $imageName);


        //SUPER ADMIN


        $superAdmin = SuperAdmin::first();
        $superAdminId = $superAdmin ? $superAdmin->id_super_admin : null;


        //CREAR SOLICITUD


        SolicitudCompra::create([
            'nit_empresa' => $empresa->id_empresa,
            'comprobante_pago' => 'comprobantes/' . $imageName,
            'id_estado' => 1,
            'fecha_solicitud' => now(),
            'id_tipo_licencia' => $request->licencia_id
        ]);

        return redirect('/')->with('success', 'Solicitud enviada correctamente');
    }
}
