<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    protected $table = 'producto';
    protected $primaryKey = 'id_producto';
    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'Codigo_Referencia',
        'descripcion'
    ];

    public function detalles()
    {
        return $this->hasMany(DetalleProductoCultivo::class, 'id_producto', 'id_producto');
    }
}
