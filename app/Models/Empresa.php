<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    use HasFactory;

    protected $table = 'empresa';
    protected $primaryKey = 'id_empresa';

    public $incrementing = false; // 🔥 IMPORTANTE
    protected $keyType = 'string'; // porque NIT puede ser string

    public $timestamps = false;

    const CREATED_AT = 'fecha_creacion';
    const UPDATED_AT = null;

    protected $fillable = [
        'id_empresa',
        'nombre_empresa',
        'nombre_repre_legal',
        'cedula_repre',
        'telefono',
        'correo',
        'direccion',
        'id_estado',
        'fecha_creacion'
    ];

    public function estado()
    {
        return $this->belongsTo(Estado::class, 'id_estado', 'id_estado');
    }

    public function licencia()
    {
        return $this->hasOne(VentaLicencias::class, 'id_empresa', 'id_empresa')->latest('fecha_inicio');
    }
}
