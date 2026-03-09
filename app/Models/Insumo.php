<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Insumo extends Model
{
    use HasFactory;

    protected $table = 'insumo';
    protected $primaryKey = 'ID_insumo';

    protected $fillable = [
        'Nombre',
        'id_tipo_insumo',
        'Calidad',
        'cantidad_stock',
        'Fecha_ingreso',
        'Fecha_vencimiento',
        'descripcion',
        'id_proveedor',
        'id_empresa',
    ];

    protected $casts = [
        'Fecha_ingreso' => 'date',
        'Fecha_vencimiento' => 'date',
    ];

    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class, 'id_proveedor');
    }

    public function tipo()
    {
        return $this->belongsTo(TipoInsumo::class, 'id_tipo_insumo', 'id_tipo_insumo');
    }
}