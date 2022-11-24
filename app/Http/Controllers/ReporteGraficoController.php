<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Registro;
use Carbon\Carbon;
use App\Http\Controllers\RegistroController;

class ReporteGraficoController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index(Request $request){
        if ($request){
            $query=trim($request->get('searchText'));
            $query2=trim($request->get('searchText2'));
            $anio = intval(date('Y'));
            $anios_proximos = [$anio - 3, $anio - 2, $anio - 1, $anio];
            $meses_disponibles = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];

            // Indicamos los datos del mes a buscar
            if ($query2 == ''){
                $anio_o = date('Y');
            }else{
                $anio_o = "$query2";
            }
            if ($query == ''){
                $mes_recibido = $anio_o . '-' . date('m');
                $cant_dias = date('t');
                $mes_actual = date('m');
                //dia_actual
                $dia_ac = date('d');
                //auxiliar para mostrar el nombre del mes
                $aux_nombre_mes = date("n");
            }else {
                for ($i=0; $i < count($meses_disponibles); $i++) {
                    if ($query == $meses_disponibles[$i]) {

                        $mes_recibido = $anio_o . '-' . ($i+1) . "-01";
                        $aux_nombre_mes = $i +1;
                        break;
                    }
                }
                $cant_dias = date('t', strtotime($mes_recibido));
                $mes_actual = date('m', strtotime( $mes_recibido));

                //dia_actual
                if ($mes_actual == date('m')) {
                    $dia_ac = date('d');
                }else{
                    $dia_ac = '45';
                }
                //dia_actual
                $mes_recibido = $anio_o  . '-' . date('m', strtotime( $mes_recibido));
            }
             // Generamos la tabla del mes - Seleccionado
             $dias = array("DO", "LU", "MA", "MI", "JU", "VI", "SÁ");
            //mes_actual
            $mes_ac = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"][$aux_nombre_mes - 1];

             for ($i=0; $i < $cant_dias; $i++) {
                 $fechats = strtotime($anio_o . '-' . $mes_actual . '-' .  ($i+1));
                 $dias_mes_n[$i] = str_pad(($i + 1), 2, "0", STR_PAD_LEFT);
                 $dias_mes_l[$i] = $dias[date('w', $fechats)];
             }
            $k=0;
            $promedio = 0;
            $empresa=DB::table('empresa')->first();
                $registro=DB::table('registro as r')->join('usuario as u', 'r.IdUsuario', '=', 'u.IdUsuario')
                ->select( 'FechaRegistro', 'HoraEntrada','HoraSalida', 'u.Nombres', 'HoraEntrada as promedioEntrada',
                'HoraSalida as promedioSalida')
                ->where('FechaRegistro', 'LIKE','%'. $mes_recibido . '%')
                ->where('u.IdUsuario', '=', auth()->user()->IdUsuario)
                ->get();

                $k += 1;
                $correctas = 0; $malas = 0; $tardanza = 0;
                foreach ($dias_mes_n as $dn){
                    foreach ($registro as $r){
                        $fecha = date("d", strtotime($r->FechaRegistro));
                        if($fecha == $dn){
                            $indicador = $r->HoraEntrada;
                            $promedio +=  strtotime($r->promedioEntrada);
                        }

                    }
                    if(isset($indicador)){
                        if ($indicador <= $empresa->HoraEntrada) {
                            $asistencia[$k] = "*";
                            $correctas += 1;
                        }else{
                            $asistencia[$k] = "T";
                            $tardanza += 1;
                        }
                        unset($indicador);
                    }else{
                        $asistencia[$k] = "F";
                        $malas +=1;
                    }
                    $k += 1;
                }
                $estadistica[0] = $correctas . ' Asistencias';
                $estadistica[1] = $tardanza . ' Tardanza';
                $estadistica[2] = $malas . ' Faltas';

