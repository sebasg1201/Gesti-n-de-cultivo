<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EntradaInsumo extends Model
{
    protected $table = 'entrada_insumo';
    protected $primaryKey = 'id_entrada';
    public $timestamps = false;

    protected $fillable = [
        'id_proveedor',
        'id_insumo',
        'id_semilla',
        'id_empresa',
        'cantidad_recibida',
        'fecha_entrada',
        'precio_unitario'
    ];

    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class, 'id_proveedor', 'id_proveedor');
    }

    public function insumo()
    {
        return $this->belongsTo(Insumo::class, 'id_insumo', 'ID_insumo');
    }

    public function semilla()
    {
        return $this->belongsTo(TipoSemilla::class, 'id_semilla', 'id_semilla');
    }
}
