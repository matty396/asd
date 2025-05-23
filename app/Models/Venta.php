<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    use HasFactory;
    protected $table = "lvl_ventas";

    protected $fillable = [
        'id',
        'cliente_id',
        'fecha',
        'total',
        'pago',
        'created_at',
        'updated_at',
    ];
}