            return view('reporte.grafico.index',["mes_ac"=>$mes_ac,"registro"=>$registro, "dias_mes_n"=>$dias_mes_n, "cant_dias"=>$cant_dias,
            "dias_mes_l"=>$dias_mes_l, "asistencia"=>$asistencia, "dia_ac"=> $dia_ac, "mes_ac"=> $mes_ac, "estadistica" => $estadistica,
            "meses_disponibles"=>$meses_disponibles, "anios_proximos"=>$anios_proximos,  "anio_o"=>$anio_o,
            "searchText"=>$query, "searchText2"=>$query2]);
        }


    }

    public function reportegp($id, $id2){
            $query=trim($id);
            $query2=trim($id2);
            $anio = intval(date('Y'));
            $meses_disponibles = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];

            // Indicamos los datos del mes a buscar
            if ($query2 == ''){
                $anio_o = date('Y');
            }else{
                $anio_o = "$query2";
            }
            if ($query == ''){
                $mes_recibido = $anio_o . '-' . date('m');
                $cant_dias = date('t');
                $mes_actual = date('m');
                //dia_actual
                $dia_ac = date('d');
                //auxiliar para mostrar el nombre del mes
                $aux_nombre_mes = date("n");
            }else {
                for ($i=0; $i < count($meses_disponibles); $i++) {
                    if ($query == $meses_disponibles[$i]) {

                        $mes_recibido = $anio_o . '-' . ($i+1) . "-01";
                        $aux_nombre_mes = $i +1;
                        break;
                    }
                }
                $cant_dias = date('t', strtotime($mes_recibido));
                $mes_actual = date('m', strtotime( $mes_recibido));

                //dia_actual
                if ($mes_actual == date('m')) {
                    $dia_ac = date('d');
                }else{
                    $dia_ac = '45';
                }
                //dia_actual
                $mes_recibido = $anio_o  . '-' . date('m', strtotime( $mes_recibido));
            }
          // Generamos la tabla del mes - Seleccionado
          $dias = array("DO", "LU", "MA", "MI", "JU", "VI", "SÁ");
          //mes_actual
          $mes_ac = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"][$aux_nombre_mes - 1];

           for ($i=0; $i < $cant_dias; $i++) {
               $fechats = strtotime($anio_o . '-' . $mes_actual . '-' .  ($i+1));
               $dias_mes_n[$i] = str_pad(($i + 1), 2, "0", STR_PAD_LEFT);
               $dias_mes_l[$i] = $dias[date('w', $fechats)];
           }
          $k=0;
          $promedio = 0;
          $empresa=DB::table('empresa')->first();
              $registro=DB::table('registro as r')->join('usuario as u', 'r.IdUsuario', '=', 'u.IdUsuario')
              ->select( 'FechaRegistro', 'HoraEntrada','HoraSalida', 'u.Nombres', 'HoraEntrada as promedioEntrada',
              'HoraSalida as promedioSalida')
              ->where('FechaRegistro', 'LIKE','%'. $mes_recibido . '%')
              ->where('u.IdUsuario', '=', auth()->user()->IdUsuario)
              ->get();

              $k += 1;
              $correctas = 0; $malas = 0; $tardanza = 0;
              foreach ($dias_mes_n as $dn){
                  foreach ($registro as $r){
                      $fecha = date("d", strtotime($r->FechaRegistro));
                      if($fecha == $dn){
                          $indicador = $r->HoraEntrada;
                          $promedio +=  strtotime($r->promedioEntrada);
                      }

                  }
                  if(isset($indicador)){
                      if ($indicador <= $empresa->HoraEntrada) {
                          $asistencia[$k] = "*";
                          $correctas += 1;
                      }else{
                          $asistencia[$k] = "T";
                          $tardanza += 1;
                      }
                      unset($indicador);
                  }else{
                      $asistencia[$k] = "F";
                      $malas +=1;
                  }
                  $k += 1;
              }
              $estadistica[0] = $correctas . ' Asistencias';
              $estadistica[1] = $tardanza . ' Tardanza';
              $estadistica[2] = $malas . ' Faltas';

              $usuario = auth()->user()->Nombres;

        $pdf = \PDF::loadView('reporte/grafico.rgrafico', ["mes_ac"=>$mes_ac,"registro"=>$registro, "dias_mes_n"=>$dias_mes_n, "cant_dias"=>$cant_dias,
        "dias_mes_l"=>$dias_mes_l, "asistencia"=>$asistencia, "dia_ac"=> $dia_ac, "estadistica" => $estadistica,
           "anio_o"=>$anio_o, "usuario"=>$usuario])->setPaper('a4', 'landscape');
        return $pdf->stream();
    }
}
