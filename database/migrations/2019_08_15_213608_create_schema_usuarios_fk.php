<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSchemaUsuariosFk extends Migration{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){
        Schema::table('usuarios.users', function (Blueprint $table) {
            //Relación usuario-persona
            $table->foreign('id_persona', 'fk_usuario_persona')->references('id_persona')->on('usuarios.persona')->onUpdate('CASCADE')->onDelete('CASCADE');
        });

        Schema::table('usuarios.rol_usuario', function (Blueprint $table) {
            //Relación rol_usuario-usuario
            $table->foreign('id_usuario', 'fk_rol_usuario_usuario')->references('id_user')->on('usuarios.users');

            //Relación rol_usuario.rol
            $table->foreign('id_rol', 'fk_rol_usuario_rol')->references('id_rol')->on('usuarios.roles');
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
