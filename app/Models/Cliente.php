<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $table = "lvl_clientes";

    protected $fillable = [
        'id',
        'persona_id',
        'estado',
        'created_at',
        'updated_at',
    ];
}
