<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\UsuarioFormRequest;
use Illuminate\Support\Carbon;
use App\User;
use Illuminate\Support\Facades\Redirect;

class MAsistenciaController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if ($request) {
            $usuario = DB::table('usuario')
            ->Where('IdUsuario', '=', auth()->user()->IdUsuario)
            ->first();
            return view('configuracion.mi_perfil.index',["usuario"=>$usuario]);

        }
    }

    public function update(UsuarioFormRequest $request,$id)
    {
        $usuario=User::findOrFail($id);
        $usuario->Nombres=$request->get('Nombres');
        $usuario->NumDocumento=$request->get('NumDocumento');
        $usuario->Direccion=$request->get('Direccion');
        $usuario->TelefCel=$request->get('Telefono');
        $usuario->Correo=$request->get('correo');
        if ($request->get('password') != ''){
            $usuario->clave = $request->get('password');
            $usuario->password = bcrypt($request->get('password'));
        }

        if($request->hasFile('foto')){
            $file = $request->file('foto');
            $file->move(public_path().'/Imagen',$file->getClientOriginalName());
            $usuario -> foto=$file->getClientOriginalName();
        }
        $usuario->update();
        return Redirect::to('configuracion/mi_perfil')->with(['success' => 'La información fue modificada, correctamente!.']);
    }
}
