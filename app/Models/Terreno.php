<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Terreno extends Model
{
    use HasFactory;

    protected $table = 'terreno';
    protected $primaryKey = 'id_terreno';
    public $timestamps = true;

    protected $fillable = [
        'id_empresa',
        'nombre',
        'ubicacion',
        'latitud',
        'longitud',
        'Ancho',
        'Largo',
        'area_m2',
        'id_estado',
        'id_tipo_suelo',
        'departamento',
        'codigo_postal',
        'ciudad'
    ];

    public function tipoSuelo()
    {
        return $this->belongsTo(TipoSuelo::class, 'id_tipo_suelo', 'id_tipo_suelo');
    }

    public function estado()
    {
        return $this->belongsTo(Estado::class, 'id_estado', 'id_estado');
    }

    public function cosechas()
    {
        return $this->hasMany(Cosecha::class, 'id_terreno', 'id_terreno');
    }
}
