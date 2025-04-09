<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    use HasFactory;
    protected $table = "lvl_proveedores";

    protected $fillable = [
        'id',
        'nombre_fantasia',
        'cuit',
        'celular',
        'email',
        'domicilio',
        'nro',
        'piso',
        'dpto',
        'estado',
        'created_at',
        'updated_at',
    ];
}
