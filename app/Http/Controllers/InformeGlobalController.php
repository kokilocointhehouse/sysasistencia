<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\RangoFecha;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class InformeGlobalController extends Controller
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

        $mytime = Carbon::now();
        $fecha = $mytime->toDateString();
        $start = Carbon::now()->startOfYear()->toDateString();
        if ($request){
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
            $empresa=DB::table('empresa')->first();

            $miEmpresa = DB::table('usuario as u')
            ->join('branch_office as b', 'u.idBranch_office', 'b.id')
            ->where('u.IdUsuario', auth()->user()->IdUsuario)
            ->first();

            $usuario=DB::table('usuario as u')
            ->join('branch_office as b', 'u.idBranch_office', 'b.id')
            ->where('b.idEmpresa', $miEmpresa->idEmpresa)
            ->where('Estado', '=', 'ACTIVO')
            ->where('TipoUsuario', '=', 'PERSONAL')
            ->get();

            $informe=DB::table('registro as r')
            ->join('usuario as u', 'r.IdUsuario', '=', 'u.IdUsuario')
            ->select('r.IdRegistro', 'FechaRegistro', 'HoraEntrada', 'LatitudEntrada', 'LongitudEntrada', 'LatitudSalida', 'LongitudSalida',
            'Consideracion', 'Consideracion2', 'EncargadoUpdt', 'HoraEntradaU',
            'HoraSalidaU', 'Observacion',
            'HoraSalida', 'u.IdUsuario','u.Nombres', 'u.NumDocumento')
            ->whereBetween('FechaRegistro',array($query, $query2))
            ->where('u.IdUsuario', empty($query3) ? '!=' : '=',  empty($query3) ? '-1' : $query3)
            // ->where('u.Nombres', 'LIKE', '%' . $query3 . '%')
            ->where('u.Estado', '=', 'ACTIVO')
            ->orderBy('FechaRegistro', 'desc')
            ->orderBy('u.IdUsuario')
            ->orderBy('HoraEntrada','desc')
            ->paginate(10);
            return view('asistencia.informe_global.index',
            ["empresa"=>$empresa, "informe"=>$informe, "fecha"=>$fecha,"usuario"=>$usuario,
             "searchText"=>$query, "searchText2"=>$query2, "searchText3"=>$query3 ]);
        }

    }

    public function rango_fechaPdfAd($id, $id2, $id3){
        $mytime = Carbon::now();
        $fecha = $mytime->toDateString();
        if($id3 == 'TODO'){
            $id3 = '';
        }
        $empresa=DB::table('empresa')->first();
        $informe=DB::table('registro as r')
            ->join('usuario as u', 'r.IdUsuario', '=', 'u.IdUsuario')
            ->select('r.IdRegistro', 'FechaRegistro', 'HoraEntrada', 'tema',
            'HoraSalida', 'u.Nombres', 'u.NumDocumento', 'EncargadoUpdt', 'HoraEntradaU',
            'HoraSalidaU', 'Observacion')
            ->whereBetween('FechaRegistro',array($id, $id2))
            ->where('u.Nombres', 'LIKE', '%' . $id3 . '%')
            ->orderBy('FechaRegistro', 'desc')
            ->orderBy('u.IdUsuario')
            ->orderBy('HoraEntrada','desc')
            ->get();
        $pdf = \PDF::loadView('asistencia/informe_global.rango', ["id"=>$id,
        "id2"=>$id2, "id3"=>$id3, "fecha"=>$fecha,"informe"=>$informe,
         "empresa"=>$empresa])
        ->setPaper('a4', 'landscape');
        return $pdf->stream();
    }

}
