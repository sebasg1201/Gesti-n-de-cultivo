<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Models\VentaLicencias;
use App\Models\TipoLicencia;
use Carbon\Carbon;
use App\Mail\ContactoSuperAdmin;

class TipoLicenciaController extends Controller
{
    public function index()
    {
        $usuario = Auth::guard('usuario')->user();
        
        $licenciaActiva = VentaLicencias::with('tipoLicencia')
            ->where('id_empresa', $usuario->id_empresa)
            ->latest('fecha_inicio')
            ->first();

        $diasRestantes = 0;
        $fechaFin = null;

        if ($licenciaActiva && $licenciaActiva->tipoLicencia) {
            $tiempoText = strtolower(trim($licenciaActiva->tipoLicencia->tiempo));
            $cantidad = (int) filter_var($tiempoText, FILTER_SANITIZE_NUMBER_INT);
            if ($cantidad === 0) {
                $cantidad = 1; // Default to 1 if no number is found
            }

            $fechaInicio = Carbon::parse($licenciaActiva->fecha_inicio);
            
            if (str_contains($tiempoText, 'año') || str_contains($tiempoText, 'ano')) {
                $fechaFin = $fechaInicio->copy()->addYears($cantidad);
            } elseif (str_contains($tiempoText, 'día') || str_contains($tiempoText, 'dia')) {
                $fechaFin = $fechaInicio->copy()->addDays($cantidad);
            } else {
                // Default to months
                $fechaFin = $fechaInicio->copy()->addMonths($cantidad);
            }

            $diasRestantes = (int) ceil(now()->diffInDays($fechaFin, false)); // false allows negative values
        }

        $planesDisponibles = TipoLicencia::all();

        return view('admin.tipo_licencias.index', compact('licenciaActiva', 'diasRestantes', 'fechaFin', 'planesDisponibles'));
    }

    public function contacto(Request $request)
    {
        $usuario = Auth::guard('usuario')->user();
        
        $asunto = '';
        $mensaje = '';
        
        if ($request->has('cambiar_plan')) {
            $plan = TipoLicencia::find($request->cambiar_plan);
            if ($plan) {
                $asunto = 'Solicitud de Cambio de Plan a: ' . $plan->nombre_licencia;
                $mensaje = "Hola, me gustaría solicitar un cambio de mi plan actual al plan *" . $plan->nombre_licencia . "*.\nPor favor, indíqueme los pasos a seguir.\nMi NIT de empresa es: " . $usuario->id_empresa;
            }
        }

        return view('admin.tipo_licencias.contacto', compact('usuario', 'asunto', 'mensaje'));
    }

    public function enviarContacto(Request $request)
    {
        $request->validate([
            'asunto' => 'required|string|max:150',
            'mensaje' => 'required|string',
        ]);

        $usuario = Auth::guard('usuario')->user();

        $datosMail = [
            'nombre_usuario' => $usuario->nombre,
            'correo_usuario' => $usuario->correo,
            'id_empresa' => $usuario->id_empresa,
            'asunto' => $request->asunto,
            'mensaje' => $request->mensaje,
        ];

        Mail::to('agrotechsuper@gmail.com')->send(new ContactoSuperAdmin($datosMail));

        return redirect()->route('admin.licencias.index')
            ->with('success', 'El mensaje ha sido enviado a Agrotech. Te contactaremos pronto.');
    }

    public function licenciaExpirada()
    {
        $usuario = Auth::guard('usuario')->user();
        $fechaExpiracion = session('fecha_expiracion', 'Desconocida');

        return view('auth.licencia-expirada', compact('usuario', 'fechaExpiracion'));
    }
}
