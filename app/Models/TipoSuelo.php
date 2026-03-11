<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoSuelo extends Model
{
    use HasFactory;

    protected $table = 'tipo_suelo';
    protected $primaryKey = 'id_tipo_suelo';
    public $timestamps = false;

    protected $fillable = [
        'id_empresa',
        'id_catalogo',
        'nombre',
        'descripcion',
        'impacto_dias'
    ];

    public function catalogo()
    {
        return $this->belongsTo(CatalogoSuelo::class, 'id_catalogo');
    }
}
