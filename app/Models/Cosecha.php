<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cosecha extends Model
{
    use HasFactory;

    protected $table = 'cosecha';
    protected $primaryKey = 'id_cosecha';
    public $timestamps = false;

    protected $fillable = [
        'id_empresa',
        'Cantidad',
        'id_terreno',
        'id_semilla',
        'id_estado',
        'fecha_siembra',
        'frecuencia_riego_dias',
        'fecha_estimada',
        'produccion_estimada',
        'litros_por_riego',
        'imagenes'
    ];

    public function tipoCosecha()
    {
        return $this->belongsTo(TipoCosecha::class, 'id_tipo_cosecha', 'id_tipo_cosecha');
    }

    public function terreno()
    {
        return $this->belongsTo(Terreno::class, 'id_terreno', 'id_terreno');
    }

    public function semilla()
    {
        return $this->belongsTo(TipoSemilla::class, 'id_semilla', 'id_semilla');
    }

    public function getPorcentajeCrecimientoAttribute() {
        if (!$this->fecha_estimada) return 0;
        
        $inicio = \Carbon\Carbon::parse($this->fecha_siembra);
        $fin = \Carbon\Carbon::parse($this->fecha_estimada);
        $hoy = \Carbon\Carbon::now();
        
        if($fin->lessThanOrEqualTo($inicio)) return 100;
        
        $totalDias = $inicio->diffInDays($fin);
        $diasTranscurridos = $inicio->diffInDays($hoy, false);
        
        if($diasTranscurridos <= 0) return 0;
        if($diasTranscurridos >= $totalDias) return 100;
        
        return ($diasTranscurridos / $totalDias) * 100;
    }
    
    public function getProgresoHidratacionAttribute() {
        $hoy = \Carbon\Carbon::now()->format('Y-m-d');
        
        $ultimoRiego = \App\Models\Riego::where('id_cosecha', $this->id_cosecha)
            ->whereDate('fecha_programada', '<=', $hoy)
            ->orderBy('fecha_programada', 'desc')
            ->first();
            
        if(!$ultimoRiego) return 100; 
        
        // Si el estado es distinto de "Pendiente" (1), significa que ya se completó.
        if($ultimoRiego->id_estado != 1) {
            return 100;
        }
        
        return 0; // Si está pendiente, la barra está vacía esperando al trabajador
    }
}
