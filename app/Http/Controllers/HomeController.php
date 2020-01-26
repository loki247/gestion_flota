<?php

namespace App\Http\Controllers;

use App\Models\usuarios\Persona;
use App\Models\usuarios\Roles;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request){
        $persona = Persona::where("rut", "=", $request->user()->rut)->first();


        $rol_usuario = Roles::select("roles.id_rol", "roles.descripcion")
                            ->leftjoin("usuarios.rol_usuario", "roles.id_rol", "=", "rol_usuario.id_rol")
                            ->where("rol_usuario.id_usuario", "=", $request->user()->id_user)->get();
        $dataUser = new \stdClass();
        $dataUser->data_persona = $persona;
        $dataUser->data_usuario = $request->user();
        $dataUser->data_rol = $rol_usuario;

        return view('home')->with("user", $dataUser);
    }
}
