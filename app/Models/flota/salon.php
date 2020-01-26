<?php

namespace App\Models\flota;

use Illuminate\Database\Eloquent\Model;

class salon extends Model{
    protected $table = "flota.salon";
    protected $primaryKey = "id_salon";

    public static function getSalones(){
        $salones = salon::select("id_salon", "descripcion", "nombre_corto")
                    ->where("borrado", "=", false)->orderBy("id_salon", "asc")->get();

        return $salones;
    }

    public static function getSalonById($id_salon){
        $salon = salon::where("id_salon", "=", $id_salon)->first();

        return $salon;
    }

    public static function saveSalon($data){
        $salon = new salon();
        $salon->descripcion = $data->descripcion;

        $salon->save();

        return $salon->id_salon;
    }

    public static function editSalon($data){
        salon::where("id_salon", "=", $data->id_salon)
            ->update([
               'descripcion' => $data->descripcion,
               'nombre_corto' => $data->nombre_corto
            ]);
    }

    public static function deleteSalon($id_salon){
        salon::where("id_salon", "=", $id_salon)
            ->update([
                'borrado' => true,
            ]);
    }
}
