<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    use HasFactory;
    protected $table = "lvl_personas";

    protected $fillable = [
        'id',
        'apellidos',
        'nombres',
        'dni',
        'celular',
        'email',
        'fecha_nacimiento',
        'domicilio',
        'nro',
        'piso',
        'dpto',
        'created_at',
        'updated_at',
    ];
}


