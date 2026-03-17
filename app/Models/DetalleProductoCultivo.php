<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleProductoCultivo extends Model
{
    use HasFactory;

    protected $table = 'detalle_producto_cultivo';
    protected $primaryKey = 'id_detalle';
    public $timestamps = false;

    protected $fillable = [
        'id_cultivo',
        'id_producto',
        'cantidad',
        'calidad'
    ];

    public function cultivo()
    {
        return $this->belongsTo(Cultivo::class, 'id_cultivo', 'id_cultivo');
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'id_producto', 'id_producto');
    }
}
