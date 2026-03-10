<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    protected $table = 'proveedor';
    protected $primaryKey = 'id_proveedor';
    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'producto',
        'contacto',
        'id_empresa',
        'ID_insumo'
    ];

    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'id_empresa', 'id_empresa');
    }

    public function entradas()
    {
        return $this->hasMany(EntradaInsumo::class, 'id_proveedor', 'id_proveedor');
    }
}