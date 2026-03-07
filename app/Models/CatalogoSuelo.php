<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CatalogoSuelo extends Model
{
    protected $table = 'catalogo_suelos';
    protected $fillable = ['nombre', 'impacto_dias', 'descripcion'];
}
