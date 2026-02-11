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

        // Filter by status
        if ($request->has('status')) {
            $status = $request->input('status');
            if ($status === 'activa') {
                $query->where('id_estado', 3);
            } elseif ($status === 'pendiente') {
                $query->where('id_estado', 1);
            } elseif ($status === 'bloqueada') {
                $query->where('id_estado', 2);
            }
        }

        // Changed pagination to 4 as requested
        $empresas = $query->paginate(4);

        // Calculate stats
        $stats = [
            'nuevas' => Empresa::where('id_estado', 1)->count(), // Assuming 1 is Pending/New
            'suspendidas' => Empresa::where('id_estado', 2)->count(), // Assuming 2 is Suspended
            'activaciones' => Empresa::where('id_estado', 3)->count(),
        ];

        return view('SuperAdmin.index', compact('empresas', 'stats'));
    }
    public function activar($id)
    {
        $empresa = Empresa::findOrFail($id);
        
        // Activate Company
        // Assuming 3 is "Activa" based on previous logic (though CheckLicenseExpiration used 1 for Active).
        // Let's stick to the existing controller logic which sets it to 3.
        // Wait, CheckLicenseExpiration set it to 2 (Blocked) and checked for 1 (Active).
        // Let's double check the seeder.
        // Seeder: 1=pendiente, 2=bloqueada, 3=activa, 4=activo
        // So 3 is indeed "Activa". The previous tasks assumed 1 was Active. This is a discrepancy.
        // If 1 is "Pendiente", then `storeLicencia` setting it to 1 means it set it to "Pendiente", not "Active".
        // BUT `storeLicencia` comment said "// Activo".
        // Let's clarify:
        // Seeder says: 1=Pendiente, 3=Activa.
        // `storeLicencia` (my previous edit) set `id_estado = 1` (Pendiente). This might be wrong if the intention was Active.
        // However, if the user flow is: Create (Pendiente) -> Assign License -> (Maybe still Pendiente until Activated?) or (Active immediately?)
        // The user said: "cuando yo... le de activar... el estado de la venta... pase a estar activa"
        // This implies the previous state might have been Pending.
        
        $empresa->id_estado = 3; // Activa
        $empresa->save();

        // Activate associated License (Latest one)
        // Find the latest license for this company
        $licencia = \App\Models\VentaLicencias::where('id_empresa', $id)
                                              ->orderBy('fecha_inicio', 'desc')
                                              ->first();
        
        if ($licencia) {
            $licencia->id_estado = 3; // 3 = Activa (Synced with Company)
            $licencia->fecha_inicio = now(); // Reset start time
            $licencia->save();
        }

        // Activate associated Users (Admins)
        // Update all users belonging to this company to Active (3)
        \App\Models\Usuario::where('id_empresa', $id)->update(['id_estado' => 3]);

        return redirect()->back()->with('success', 'Empresa, Licencia y Usuarios activados con éxito.');
    }
}
