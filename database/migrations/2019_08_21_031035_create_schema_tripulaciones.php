<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSchemaTripulaciones extends Migration{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){
        Schema::create('tripulaciones.tripulante', function (Blueprint $table) {
            $table->increments('id_tripulante');
            $table->integer('id_persona');
            $table->boolean('conductor');
            $table->boolean('asistente');
            $table->integer('id_bus');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(){
        Schema::dropIfExists('tripulaciones.tripulante');
    }
}
