<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoInsumo extends Model
{
    use HasFactory;

    protected $table = 'tipo_insumo';
    protected $primaryKey = 'id_tipo_insumo';
    public $timestamps = false;

    protected $fillable = [
        'id_empresa',
        'id_catalogo',
        'nombre_insumo',
        'descripcion'
    ];

    public function catalogo()
    {
        return $this->belongsTo(CatalogoInsumo::class, 'id_catalogo');
    }

    public function insumos()
    {
        return $this->hasMany(Insumo::class, 'id_tipo_insumo', 'id_tipo_insumo');
    }
}
