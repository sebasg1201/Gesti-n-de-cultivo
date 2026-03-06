<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cosecha extends Model
{
    use HasFactory;

    protected $table = 'cosecha';
    protected $primaryKey = 'id_cosecha';
    public $timestamps = false;

    protected $fillable = [
        'Cantidad',
        'fecha_inicio',
        'fecha_fin',
        'id_tipo_cosecha',
        'id_empresa'
    ];

    public function tipoCosecha()
    {
        return $this->belongsTo(TipoCosecha::class, 'id_tipo_cosecha', 'id_tipo_cosecha');
    }
}
