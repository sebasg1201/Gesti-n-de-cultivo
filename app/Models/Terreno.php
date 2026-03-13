<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Terreno extends Model
{
    use HasFactory;

    protected $table = 'terreno';
    protected $primaryKey = 'id_terreno';
    public $timestamps = false;

    protected $fillable = [
        'id_empresa',
        'nombre',
        'ubicacion',
        'latitud',
        'longitud',
        'Ancho',
        'Alto',
        'area_m2',
        'id_estado',
        'id_tipo_suelo'
    ];

    public function tipoSuelo()
    {
        return $this->belongsTo(TipoSuelo::class, 'id_tipo_suelo', 'id_tipo_suelo');
    }

    public function estado()
    {
        return $this->belongsTo(Estado::class, 'id_estado', 'id_estado');
    }
}
