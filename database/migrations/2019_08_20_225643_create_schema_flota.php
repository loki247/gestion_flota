<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSchemaFlota extends Migration{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){
        Schema::create('flota.salon', function (Blueprint $table) {
            $table->increments('id_salon');
            $table->string('descripcion', 60);
            $table->string('nombre_corto', 10);
            $table->boolean('borrado')->nullable();
            $table->timestamps();
        });

        Schema::create('flota.bus', function (Blueprint $table) {
            $table->increments('id_bus');
            $table->string('patente', 6);
            $table->string('orden_interno', 15)->nullable();
            $table->string('num_motor', 255);
            $table->string('num_chasis', 255);
            $table->integer('id_salon');
            $table->integer('capacidad');
            $table->boolean('borrado')->nullable();
            $table->timestamps();
        });

        Schema::create('flota.mantencion', function (Blueprint $table) {
            $table->increments('id_mantencion');
            $table->integer('id_bus');
            $table->text('descripcion');
            $table->integer('id_estado');
            $table->boolean('borrado')->nullable();
            $table->timestamps();
        });

        Schema::create('flota.estado_mantencion', function (Blueprint $table) {
            $table->increments('id_estado');
            $table->string('descripcion', 50);
        });

        Schema::create('flota.orden_compra', function (Blueprint $table) {
            $table->increments('id_orden');
            $table->integer('id_mantencion');
            $table->text('detalle');
            $table->integer('id_estado');
            $table->boolean('borrado')->nullable();
            $table->timestamps();
        });

        Schema::create('flota.estado_orden_compra', function (Blueprint $table) {
            $table->increments('id_estado');
            $table->string('descripcion', 50);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(){
        Schema::dropIfExists('flota.salon');
        Schema::dropIfExists('flota.bus');
        Schema::dropIfExists('flota.mantencion');
    }
}
