<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\RangoFecha;
use App\Empresa;
use Carbon\Carbon;
use App\User;
class InformeController extends Controller
{

    public function __construct(){
        $this->middleware('auth');
    }

    public function index(Request $request){
        #Libreria para manejo de fecha
        $mytime = Carbon::now();
        $fecha = $mytime->toDateString();
        $start = $mytime->startOfYear()->toDateString();
        if ($request){
            $query=trim($request->get('searchText'));
            $query2=trim($request->get('searchText2'));
            if(empty($query)){
                $query = $start;
            }
            if(empty($query2)){
                $query2 = $fecha;
            }
            $empresa=DB::table('empresa')
            ->first();


            $informe=DB::table('registro as r')
            ->join('usuario as u', 'r.IdUsuario', '=', 'u.IdUsuario')
            ->select('r.IdRegistro', 'FechaRegistro', 'HoraEntrada',
            'HoraSalida', 'u.Nombres', 'u.NumDocumento', 'LatitudEntrada', 'LongitudEntrada',
            'LatitudSalida', 'LongitudSalida', 'Consideracion', 'Consideracion2', 'EncargadoUpdt', 'HoraEntradaU',
            'HoraSalidaU', 'Observacion')
            ->whereBetween('FechaRegistro',array($query, $query2))
            ->where('u.IdUsuario', '=', auth()->user()->IdUsuario)
            ->orderBy('IdRegistro', 'desc')
            ->paginate(10);
            return view('asistencia.informe.index',["empresa"=>$empresa, "informe"=>$informe, "fecha"=>$fecha, "searchText"=>$query, "searchText2"=>$query2 ]);
        }

    }

    public function rango_fechaPdf($id, $id2, $id3){
        $mytime = Carbon::now();
        $fecha = $mytime->toDateString();
        if($id3 == 'TODO'){
            $id3 = '';
        }

        $empresa=DB::table('empresa')->first();
        $informe=DB::table('registro as r')
            ->join('usuario as u', 'r.IdUsuario', '=', 'u.IdUsuario')
            ->select('r.IdRegistro', 'FechaRegistro', 'HoraEntrada',
            'HoraSalida', 'u.Nombres', 'u.NumDocumento', 'LatitudEntrada', 'LongitudEntrada',
            'LatitudSalida', 'LongitudSalida', 'Consideracion', 'Consideracion2', 'EncargadoUpdt', 'HoraEntradaU',
            'HoraSalidaU', 'Observacion')
            ->whereBetween('FechaRegistro',array($id, $id2))
            ->where('u.IdUsuario', empty($id3) ? '!=' : '=',  empty($id3) ? '-1' : $id3)
            ->where('u.Estado', '=', 'ACTIVO')
            ->orderBy('FechaRegistro', 'desc')
            ->orderBy('u.IdUsuario')
            ->orderBy('HoraEntrada','desc')
            ->get();
        $usuario = empty($id3) ? '' : User::findOrfail($id3);
        $pdf = \PDF::loadView('asistencia/informe.rango', ["id"=>$id, "id2"=>$id2, "id3"=>$id3,
        "fecha"=>$fecha,"informe"=>$informe, "empresa"=>$empresa, "usuario"=> $usuario])
        ->setPaper('a4', 'landscape');
        return $pdf->stream();
    }
    public function rango_fechaExcel($f1, $f2, $f3){
        return Excel::download(new RangoFecha($f1, $f2, $f3), 'reporte_asistencia_rango.xlsx');
    }

    public static function fechaCastellano ($fecha) {
        $fecha = substr($fecha, 0, 10);
        $numeroDia = date('d', strtotime($fecha));
        $dia = date('l', strtotime($fecha));
        $mes = date('F', strtotime($fecha));
        $anio = date('Y', strtotime($fecha));
        $dias_ES = array("Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado", "Domingo");
        $dias_EN = array("Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday");
        $nombredia = str_replace($dias_EN, $dias_ES, $dia);
        $meses_ES = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
        $meses_EN = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
        $nombreMes = str_replace($meses_EN, $meses_ES, $mes);
        return $nombredia." ".$numeroDia." de ".$nombreMes." de ".$anio;
    }
    public static function conversor_segundos($seg_ini) {
        $horas = floor($seg_ini/3600);
        $minutos = floor(($seg_ini-($horas*3600))/60);
        $segundos = $seg_ini-($horas*3600)-($minutos*60);
        return str_pad($horas, 2, "0", STR_PAD_LEFT).':'. str_pad($minutos, 2, "0", STR_PAD_LEFT). ':'.str_pad($segundos, 2, "0", STR_PAD_LEFT);

    }
}
