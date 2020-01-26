<?php

namespace App\Http\Controllers\Flota;

use App\Models\flota\bus;
use App\Models\flota\mantencion;
use App\Models\usuarios\Persona;
use App\Models\usuarios\Roles;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use mysql_xdevapi\Exception;
use DB;

class MantencionController extends Controller{
    public function viewMantenciones(Request $request){
        $persona = Persona::where("rut", "=", $request->user()->rut)->first();

        $rol_usuario = Roles::select("roles.id_rol", "roles.descripcion")
            ->leftjoin("usuarios.rol_usuario", "roles.id_rol", "=", "rol_usuario.id_rol")
            ->where("rol_usuario.id_usuario", "=", $request->user()->id_user)->get();
        $dataUser = new \stdClass();
        $dataUser->data_persona = $persona;
        $dataUser->data_usuario = $request->user();
        $dataUser->data_rol = $rol_usuario;

        return view("flota.mantenciones")->with("user", $dataUser);
    }

    public function getMantenciones(){
        $mantenciones = mantencion::getMantenciones();

        return response()->json($mantenciones);
    }

    public  function getMantencionById(Request $request){
        $mantencion = mantencion::getMantencionById($request->id_mantencion);

        return response()->json($mantencion);
    }

    public function saveMantencion(Request $request){
        $error = $this->validarCampos($request->all());

        if ($error) {
            return response()->json(['error' => $error, 'codigo' => 400]);
        }

        $data = new \stdClass();
        $data->id_bus = $request->id_bus;
        $data->descripcion = $request->descripcion;

        DB::beginTransaction();
        try{
            DB::commit();
            return(mantencion::saveMantencion($data));
        }catch (Exception $e){
            DB::rollback();
            return response()->json(['error' => $e]);
        }catch(\Throwable $e){
            DB::rollback();
            return response()->json(['error' => $e]);
        }
    }

    public function editMantencion(Request $request){
        $error = $this->validarCampos($request->all());

        if ($error) {
            return response()->json(['error' => $error, 'codigo' => 400]);
        }

        $data = new \stdClass();
        $data->id_mantencion = $request->id_mantencion;
        $data->id_bus = $request->id_bus;
        $data->descripcion = $request->descripcion;
        $data->id_estado = $request->id_estado;

        DB::beginTransaction();
        try{
            mantencion::editMantencion($data);
            DB::commit();
        }catch (Exception $e){
            DB::rollback();
            return response()->json(['error' => $e]);
        }catch(\Throwable $e){
            DB::rollback();
            return response()->json(['error' => $e]);
        }
    }

    public function deleteMantencion(Request $request){
        DB::beginTransaction();
        try{
            mantencion::deleteMantencion($request->id_mantencion);
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
            'id_bus' => function ($attribute, $value, $fail) {
                if ($value == 0 || empty($value)) {
                    return $fail("El campo <strong>:attribute</strong> no es válido");
                }
            },
            'descripcion' => 'required'
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
            'id_bus' => 'Bus',
            'descripcion' => 'Descripción'
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
