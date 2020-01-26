<?php

namespace App\Http\Controllers\Flota;

use App\Models\flota\mantencion;
use App\Models\flota\ordenCompra;
use App\Models\usuarios\Persona;
use App\Models\usuarios\Roles;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use mysql_xdevapi\Exception;
use DB;

class OrdenCompraController extends Controller{
    public function viewOrdenesCompra(Request $request){
        $persona = Persona::where("rut", "=", $request->user()->rut)->first();

        $rol_usuario = Roles::select("roles.id_rol", "roles.descripcion")
            ->leftjoin("usuarios.rol_usuario", "roles.id_rol", "=", "rol_usuario.id_rol")
            ->where("rol_usuario.id_usuario", "=", $request->user()->id_user)->get();
        $dataUser = new \stdClass();
        $dataUser->data_persona = $persona;
        $dataUser->data_usuario = $request->user();
        $dataUser->data_rol = $rol_usuario;

        return view("flota.ordenesCompra")->with("user", $dataUser);
    }

    public static function getOrdenesCompra(){
        $ordenes_compra = ordenCompra::getOrdenesCompra();

        return response()->json($ordenes_compra);
    }

    public function getOrdenCompraById(Request $request){

        $orden_compra = ordenCompra::getOrdenCompraById($request->id_orden);

        return response()->json($orden_compra);
    }

    public function saveOrdenCompra(Request $request){

        $error = $this->validarCampos($request->all());

        if ($error) {
            return response()->json(['error' => $error, 'codigo' => 400]);
        }


        $data = new \stdClass();
        $data->id_mantencion = $request->id_mantencion;
        $data->repuestos = $request->repuestos;
        $data->cantidad = $request->cantidad;

        //return response()->json($data);

        DB::beginTransaction();
        try{
            DB::commit();
            return (ordenCompra::saveOrdenCompra($data));
        }catch (Exception $e){
            DB::rollback();
            return response()->json(['error' => $e]);
        }
    }

    public function validarCampos($data){
        $rules = [
            'id_mantencion' => function ($attribute, $value, $fail) {
                if ($value == 0 || empty($value)) {
                    return $fail("El campo <strong>:attribute</strong> no es válido");
                }
            },
            'repuestos' => 'required',
            'cantidad' => 'required'
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
            'id_mantencion' => 'Mantención',
            'repuestos' => 'Repuestos',
            'cantidad' => 'Cantidad'
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
