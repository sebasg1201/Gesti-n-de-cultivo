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
        'nombre',
        'id_empresa'
    ];

    public function catalogos()
    {
        return $this->hasMany(CatalogoInsumo::class, 'id_tipo_insumo');
    }
}
