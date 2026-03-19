<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Insumo extends Model
{
    use HasFactory;

    protected $table = 'insumo';
    protected $primaryKey = 'ID_insumo';
    public $timestamps = true;

    protected $fillable = [
        'id_empresa',
        'id_catalogo_insumo',
        'id_tipo_semilla',
        'stock_actual',
        'Nombre',
        'Calidad',
        'Fecha_ingreso',
        'Fecha_vencimiento',
        'descripcion',
        'id_proveedor',
        'impacto_dias'
    ];

    public function catalogo()
    {
        return $this->belongsTo(CatalogoInsumo::class, 'id_catalogo_insumo');
    }

    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'id_empresa', 'id_empresa');
    }
}
