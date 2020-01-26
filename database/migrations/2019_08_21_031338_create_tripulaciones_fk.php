<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTripulacionesFk extends Migration{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){
        Schema::table('tripulaciones.tripulante', function (Blueprint $table) {

            //Relación tripulante-bus
            $table->foreign('id_bus', 'fk_tripulante_bus')->references('id_bus')->on('flota.bus')->onDelete('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(){

    }
}
