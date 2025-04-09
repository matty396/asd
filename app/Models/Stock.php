<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;

    protected $table = "lvl_stock";

    protected $fillable = [
        'id',
        'mercaderia_id',
        'codigo',
        'cantidad',
        'cantidad_minima',
        'cantidad_maxima',
        'estado',
        'fecha_ingreso',
        'created_at',
        'updated_at',
    ];
}
