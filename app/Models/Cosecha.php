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
        if ($this->id_estado == 14) return 100;
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
            
        if ($this->id_estado == 10) return 0; // Programado
        
        if(!$ultimoRiego) return 100; 
        
        if($ultimoRiego->id_estado == 15) { // Realizado
            return 100;
        }
        
        if($ultimoRiego->id_estado == 17) { // En Proceso (id=17)
            return 50;
        }
        
        return 0; // Pendiente (1), Perdida (16) o cualquier otro
    }

    public function getFaseActualAttribute() {
        if ($this->id_estado == 14) return 'Finalizado';
        $porcentaje = $this->porcentaje_crecimiento;
        if ($porcentaje < 20) return 'Siembra';
        if ($porcentaje < 50) return 'Vegetativo';
        if ($porcentaje < 75) return 'Floración';
        if ($porcentaje < 90) return 'Llenado';
        return 'Cosecha';
    }

    public function cultivos()
    {
        return $this->hasMany(Cultivo::class, 'id_cosecha', 'id_cosecha');
    }

    public function riegos()
    {
        return $this->hasMany(Riego::class, 'id_cosecha', 'id_cosecha');
    }

    public function insumosCosecha()
    {
        return $this->hasMany(InsumoCosecha::class, 'id_cosecha', 'id_cosecha');
    }
}

