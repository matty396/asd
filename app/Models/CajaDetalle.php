<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CajaDetalle extends Model
{
    use HasFactory;

    protected $table = "lvl_caja_detalle";

    protected $fillable = [
        'id',
        'caja_id',
        'tipooperacion_id',
        'concepto',
        'codigo',
        'monto',
        'cantidad',
        'created_at',
        'updated_at',
    ];
}
