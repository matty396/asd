<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rendicion extends Model
{
    use HasFactory;

    protected $table = "lvl_rendiciones";

    protected $fillable = [
                        'tipo_registro_pie',
                        /*'apellidos',
                        'nombres',
                        'dni',
                        'celular',
                        'email' ,
                        'created_at',
                        'updated_at',*/
        ];
}
