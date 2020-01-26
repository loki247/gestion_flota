<?php

namespace App\Http\Controllers\Flota;

use App\Models\flota\bus;
use App\Models\usuarios\Persona;
use App\Models\usuarios\Roles;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use mysql_xdevapi\Exception;
use Illuminate\Support\Facades\Validator;
use DB;

class BusController extends Controller{
    public function viewBuses(Request $request){
        $persona = Persona::where("rut", "=", $request->user()->rut)->first();

        $rol_usuario = Roles::select("roles.id_rol", "roles.descripcion")
            ->leftjoin("usuarios.rol_usuario", "roles.id_rol", "=", "rol_usuario.id_rol")
            ->where("rol_usuario.id_usuario", "=", $request->user()->id_user)->get();
        $dataUser = new \stdClass();
        $dataUser->data_persona = $persona;
        $dataUser->data_usuario = $request->user();
        $dataUser->data_rol = $rol_usuario;

        return view("flota.buses")->with("user", $dataUser);
    }

    public function getBuses(){
        $buses = bus::getBuses();

        return $buses;
    }

    public function getBusById(Request $request){
        $bus = bus::getBusById($request->id_bus);

        return response()->json($bus);
    }

    public function saveBus(Request $request){
        $error = $this->validarCampos($request->all());

        if ($error) {
            return response()->json(['error' => $error, 'codigo' => 400]);
        }

        $data = new \stdClass();
        $data->patente = $request->patente;
        $data->orden_interno = $request->orden_interno;
        $data->num_motor = $request->num_motor;
        $data->num_chasis = $request->num_chasis;
        $data->id_salon = $request->id_salon;
        $data->capacidad = $request->capacidad;

        DB::beginTransaction();
        try{

            DB::commit();
            return(bus::saveBus($data));
        }catch (Exception $e){
            DB::rollback();
            return response()->json(['error' => $e]);
        }catch(\Throwable $e){
            DB::rollback();
            return response()->json(['error' => $e]);
        }
    }

    public function editBus(Request $request){
        $error = $this->validarCampos($request->all());

        if ($error) {
            return response()->json(['error' => $error, 'codigo' => 400]);
        }

        $data = new \stdClass();
        $data->id_bus = $request->id_bus;
        $data->patente = $request->patente;
        $data->orden_interno = $request->orden_interno;
        $data->num_motor = $request->num_motor;
        $data->num_chasis = $request->num_chasis;
        $data->id_salon = $request->id_salon;
        $data->capacidad = $request->capacidad;

        DB::beginTransaction();
        try{
            bus::editBus($data);
            DB::commit();
        }catch (Exception $e){
            DB::rollback();
            return response()->json(['error' => $e]);
        }catch(\Throwable $e){
            DB::rollback();
            return response()->json(['error' => $e]);
        }
    }

    public function deleteBus(Request $request){
        DB::beginTransaction();
        try{
            bus::deleteBus($request->id_bus);
            DB::commit();
        }catch (Exception $e){
            DB::rollback();
            return response()->json(['error' => $e]);
        }catch(\Throwable $e){
            DB::rollback();
            return response()->json(['error' => $e]);
        }
    }

    public function validarCampos($data){
        $rules = [
            'patente' => 'required:max:6',
            'num_motor' => 'required',
            'num_chasis' => 'required',
            'capacidad' => 'required|integer'
        ];

        $customMsg = [
            'required' => 'El campo <strong>:attribute</strong> no puede estar vacío.',
            'max' => [
                'string'  => 'El campo <strong>:attribute</strong> supera el máximo de caracteres.',
            ],
            'min' => 'Valor para <strong>:attribute</strong> no valido',
            'array' => 'El campo <strong>:attribute</strong> debe ser un arreglo.',
            'integer' => 'El campo <strong>:attribute</strong> debe ser entero.',
            'string' => 'El campo <strong>:attribute</strong> debe ser texto',

            'custom' => [
                'attibute-name' => [
                    'rule-name' => 'custom-message'
                ]
            ],
        ];

        $atributos = [
            'patente' => 'Patente',
            'num_motor' => 'Número de Motor',
            'num_chasis' => 'Número de Chasis',
            'capacidad' => 'Capacidad'
        ];

        $validateData = Validator::make($data, $rules, $customMsg);
        $validateData->setAttributeNames($atributos);

        if($validateData->fails()){
            return $validateData->errors();
        }else{
            return false;
        }
    }
}
