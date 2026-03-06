<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\VentaLicencias;
use Carbon\Carbon;

class CheckLicenseExpiration
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Solo apliar para usuarios autenticados
        if (Auth::guard('usuario')->check()) {
            $usuario = Auth::guard('usuario')->user();
            
            // Si intenta acceder a licencia expirada o cerrar sesión, dejalo pasar
            if ($request->routeIs('licencia.expirada') || $request->routeIs('usuario.logout')) {
                return $next($request);
            }

            $licenciaActiva = VentaLicencias::with('tipoLicencia')
                ->where('id_empresa', $usuario->id_empresa)
                ->latest('fecha_inicio')
                ->first();

            $fechaFin = null;
            $expirado = true;

            if ($licenciaActiva && $licenciaActiva->tipoLicencia) {
                $tiempoText = strtolower(trim($licenciaActiva->tipoLicencia->tiempo));
                $cantidad = (int) filter_var($tiempoText, FILTER_SANITIZE_NUMBER_INT);
                if ($cantidad === 0) {
                    $cantidad = 1;
                }

                $fechaInicio = Carbon::parse($licenciaActiva->fecha_inicio);
                
                if (str_contains($tiempoText, 'año') || str_contains($tiempoText, 'ano')) {
                    $fechaFin = $fechaInicio->copy()->addYears($cantidad);
                } elseif (str_contains($tiempoText, 'día') || str_contains($tiempoText, 'dia')) {
                    $fechaFin = $fechaInicio->copy()->addDays($cantidad);
                } else {
                    // Default a meses
                    $fechaFin = $fechaInicio->copy()->addMonths($cantidad);
                }

                $diasRestantes = (int) ceil(now()->startOfDay()->diffInDays($fechaFin->copy()->endOfDay(), false));

                // La licencia está activa (id_estado = 3) y aún no expiró por tiempo
                if ($licenciaActiva->id_estado == 3 && $diasRestantes >= 0) {
                    $expirado = false;
                }
            }

            if ($expirado) {
                // Return to expired view
                session()->put('fecha_expiracion', $fechaFin ? $fechaFin->format('d \d\e M, Y') : 'Desconocida');
                return redirect()->route('licencia.expirada');
            }
        }

        return $next($request);
    }
}
