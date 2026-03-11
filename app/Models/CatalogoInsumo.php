<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CatalogoInsumo extends Model
{
    use HasFactory;

    protected $table = 'catalogo_insumos';
    protected $primaryKey = 'id_catalogo_insumo';
    public $timestamps = false;

    protected $fillable = [
        'nombre_comercial',
        'descripcion',
        'impacto_dias',
        'id_tipo_insumo'
    ];

    public function tipoInsumo()
    {
        return $this->belongsTo(TipoInsumo::class, 'id_tipo_insumo');
    }
}
