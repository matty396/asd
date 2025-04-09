<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mercaderia extends Model
{
    use HasFactory;

    protected $table = "lvl_mercaderias";

    protected $fillable = [
        'id',
        'codigo',
        'descripcion',
        'alto',
        'ancho',
        'profundidad',
        'peso',
        'unidad_medida',
        'unidad_peso',
        'precio',
        'created_at',
        'updated_at',
    ];
}
