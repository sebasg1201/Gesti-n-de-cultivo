<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoSemilla extends Model
{
    use HasFactory;

    protected $table = 'tipo_semilla';
    protected $primaryKey = 'id_semilla';
    public $timestamps = false;

    protected $fillable = [
        'id_empresa',
        'id_catalogo',
        'nombre_semilla',
        'tiempo_base_dias',
        'descripcion',
        'rendimiento_promedio',
        'stock_actual',
        'espacio_por_planta_m2'
    ];

    public function catalogo()
    {
        return $this->belongsTo(CatalogoSemilla::class, 'id_catalogo');
    }
}
