<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){
        Schema::create('usuarios.persona', function (Blueprint $table) {
            $table->increments('id_persona');
            $table->integer('rut');
            $table->string('dv', 1);
            $table->string('nombres', 60);
            $table->string('apellido_paterno', 60);
            $table->string('apellido_materno', 60);
            $table->string('direccion', 80);
            $table->integer('telefono');
            $table->string('email')->nullable();
            $table->string('ciudad');
            $table->timestamps();
        });

        Schema::create('usuarios.users', function (Blueprint $table) {
            $table->increments('id_user');
            $table->integer('id_persona');
            $table->string('email', 60);
            $table->integer('rut');
            $table->text('password');
            $table->boolean('activo');
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('usuarios.roles', function (Blueprint $table){
           $table->increments('id_rol');
           $table->string('descripcion');
           $table->timestamps();
        });

        Schema::create('usuarios.rol_usuario', function (Blueprint $table) {
            $table->increments('id_rou');
            $table->integer('id_usuario');
            $table->integer('id_rol');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(){
        Schema::dropIfExists('usuarios.persona');
        Schema::dropIfExists('usuarios.users');
        Schema::dropIfExists('usuarios.roles');
        Schema::dropIfExists('usuarios.rol_usuario');
    }
}
