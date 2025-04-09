<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compra extends Model
{
    use HasFactory;
    protected $table = "lvl_compras";

    protected $fillable = [
        'id',
        'proveedor_id',
        'fecha',
        'total',
        'pago',
        'created_at',
        'updated_at',
    ];
}
