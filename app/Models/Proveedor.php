<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Proveedor extends Model
{
    use HasFactory;

    protected $table = 'proveedor';
    protected $primaryKey = 'id_proveedor';

    protected $fillable = [
        'nombre',
        'correo',
        'telefono',
        'id_empresa',
    ];

    public function insumo()
    {
        return $this->hasMany(Insumo::class, 'id_proveedor');
    }
}