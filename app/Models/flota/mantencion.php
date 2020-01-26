<?php

namespace App\Models\flota;

use Illuminate\Database\Eloquent\Model;
use DB;

class mantencion extends Model{
    protected $table = "flota.mantencion";
    protected $primaryKey = "id_mantencion";

    public static function getMantenciones(){
        $mantenciones = mantencion::select("mantencion.id_mantencion",
            "bus.orden_interno",
            "mantencion.descripcion",
            "estado_mantencion.descripcion as estado",
            "mantencion.created_at")
            ->leftjoin("flota.bus", "mantencion.id_bus", "=", "bus.id_bus")
            ->leftjoin("flota.estado_mantencion", "mantencion.id_estado", "=", "estado_mantencion.id_estado")
            ->where("mantencion.borrado", "=", false);


        $m = $mantenciones->get()->map(function ($registro){
            $mantencion = $registro->toArray();

            $mantencion['ordenes_compra'] = ordenCompra::select("id_orden")->where("id_mantencion", "=", $registro->id_mantencion)->get();

            return $mantencion;
        });

        return $m;
    }

    public static function getMantencionesAgendadas(){
        $mantenciones = mantencion::select("mantencion.id_mantencion",
            "bus.orden_interno",
            "mantencion.descripcion",
            "estado_mantencion.descripcion as estado",
            "mantencion.created_at")
            ->leftjoin("flota.bus", "mantencion.id_bus", "=", "bus.id_bus")
            ->leftjoin("flota.estado_mantencion", "mantencion.id_estado", "=", "estado_mantencion.id_estado")
            ->where("mantencion.borrado", "=", false)
            ->where("estado_mantencion.id_estado", "=", 1)->get();

        return $mantenciones;
    }

    public static function getMantencionById($id_mantencion){
        $mantencion = mantencion::select("mantencion.id_mantencion",
            "bus.id_bus",
            "mantencion.descripcion",
            "orden_compra.id_orden",
            "estado_mantencion.id_estado as estado")
            ->leftjoin("flota.bus", "mantencion.id_bus", "=", "bus.id_bus")
            ->leftjoin("flota.orden_compra", "mantencion.id_mantencion", "=", "orden_compra.id_mantencion")
            ->leftjoin("flota.estado_mantencion", "mantencion.id_estado", "=", "estado_mantencion.id_estado")
            ->where("mantencion.id_mantencion", "=", $id_mantencion)->first();

        return $mantencion;
    }

    public static function saveMantencion($data){
        $mantencion = new mantencion();
        $mantencion->id_bus = $data->id_bus;
        $mantencion->descripcion = $data->descripcion;
        $mantencion->id_estado = 1;

        $mantencion->save();

        return $mantencion->id_mantencion;
    }

    public static function editMantencion($data){
        mantencion::where("id_mantencion", "=", $data->id_mantencion)
            ->update([
                'id_bus' => $data->id_bus,
                'descripcion' => $data->descripcion,
                'id_estado' => $data->id_estado
            ]);
    }

    public static function deleteMantencion($id_mantencion){
        mantencion::where("id_mantencion", "=", $id_mantencion)
            ->update([
                'borrado' => true,
            ]);
    }
}
