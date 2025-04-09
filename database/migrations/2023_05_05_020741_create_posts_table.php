<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
			$table->int('id');
			$table->int('socio_nro');
			$table->int('id_servicio');
			$table->timestamp('vto_1');
			$table->double('importe_1');
			$table->timestamp('vto_2');
			$table->double('importe_2');
			$table->timestamp('vto_3');
			$table->double('importe_3');
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
        Schema::dropIfExists('posts');
    }
}
