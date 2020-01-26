<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFlotaFk extends Migration{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){
        Schema::table('flota.bus', function (Blueprint $table) {

            //Relación bus-salon
            $table->foreign('id_salon', 'fk_bus_salon')->references('id_salon')->on('flota.salon')->onDelete('RESTRICT');
        });

        Schema::table('flota.mantencion', function (Blueprint $table) {

            //Relación mantención-bus
            $table->foreign('id_bus', 'fk_mantencion_bus')->references('id_bus')->on('flota.bus')->onDelete('RESTRICT');
        });

        Schema::table('flota.mantencion', function (Blueprint $table) {

            //Relación mantención-estado_mantención
            $table->foreign('id_estado', 'fk_mantencion_estado')->references('id_estado')->on('flota.estado_mantencion');
        });

        Schema::table('flota.orden_compra', function (Blueprint $table) {

            //Relación orden_compra-mantención
            $table->foreign('id_mantencion', 'fk_orden_compra_mantencion')->references('id_mantencion')->on('flota.mantencion');

            //Relación orden_compra-estado_orden_compra
            $table->foreign('id_estado', 'fk_orden_compra_estado')->references('id_estado')->on('flota.estado_orden_compra');
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
