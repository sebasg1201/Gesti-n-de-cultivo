<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CatalogoInsumo extends Model
{
    use HasFactory;

    protected $table = 'catalogo_insumos';
    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'descripcion'
    ];
}
