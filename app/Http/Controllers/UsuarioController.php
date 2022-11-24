<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\UsuarioFormRequest;
use App\User;
use App\BranchOffice;
use App\Registro;
use App\Schedule;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;

class UsuarioController extends Controller
{


    public function __construct(){
        $this->middleware('auth');
    }
    public function index(Request $request)
    {

        if (auth()->user()->TipoUsuario =="PERSONAL"){
            Auth::logout();
            return redirect('/')
            ->with('flash','Usted no tiene privilegios para ingresar en la ruta solicitada.');
        }
        if ($request) {
            $query=trim($request->get('searchText'));

            $miEmpresa = DB::table('usuario as u')
            ->join('branch_office as b', 'u.idBranch_office', 'b.id')
            ->where('u.IdUsuario', auth()->user()->IdUsuario)
            ->first();
            $usuario = DB::table('usuario as u')
            ->join('branch_office as b', 'u.idBranch_office', 'b.id')
            ->select('u.IdUsuario', 'Nombres', 'b.name as namebranch_office', 'NumDocumento',
            'Direccion', 'TelefCel', 'Correo', 'foto', 'Estado','TipoUsuario', 'pagoHora')
            ->where('b.idEmpresa', $miEmpresa->idEmpresa)
            ->where(function ($q)  use ($query) {
                $q->orWhere('Nombres', 'LIKE' , '%' . $query . '%')
                ->orWhere('NumDocumento', 'LIKE' , '%' . $query . '%')
                ->orWhere('TipoUsuario', 'LIKE' , '%' . $query . '%')
                ->orWhere('Estado', 'LIKE' , '%' . $query . '%');
            })
            ->paginate(7);

            $branch_office = DB::table('branch_office')
                ->where('name', '!=', 'solo_admin')
                ->where('idEmpresa', $miEmpresa->idEmpresa)->get();


            return view('acceso.usuario.index',["usuario"=>$usuario, "branch_office"=>$branch_office, "searchText"=>$query]);
        }

    }

    public function store(UsuarioFormRequest $request)
    {

        $usuario = new User;
        $usuario->Nombres = $request->get('Nombres');
        $usuario->NumDocumento = $request->get('NumDocumento');
        $usuario->password = bcrypt($request->get('NumDocumento'));
        // $usuario->clave = $request->get('NumDocumento');
        $usuario->Direccion = $request->get('Direccion');
        $usuario->TelefCel = $request->get('Telefono');
        $usuario->Correo = $request->get('correo');
        $usuario->Estado = "ACTIVO";
        $usuario->TipoUsuario = $request->get('TipoUsuario');
        if($request->hasFile('foto')){
            $file = $request->file('foto');
            $file->move(public_path().'/Imagen',$file->getClientOriginalName());
            $usuario -> foto=$file->getClientOriginalName();
        }
        $usuario->pagoHora = $request->get('TipoUsuario') == 'ADMINISTRADOR' ? '0' : $request->get('pagoHora');
        $usuario->idBranch_office = $request->get('TipoUsuario') == 'ADMINISTRADOR' ? 1 : $request->get('idBranch_office');

        // $carbon = new \Carbon\Carbon();
        // $date = $carbon->now();
        // $usuario->CreadoEn = $date;
        $usuario->save();

        return Redirect::to('acceso/usuarios')->with(['success' =>  $usuario->Nombres . ' agregado, correctamente!.']);
    }


    public function edit($id)
    {
        $miEmpresa = DB::table('usuario as u')->join('branch_office as b', 'u.idBranch_office', 'b.id')->where('u.IdUsuario', auth()->user()->IdUsuario)
            ->first();
        $branch_office = DB::table('branch_office')->where('name', '!=', 'solo_admin')->where('idEmpresa', $miEmpresa->idEmpresa)->get();

        $tipo = ['ADMINISTRADOR', 'PERSONAL'];
        return view("acceso.usuario.edit",["usuario"=>User::findOrFail($id), "tipo"=>$tipo, "branch_office"=>$branch_office]);
    }



    public function update(UsuarioFormRequest $request,$id)
    {


        $usuario=User::findOrFail($id);
        $usuario->Nombres=$request->get('Nombres');
        $usuario->NumDocumento=$request->get('NumDocumento');
        $usuario->Direccion=$request->get('Direccion');
        $usuario->TelefCel=$request->get('TelefCel');
        $usuario->Correo=$request->get('Correo');
        $usuario->TipoUsuario=$request->get('TipoUsuario');
        if(!empty($request->get('password'))){
            $usuario->password= bcrypt($request->get('password'));
        }
        if($request->hasFile('foto')){
            $file = $request->file('foto');
            $file->move(public_path().'/Imagen',$file->getClientOriginalName());
            $usuario -> foto=$file->getClientOriginalName();
        }
        $usuario->pagoHora = $request->get('TipoUsuario') == 'ADMINISTRADOR' ? '0' : $request->get('pagoHora');
        $usuario->idBranch_office = $request->get('TipoUsuario') == 'ADMINISTRADOR' ? 1 : $request->get('idBranch_office');
        $usuario->update();
        return Redirect::to('acceso/usuarios')->with(['success' =>  $usuario->Nombres . ' modificado, correctamente!.']);
    }


    public function show($id){
        $n_id = substr($id, 1);

        $vuser=DB::table('usuario')
        ->where('IdUsuario','=', $n_id)
        ->first();
        if (isset($vuser->Estado)){
            if($vuser->Estado=='ACTIVO'){
                $estado = "INACTIVO";
            }else{
                $estado = "ACTIVO";
            }
        }

        $usuario=User::findOrFail($n_id);
        $usuario->Estado=$estado;
        $usuario->update();
        return Redirect::to('acceso/usuarios')->with(['success' => 'El estado de ' . $usuario->Nombres . ' fué modificado.']);
    }

    public function destroy(Request $request, $id)
    {
        try {
            if ($request->ajax()) {

                $docu   = User::findOrFail($id);

                if ($docu->delete()) {
                    return response()->json([
                        'success' => true,
                        'message' => '¡Satisfactorio!, Registro eliminado con éxito.',
                    ]);
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => '¡Error!, No se pudo eliminar.',
                    ]);
                }
            }
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => '¡Error!, Este registro tiene enlazado uno o mas registros.',
                ]);
            }
        }
    }

    public static function validation_destroy($id){
        return Registro::where('IdUsuario', $id)->count() == 0 ? true : false;
    }



}
