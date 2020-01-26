<?php

namespace App\Models\flota;

use Illuminate\Database\Eloquent\Model;

class estado_orden_compra extends Model{

    protected $table = "flota.estado_orden_compra";
    protected $primaryKey = "id_estado";

    public static function getEstados(){
        $estados = estado_orden_compra::all();

        return $estados;
    }

}
