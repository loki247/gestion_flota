<?php

namespace App\Models\flota;

use Illuminate\Database\Eloquent\Model;

class bus extends Model{
    protected $table = "flota.bus";
    protected $primaryKey = "id_bus";

    public static function getBuses(){
        $buses = bus::select("bus.id_bus",
                            "bus.patente",
                            "bus.orden_interno",
                            "bus.num_motor",
                            "bus.num_chasis",
                            "bus.id_salon",
                            "salon.descripcion as salon",
                            "bus.capacidad")
            ->leftjoin("flota.salon", "bus.id_salon", "=", "salon.id_salon")
            ->where("bus.borrado", "=", false)->orderBy("id_bus", "asc")->get();

        return $buses;
    }

    public static function getBusById($id_bus){
        $bus = bus::select("bus.id_bus",
                        "bus.patente",
                        "bus.orden_interno",
                        "bus.num_motor",
                        "bus.num_chasis",
                        "bus.id_salon",
                        "salon.descripcion as salon",
                        "bus.capacidad")
            ->leftjoin("flota.salon", "bus.id_salon", "=", "salon.id_salon")
            ->where("id_bus", "=", $id_bus)->first();

        return $bus;
    }

    public static function saveBus($data){
        $bus = new bus();
        $bus->patente = $data->patente;
        $bus->orden_interno = $data->orden_interno;
        $bus->num_motor = $data->num_motor;
        $bus->num_chasis = $data->num_chasis;
        $bus->id_salon = $data->id_salon;
        $bus->capacidad = $data->capacidad;

        $bus->save();

        return $bus->id_bus;
    }

    public static function editBus($data){
        bus::where("id_bus", "=", $data->id_bus)
            ->update([
                'patente' => $data->patente,
                'orden_interno' => $data->orden_interno,
                'num_motor' => $data->num_motor,
                'num_chasis' => $data->num_chasis,
                'id_salon' => $data->id_salon,
                'capacidad' => $data->capacidad
            ]);
    }

    public static function deleteBus($id_bus){
        bus::where("id_bus", "=", $id_bus)
            ->update([
                'borrado' => true,
            ]);
    }
}
