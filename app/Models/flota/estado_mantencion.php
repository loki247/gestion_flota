<?php

namespace App\Models\flota;

use Illuminate\Database\Eloquent\Model;

class estado_mantencion extends Model{

    protected $table = "flota.estado_mantencion";
    protected $primaryKey = "id_estado";

    public static function getEstados(){
        $estados = estado_mantencion::all();

        return $estados;
    }
}
