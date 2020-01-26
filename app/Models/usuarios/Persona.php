<?php

namespace App\Models\usuarios;

use Illuminate\Database\Eloquent\Model;

class Persona extends Model{
    protected $table = 'usuarios.persona';
    protected $primaryKey = 'id_persona';

    public static function getDatosPersona($rut){
        $persona = Persona::select("nombres", "apellido_paterno", "apellido_materno")
            ->where("rut",  "=", $rut)->get()->first();

        return $persona->nombres . " " . $persona->apellido_paterno . " " . $persona->apellido_materno;
    }
}
