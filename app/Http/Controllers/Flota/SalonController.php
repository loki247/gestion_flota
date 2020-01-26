<?php

namespace App\Http\Controllers\Flota;

use App\Models\flota\salon;
use App\Models\usuarios\Persona;
use App\Models\usuarios\Roles;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use mysql_xdevapi\Exception;
use DB;
use Illuminate\Support\Facades\Validator;

class SalonController extends Controller{
    public function viewSalones(Request $request){
        $persona = Persona::where("rut", "=", $request->user()->rut)->first();


        $rol_usuario = Roles::select("roles.id_rol", "roles.descripcion")
            ->leftjoin("usuarios.rol_usuario", "roles.id_rol", "=", "rol_usuario.id_rol")
            ->where("rol_usuario.id_usuario", "=", $request->user()->id_user)->get();
        $dataUser = new \stdClass();
        $dataUser->data_persona = $persona;
        $dataUser->data_usuario = $request->user();
        $dataUser->data_rol = $rol_usuario;

        return view("flota.salones")->with("user", $dataUser);
    }

    public function getSalones(){
        $salones = salon::getSalones();

        return $salones;
    }

    public function getSalonById(Request $request){
        $salon = salon::getSalonById($request->id_salon);

        return response()->json($salon);
    }

    public function saveSalon(Request $request){
        $error = $this->validarCampos($request->all());

        if ($error) {
            return response()->json(['error' => $error, 'codigo' => 400]);
        }

        $data = new \stdClass();
        $data->descripcion = $request->descripcion;
        $data->nombre_corto = $request->nombre_corto;

        DB::beginTransaction();
        try{

            DB::commit();
            return(salon::saveSalon($data));
        }catch (Exception $e){
            DB::rollback();
            return response()->json(['error' => $e]);
        }catch(\Throwable $e){
            DB::rollback();
            return response()->json(['error' => $e]);
        }
    }

    public function editSalon(Request $request){

        $error = $this->validarCampos($request->all());

        if ($error) {
            return response()->json(['error' => $error, 'codigo' => 400]);
        }

        $data = new \stdClass();
        $data->id_salon = $request->id_salon;
        $data->descripcion = $request->descripcion;
        $data->nombre_corto = $request->nombre_corto;

        DB::beginTransaction();
        try{
            salon::editSalon($data);
            DB::commit();
        }catch (Exception $e){
            DB::rollback();
            return response()->json(['error' => $e]);
        }catch(\Throwable $e){
            DB::rollback();
            return response()->json(['error' => $e]);
        }
    }

    public function deleteSalon(Request $request){
        DB::beginTransaction();
        try{
            salon::deleteSalon($request->id_salon);
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
            'descripcion' => 'required',
            'nombre_corto' => 'required|max:10'
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
            'descripcion' => 'Descripción',
            'nombre_corto' => 'Nombre Corto'
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
