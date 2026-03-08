<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CatalogoRiego extends Model
{
    protected $table = 'catalogo_riegos';
    protected $fillable = ['nombre', 'impacto_dias', 'descripcion_tecnica'];
}
