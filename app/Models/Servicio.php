<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Servicio extends Model
{
    use HasFactory;

    protected $table = "lvl_servicios";

    protected $fillable = [
            'id',
            'nombre',
            'monto',
            'observaciones',
            'created_at',
            'updated_at',
    ];
}
