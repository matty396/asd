<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class archivoDeudaDetalle extends Model
{
    use HasFactory;

    protected $table = "lvl_archivos_deudas_detalles";

    protected $fillable = [
        'socio_nro',
        'id_servicio',
        'vto_1','vto_2','vto_3',
        'importe_1','importe_2','importe_3',
        'archivo_deuda_id'];
}
