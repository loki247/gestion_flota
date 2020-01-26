<?php

namespace App\Models\flota;

use Illuminate\Database\Eloquent\Model;

class ordenCompra extends Model{
    protected $table = "flota.orden_compra";
    protected $primaryKey = "id_orden";

    public static function getOrdenesCompra(){
        $ordenes_compra = ordenCompra::select("orden_compra.id_orden",
            "orden_compra.id_mantencion",
            "orden_compra.detalle",
            "estado_orden_compra.descripcion as estado",
            "orden_compra.created_at")
            ->leftjoin("flota.estado_orden_compra", "orden_compra.id_estado", "=", "estado_orden_compra.id_estado")
            ->where("borrado", "=", false)->get();

        return $ordenes_compra;
    }

    public static function getOrdenCompraById($id_orden){

        $orden_compra = ordenCompra::select("orden_compra.id_orden",
            "orden_compra.id_mantencion",
            "orden_compra.detalle",
            "estado_orden_compra.id_estado")
            ->leftjoin("flota.estado_orden_compra", "orden_compra.id_estado", "=", "estado_orden_compra.id_estado")
            ->where("orden_compra.id_orden", "=", $id_orden)->first();

        return $orden_compra;
    }

    public static function saveOrdenCompra($data){

        $detalle = "[";

        for($i = 0; $i < count($data->repuestos); $i++){
            $detalle .= '{"repuesto": "' . $data->repuestos[$i] . '", "cantidad" : ' . $data->cantidad[$i] . "},";
        }

        $detalle .= "]";

        //return str_replace(",]", "]", $detalle);

        $ordenCompra = new ordenCompra();
        $ordenCompra->id_mantencion = $data->id_mantencion;
        $ordenCompra->detalle = str_replace(",]", "]", $detalle);
        $ordenCompra->id_estado = 1;

        $ordenCompra->save();

        return $ordenCompra->id_orden;
    }

    public static function editOrdenCompra($data){
        $detalle = "[";

        for($i = 0; $i < count($data->repuestos); $i++){
            $detalle .= '{"repuesto": "' . $data->repuestos[$i] . '", "cantidad" : ' . $data->cantidad[$i] . "},";
        }

        $detalle .= "]";

        ordenCompra::where("id_orden", "=", $data->id_orden)
            ->update([
                'id_mantencion' => $data->id_mantencion,
                'detalle' => str_replace(",]", "]", $detalle),
                //'id_estado' => $data->id_estado
            ]);
    }

    public static function deleteOrdenCompra($id_orden){
        ordenCompra::where("id_orden", "=", $id_orden)
            ->update([
                'borrado' => true,
            ]);
    }
}
