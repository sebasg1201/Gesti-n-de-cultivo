<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CatalogoSemilla extends Model
{
    protected $table = 'catalogo_semillas';
    protected $fillable = ['nombre', 'descripcion', 'tiempo_base_dias', 'rendimiento_promedio'];
}
