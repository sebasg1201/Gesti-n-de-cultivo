<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VentaLicencias extends Model
{
    use HasFactory;

    protected $table = 'venta_licencias';
    protected $primaryKey = 'id_key';
    public $incrementing = false; // It's a varchar
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'id_key',
        'fecha_inicio',
        'observacione',
        'id_empresa',
        'id_tipo_licencia',
        'id_estado'
    ];

    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'id_empresa');
    }

    public function tipoLicencia()
    {
        return $this->belongsTo(TipoLicencia::class, 'id_tipo_licencia');
    }
}
