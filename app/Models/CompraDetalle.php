<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompraDetalle extends Model
{
    use HasFactory;
    protected $table = "lvl_compras_detalle";

    protected $fillable = [
        'id',
        'compra_id',
        'mercaderia_id',
        'descripcion',
        'codigo',
        'monto',
        'codigo',
        'cantidad',
        'created_at',
        'updated_at',
    ];
}
