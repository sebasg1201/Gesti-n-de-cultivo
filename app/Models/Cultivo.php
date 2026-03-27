<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cultivo extends Model
{
    use HasFactory;

    protected $table = 'cultivo';
    protected $primaryKey = 'id_cultivo';
    public $timestamps = false;

    protected $fillable = [
        'id_estado',
        'fecha_recoleccion',
        'id_cosecha',
        'documento_trabajador',
        'descripcion_recoleccion'
    ];

    public function cosecha()
    {
        return $this->belongsTo(Cosecha::class, 'id_cosecha', 'id_cosecha');
    }

    public function trabajador()
    {
        return $this->belongsTo(Usuario::class, 'documento_trabajador', 'documento');
    }

    public function detalles()
    {
        return $this->hasMany(DetalleProductoCultivo::class, 'id_cultivo', 'id_cultivo');
    }
}
