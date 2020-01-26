<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
        // $this->call(UsersTableSeeder::class);

        //Usuarios
        DB::table('usuarios.roles')->insert([
            'descripcion' => 'Administrador',
        ]);

        DB::table('usuarios.roles')->insert([
            'descripcion' => 'RRHH',
        ]);

        DB::table('usuarios.roles')->insert([
            'descripcion' => 'Gerente',
        ]);

        DB::table('usuarios.roles')->insert([
            'descripcion' => 'Liquidaciones',
        ]);

        DB::table('usuarios.roles')->insert([
            'descripcion' => 'Conductor',
        ]);

        DB::table('usuarios.roles')->insert([
            'descripcion' => 'Asistente',
        ]);

        DB::table('usuarios.roles')->insert([
            'descripcion' => 'Mantención',
        ]);

        DB::table('usuarios.persona')->insert([
            'rut' => '18435938',
            'dv' => '3',
            'nombres' => 'Felipe Andres',
            'apellido_paterno' => 'Rodríguez',
            'apellido_materno' => 'Muñoz',
            'direccion' => '7 Poniente 140',
            'telefono' => '954459723',
            'email' => 'rodriguezmunoz92@gmail.com',
            'ciudad' => 'Temuco',
        ]);

        DB::table('usuarios.users')->insert([
            'id_persona' => 1,
            'email' => 'rodriguezmunoz92@gmail.com',
            'rut' => '18435938',
            'password' => bcrypt('felipe'),
            'activo' => true,
        ]);

        DB::table('usuarios.rol_usuario')->insert([
            'id_usuario' => 1,
            'id_rol' => 1
        ]);

        //Flota
        DB::table('flota.salon')->insert([
            'descripcion' => 'Clásico',
            'nombre_corto' => 'cls',
            'borrado' => false
        ]);

        DB::table('flota.salon')->insert([
            'descripcion' => 'Ejecutivo',
            'nombre_corto' => 'ejc',
            'borrado' => false
        ]);

        DB::table('flota.salon')->insert([
            'descripcion' => 'Semi-Cama',
            'nombre_corto' => 'smc',
            'borrado' => false
        ]);

        DB::table('flota.salon')->insert([
            'descripcion' => 'Cama',
            'nombre_corto' => 'sc',
            'borrado' => false
        ]);

        DB::table('flota.salon')->insert([
            'descripcion' => 'Cama-Premium',
            'nombre_corto' => 'cmp',
            'borrado' => false
        ]);

        DB::table('flota.estado_mantencion')->insert([
            'descripcion' => 'Agendada',
        ]);

        DB::table('flota.estado_mantencion')->insert([
            'descripcion' => 'Realizada',
        ]);

        DB::table('flota.estado_mantencion')->insert([
            'descripcion' => 'Realizada con Observaciones',
        ]);

        DB::table('flota.estado_mantencion')->insert([
            'descripcion' => 'Cancelada',
        ]);

        DB::table('flota.estado_orden_compra')->insert([
            'descripcion' => 'Ingresada',
        ]);

        DB::table('flota.estado_orden_compra')->insert([
            'descripcion' => 'Realizada',
        ]);
    }
}
