<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\PagoFormRequest;
use Illuminate\Support\Facades\Redirect;
use App\Pago;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class PagoController extends Controller
{
    public function __construct(){
        $this->middleware('auth');

    }

    public function index(Request $request){
        if (auth()->user()->TipoUsuario =="PERSONAL"){
            Auth::logout();
            return redirect('/')
            ->with('flash','Usted no tiene privilegios para ingresar en la ruta solicitada.');
        }
        if ($request) {
            $mytime = Carbon::now();
            $fecha = $mytime->toDateString();
            $start = Carbon::now()->startOfYear()->toDateString();

            $query=trim($request->get('searchText'));
            $query2=trim($request->get('searchText2'));
            $query3=trim($request->get('searchText3'));

            if(empty($query)){
                $query = $start;
            }
            if(empty($query2)){
                $query2 = $fecha;
            }
            if($query3 == 'TODO'){
                $query3 = '';
            }

            $miEmpresa = DB::table('usuario as u')
            ->join('branch_office as b', 'u.idBranch_office', 'b.id')
            ->where('u.IdUsuario', auth()->user()->IdUsuario)
            ->first();

            $usuario=DB::table('usuario as u')
            ->join('branch_office as b', 'u.idBranch_office', 'b.id')
            ->where('b.idEmpresa', $miEmpresa->idEmpresa)
            ->where('Estado', 'ACTIVO')
            ->where('TipoUsuario', 'PERSONAL')->get();

            $pago = DB::table('pago as p')
            ->join('usuario as u', 'p.IdUsuario', '=', 'u.IdUsuario')
            ->whereBetween('fecha',array($query, $query2))
            ->where('u.Nombres', 'LIKE', '%' . $query3 . '%')
            ->orderByDesc('IdPago')
            ->paginate(10);

            return view('caja.pago.index',["usuario"=>$usuario,"pago"=>$pago,"searchText"=>$query, "searchText2"=>$query2, "searchText3"=>$query3]);
        }
    }

    public function create(){
        if (auth()->user()->TipoUsuario =="PERSONAL"){
            Auth::logout();
            return redirect('/')
            ->with('flash','Usted no tiene privilegios para ingresar en la ruta solicitada.');
        }
        $miEmpresa = DB::table('usuario as u')
            ->join('branch_office as b', 'u.idBranch_office', 'b.id')
            ->where('u.IdUsuario', auth()->user()->IdUsuario)
            ->first();

        $usuario=DB::table('usuario as u')
            ->join('branch_office as b', 'u.idBranch_office', 'b.id')
            ->where('b.idEmpresa', $miEmpresa->idEmpresa)
            ->where('Estado', 'ACTIVO')
            ->where('TipoUsuario', 'PERSONAL')->get();
        return view("caja.pago.create",["usuario"=>$usuario]);
    }

    public function store(PagoFormRequest $request){
        $mytime = Carbon::now();
        $fecha = $mytime->toDateString();
        $hora = $mytime->toTimeString();
        $pago = new Pago;
        $pago -> IdUsuario = $request -> get ('IdUsuario');
        $pago -> monto = $request -> get ('monto');
        $pago -> nota = $request -> get ('nota');
        $pago -> fecha = $fecha;
        $pago -> hora = $hora;
        $pago -> save();
        return Redirect::to('caja/pago');
    }

    public function pago($id, $id2, $id3){
        if($id3 == 'TODO'){
            $id3 = '';
        }
        $pago = DB::table('pago as p')
            ->join('usuario as u', 'p.IdUsuario', '=', 'u.IdUsuario')
            ->whereBetween('fecha',array($id, $id2))
            ->where('u.Nombres', 'LIKE', '%' . $id3 . '%')
            ->orderByDesc('IdPago')
            ->get();

            // $empresa = DB::table('empresa')->first();

        $empresa=DB::table('empresa')->first();

        $pdf = \PDF::loadView('caja/pago.informe', ["id"=>$id,"id2"=>$id2, "id3"=>$id3,
        "pago"=>$pago, "empresa"=>$empresa]);
        // ->setPaper('a4', 'landscape');
        return $pdf->stream();
    }
}
