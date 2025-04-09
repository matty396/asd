<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreateArchivoDeudasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('archivo_deudas', function (Blueprint $table) {
            $table->id();
			$table->int('id');
			$table->string('nombre');
			$table->timestamp('fecha_subida');
			$table->bool('estado');
			$table->int('cant_reg');
			$table->timestamp('created');
			$table->timestamp('updated');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('archivo_deudas');
    }
}
