<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoSemilla extends Model
{
    use HasFactory;

    protected $table = 'tipo_semilla';
    protected $primaryKey = 'id_semilla';
    public $timestamps = false;

    protected $fillable = [
        'Tipo_semilla'
    ];
}
