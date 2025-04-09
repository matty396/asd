<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Caja extends Model
{
    use HasFactory;

    protected $table = "lvl_caja";

    protected $fillable = [
        'id',
        'inicial',
        'ventas',
        'compras',
        'gastos',
        'total',
        'fecha_desde',
        'fecha_hasta',
        'created_at',
        'updated_at',
    ];
}
