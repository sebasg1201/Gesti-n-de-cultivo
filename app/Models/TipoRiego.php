<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoRiego extends Model
{
    use HasFactory;

    protected $table = 'tipo_riego';
    protected $primaryKey = 'id_tipo_riego';
    public $timestamps = false;

    protected $fillable = [
        'id_empresa',
        'id_catalogo',
        'tipo_riego',
        'impacto_dias',
        'cant_agua_apl'
    ];

    public function catalogo()
    {
        return $this->belongsTo(CatalogoRiego::class, 'id_catalogo');
    }
    public function riegos()
    {
        return $this->hasMany(Riego::class, 'id_tipo_riego', 'id_tipo_riego');
    }
}
