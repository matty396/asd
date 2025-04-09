<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gasto extends Model
{
    use HasFactory;
    protected $table = "lvl_gastos";

    protected $fillable = [
        'id',
        'descripcion',
        'monto',
        'comentarios',
        'fecha',
        'created_at',
        'updated_at',
    ];
}
