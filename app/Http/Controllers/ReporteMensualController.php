<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ReporteMensual;
use Carbon\Carbon;

class ReporteMensualController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(Request $request)
    {
        if($request){
            $mes = trim ($request -> get('searchText'));
            $anio = trim ($request -> get('searchText2'));

            //Array de meses
            $meses = ['ENERO', 'FEBRERO', 'MARZO', 'ABRIL', 'MAYO', 'JUNIO', 'JULIO', 'AGOSTO', 'SEPTIEMBRE', 'OCTUBRE', 'NOVIEMBRE', 'DICIEMBRE'];

            //Array de anios
            $anio_actual = intval(date('Y'))-5;
            for ($p=0; $p <= 5; $p++) {
                $anios_vista[$p] = $anio_actual++;
            }
            if ($mes == ''){
                $mes = date('m');
            }
            if($anio == ''){
                $anio = date('Y');
            }

            // Si no se encuentra seleccionada nigun mes

            $fecha_actual = date($anio . '-'. str_pad($mes, 2, "0", STR_PAD_LEFT) . '-d');
            $dias_del_mes = date('t', strtotime($fecha_actual));

            $empresa=DB::table('empresa')->first();
            for ($i=0; $i < $dias_del_mes; $i++) {
                $valor_fecha = str_pad(strval($i+1), 2, "0", STR_PAD_LEFT) . '-' . date('m', strtotime($fecha_actual)) . '-' . date('Y', strtotime($fecha_actual));
                // Consulta de Consumos
                $registro = DB::table('registro')
                ->where('FechaRegistro' ,'=', date('Y-m-d', strtotime($valor_fecha)))
                ->where('IdUsuario', '=', auth()->user()->IdUsuario)
                ->first();
                if (isset($registro->HoraEntrada)) {
                    $array_fechas[$i] = $valor_fecha . '_' . $registro->HoraEntrada .
                    '_' . $registro->Consideracion . '_' . $registro->HoraSalida .
                    '_' . $registro->Consideracion2 . '_' . $registro->LatitudEntrada .
                    '_' . $registro->LongitudEntrada . '_' . $registro->LatitudSalida .
                    '_'. $registro->LongitudSalida . '_' . $registro->EncargadoUpdt;
                }else{
                    $array_fechas[$i] = $valor_fecha . '_' . ''.
                    '_' . '' . '_' . '' . '_' . '' . '_' . '' . '_' . ''
                     . '_' . '' . '_' . '' . '_' . '';
                }


            }
            $mytime = Carbon::now();
            $fecha = $mytime->toDateString();

            return view('reporte.mensual.index',["fecha"=>$fecha,"array_fechas"=>$array_fechas, "empresa"=>$empresa,
            "searchText"=>$mes, "searchText2"=>$anio, "meses"=>$meses, "anios_vista"=>$anios_vista]);
        }
    }


    public function reporteExcel($f1, $f2, $f3){
        return Excel::download(new ReporteMensual($f1, $f2, $f3), 'reporte_asistencia_mensual.xlsx');
    }

    public function reportePdf($f1, $f2, $f3){
            $mes = $f1;
            $anio = $f2;
            if ($f3 == 'NADA') {
                $f3 = '-1';
            }
            //Array de anios
            $anio_actual = intval(date('Y'))-5;
            for ($p=0; $p <= 5; $p++) {
                $anios_vista[$p] = $anio_actual++;
            }
            if ($mes == ''){
                $mes = date('m');
            }
            if($anio == ''){
                $anio = date('Y');
            }
            $fecha_actual = date($anio . '-'. str_pad($mes, 2, "0", STR_PAD_LEFT) . '-d');
            $dias_del_mes = date('t', strtotime($fecha_actual));
            $empresa=DB::table('empresa')->first();
            for ($i=0; $i < $dias_del_mes; $i++) {
                $valor_fecha = str_pad(strval($i+1), 2, "0", STR_PAD_LEFT) . '-' . date('m', strtotime($fecha_actual)) . '-' . date('Y', strtotime($fecha_actual));
                // Consulta de Consumos
                $registro = DB::table('registro')
                ->where('FechaRegistro' ,'=', date('Y-m-d', strtotime($valor_fecha)))
                ->where('IdUsuario', $f3)
                ->first();
                if (isset($registro->HoraEntrada)) {
                    $array_fechas[$i] = $valor_fecha . '_' . $registro->HoraEntrada .
                    '_' . $registro->Consideracion . '_' . $registro->HoraSalida .
                    '_' . $registro->Consideracion2 . '_' . $registro->LatitudEntrada .
                    '_' . $registro->LongitudEntrada . '_' . $registro->LatitudSalida .
                    '_'. $registro->LongitudSalida . '_' . $registro->EncargadoUpdt;
                }else{
                    $array_fechas[$i] = $valor_fecha . '_' . ''. '_' . '' . '_' . '' . '_' . '' . '_' . '';
                }


            }
            $mytime = Carbon::now();
            $fecha = $mytime->toDateString();
            $usuario=DB::table('usuario')->where('IdUsuario', '=', $f3)->first();
        $pdf = \PDF::loadView('exports.reporte_mensual_pdf', ["usuario"=>$usuario, "id"=>$f1, "id2"=>$f2,
        "empresa"=>$empresa, "fecha"=>$fecha, "array_fechas"=>$array_fechas])->setPaper('a4', 'landscape');
        return $pdf->stream();
    }
}
