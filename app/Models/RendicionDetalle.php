<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RendicionDetalle extends Model
{
    use HasFactory;

    protected $table = "lvl_rendiciones_detalle";

    /*protected $fillable = [
                        'id',
                        'apellidos',
                        'nombres',
                        'dni',
                        'celular',
                        'email' ,
                        'created_at',
                        'updated_at',
        ];*/
}
