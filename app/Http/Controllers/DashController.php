<?php

namespace App\Http\Controllers;

use  Illuminate\Support\Facades\Session;
// Use Redirect;
use Illuminate\Http\Request;
use PhpParser\Node\Expr\FuncCall;
use Illuminate\Support\Facades\DB;
use App\Empresa;
use App\Registro;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\EmpresaFormRequest;
use App\Http\Requests\RegistroUFormRequest;
use Carbon\Carbon;

class DashController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if ($request) {
            $query=trim($request->get('searchText'));
            $query2=trim($request->get('searchText2'));

            $mytime = Carbon::now();
            $fecha = $mytime->toDateString();
            $empresa = DB::table('empresa')
            ->first();

            $miEmpresa = DB::table('usuario as u')
            ->join('branch_office as b', 'u.idBranch_office', 'b.id')
            ->where('u.IdUsuario', auth()->user()->IdUsuario)
            ->first();

            // Registros de Hoy!
            $cant_registros_hoy = DB::table('registro as r')
            ->join('usuario as u', 'r.IdUsuario', 'u.IdUsuario')
            ->join('branch_office as b', 'u.idBranch_office', 'b.id')
            ->where('b.idEmpresa', $miEmpresa->idEmpresa)
            ->where('FechaRegistro', '=', $fecha)
            ->get();
            // Registros Completados Hoy!
            $cant_registros_choy = DB::table('registro as r')
            ->join('usuario as u', 'r.IdUsuario', 'u.IdUsuario')
            ->join('branch_office as b', 'u.idBranch_office', 'b.id')
            ->where('b.idEmpresa', $miEmpresa->idEmpresa)
            ->whereNotNull('HoraSalida')
            ->where('FechaRegistro', '=', $fecha)
            ->get();
            // Registros Sin Completar Hoy!
            $cant_registros_fhoy = DB::table('registro as r')
            ->join('usuario as u', 'r.IdUsuario', 'u.IdUsuario')
            ->join('branch_office as b', 'u.idBranch_office', 'b.id')
            ->where('b.idEmpresa', $miEmpresa->idEmpresa)
            ->whereNull('HoraSalida')
            ->where('FechaRegistro', '=', $fecha)
            ->get();
            //Usaurio que no marcaron su registro
            $user_cant = DB::table('usuario as u')
            ->join('branch_office as b', 'u.idBranch_office', 'b.id')
            ->where('b.idEmpresa', $miEmpresa->idEmpresa)
            ->where('Estado', '=', 'ACTIVO')
            ->where('TipoUsuario', '=', 'PERSONAL')
            ->get();
            $cant_usuarionsr = count($user_cant) - count($cant_registros_hoy);

            // ---------------------------------------------------------------------------

            $registros_hoy = DB::table('registro as r')
            ->join('usuario as u', 'u.IdUsuario', '=', 'r.IdUsuario')
            ->join('branch_office as b', 'u.idBranch_office', 'b.id')
            ->where('b.idEmpresa', $miEmpresa->idEmpresa)
            ->where('FechaRegistro', '=', $fecha)
            ->get();

            $registros_choy = DB::table('registro as r')->join('usuario as u', 'u.IdUsuario', '=', 'r.IdUsuario')
            ->join('branch_office as b', 'u.idBranch_office', 'b.id')
            ->where('b.idEmpresa', $miEmpresa->idEmpresa)
            ->whereNotNull('HoraSalida')->where('FechaRegistro', '=', $fecha)
            ->get();

            $registros_pchoy = DB::table('registro as r')->join('usuario as u', 'u.IdUsuario', '=', 'r.IdUsuario')
            ->join('branch_office as b', 'u.idBranch_office', 'b.id')
            ->where('b.idEmpresa', $miEmpresa->idEmpresa)
            ->whereNull('HoraSalida')->where('FechaRegistro', '=', $fecha)
            ->get();

            // $registros_srhoy = DB::table('usuario as u')->join('registro as r', 'u.IdUsuario', '=', 'r.IdUsuario')
            // ->where('FechaRegistro', '+=', $fecha)
            // ->get();

            //select * from registro as r inner join usuario as u on r.IdUsuario = u.IdUsuario
            //where FechaRegistro = 13-05-2021
            // select * from usuario as u right join registro as r on u.IdUsuario = r.IdUsuario
            // where FechaRegistro = '2021-05-13'
            $user_s = DB::table('usuario as u')
            ->join('branch_office as b', 'u.idBranch_office', 'b.id')
            ->where('b.idEmpresa', $miEmpresa->idEmpresa)
            ->where('TipoUsuario', '=', 'PERSONAL')->get();
            $i = 0;
            $registros_srhoy = array();
            foreach ($user_s as $item) {
                $aux = false;
                foreach($registros_hoy as $sin){
                    if ($item->Nombres == $sin->Nombres){
                        $aux = true;
                    }
                }
                if (!$aux){
                    $registros_srhoy[$i] = $item->Nombres;
                    $i += 1;
                }
            }
            // foreach ($registros_srhoy as $item) {
            //     echo $item . '<br>';
            // }

            // ----------------------------------------------------------------------

            $anio = intval($mytime->format('Y'));
            $anios_proximos = [$anio - 3, $anio - 2, $anio - 1, $anio];
            $meses_disponibles = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];

            // Indicamos los datos del mes a buscar
            if (empty($query2)){
                $anio_o = $anio;
            }else{
                $anio_o = $query2;
            }

            if (empty($query)){
                $mes_actual = $mytime->format('m');
                $mes_recibido = $anio_o . '-' . $mes_actual;
                $cant_dias = $mytime->format('t');
                $aux_nombre_mes = $mytime->format('n');
            }else{
                for ($i=0; $i < count($meses_disponibles); $i++) {
                    if ($query == $meses_disponibles[$i]) {
                        $mes_recibido = $anio_o . '-' . ($i+1) . "-01";
                        $aux_nombre_mes = $i +1;
                        break;
                    }
                }
                $cant_dias = date('t', strtotime($mes_recibido));
                $mes_actual = date('m', strtotime( $mes_recibido));
            }
            $mes_recibido = $anio_o  . '-' . date('m', strtotime( $mes_recibido));
             //dia_actual
            $dia_ac = '-1';
            if ($mes_actual == $mytime->format('m')) {
                $dia_ac = $mytime->format('d');
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

            $usuario=DB::table('usuario as u')
            ->join('branch_office as b', 'u.idBranch_office', 'b.id')
            ->where('b.idEmpresa', $miEmpresa->idEmpresa)
            ->where('TipoUsuario', '=', 'PERSONAL')->get();
            $k=0;$k2=0;

            $asistencia = [];
            $estadistica = [];
            foreach($usuario as $u){
                $registro=DB::table('registro as r')->join('usuario as u', 'r.IdUsuario', 'u.IdUsuario')
                ->select('IdRegistro', 'FechaRegistro', 'HoraEntrada','HoraSalida', 'u.Nombres',
                'HoraSalida as promedioSalida', 'EncargadoUpdt')
                ->where('FechaRegistro', 'LIKE','%'. $mes_recibido . '%')
                ->where('u.IdUsuario', '=', $u->IdUsuario)
                ->get();
                $solo_nombre = explode(" ", $u->Nombres);
                $asistencia[$k]= $solo_nombre[0];
                $estadistica[$k2] = $u->Nombres;
                $k += 1; $k2 += 1;
                $correctas = 0; $malas = 0; $tardanza = 0;
                foreach ($dias_mes_n as $dn){
                    foreach ($registro as $r){
                        $fecha = date("d", strtotime($r->FechaRegistro));
                        if($fecha == $dn){
                            $identificador = $r->IdRegistro;
                            $indicador = $r->HoraEntrada;
                            $modificacion = 'no';
                            if (isset($r->EncargadoUpdt)){
                                $modificacion = 'si';
                            }

                        }
                    }
                    if(isset($indicador)){
                        if ($indicador <= $empresa->HoraEntrada) {
                            $asistencia[$k] = "*_" . $identificador . '_' . $modificacion;
                            $correctas += 1;
                        }else{
                            $asistencia[$k] = "T_" . $identificador . '_' . $modificacion;
                            $tardanza += 1;
                        }
                        unset($identificador);
                        unset($indicador);
                    }else{
                        $asistencia[$k] = "F_" . '2_' . 'no';
                        $malas +=1;
                    }
                    $k += 1;
                }
                $estadistica[$k2] = $correctas . ' Asistencias';
                $estadistica[$k2+1] = $tardanza . ' Tardanza';
                $estadistica[$k2+2] = $malas . ' Faltas';
                $k2 += 3;
            }


            return view('dashboard-administrador.index',["empresa"=>$empresa, "asistencia"=>$asistencia,
            "dias_mes_n"=>$dias_mes_n, "dias_mes_l"=>$dias_mes_l, "dia_ac"=>$dia_ac, "anio_o"=>$anio_o,
            "cant_dias"=>$cant_dias, "estadistica"=>$estadistica,
            "cant_registros_fhoy"=> count($cant_registros_fhoy), "cant_usuarionsr"=> $cant_usuarionsr,
            "cant_registros_hoy" => count($cant_registros_hoy), "cant_registros_choy" => count($cant_registros_choy),
            "mes_ac"=>$mes_ac, "meses_disponibles" => $meses_disponibles,
            "anios_proximos"=>$anios_proximos,
            "searchText"=>$query, "searchText2"=>$query2,
            "registros_hoy"=>$registros_hoy, "registros_choy"=>$registros_choy,
            "registros_pchoy"=>$registros_pchoy, "registros_srhoy"=>$registros_srhoy]);
        }

    }

    public function edit($id){
        $registro=DB::table('registro as r')
        ->join('usuario as u', 'r.IdUsuario', '=', 'u.IdUsuario')
        ->select('IdRegistro', 'FechaRegistro', 'HoraEntrada','HoraSalida',
         'u.Nombres', 'u.IdUsuario', 'HoraEntradaU', 'HoraSalidaU', 'Observacion', 'EncargadoUpdt')
        ->where('IdRegistro', '=', $id)
        ->first();

        $empresa=DB::table('empresa')->first();

        return view("dashboard-administrador.edit",["registro"=>$registro, "empresa"=>$empresa]);
    }

    public function update(RegistroUFormRequest $request){
        $registro=Registro::findOrFail($request->get('IdRegistro'));
        if ($request->get('HoraEntradaU') != $request->get('HoraEntrada')) {
            $registro->HoraEntradaU = $request->get('HoraEntradaU');
            $registro->HoraEntrada = $request->get('HoraEntrada');
        }
        if ($request->get('HoraSalidaU') != $request->get('HoraSalida')) {
            if (empty($request->get('HoraSalidaU')) == false){
                $registro->HoraSalidaU = $request->get('HoraSalidaU');
            }else{
                $registro->HoraSalidaU = '00:00:00';
            }
            $registro->HoraSalida = $request->get('HoraSalida');
        }
        if ($request->get('HoraEntradaU') != $request->get('HoraEntrada') || $request->get('HoraSalidaU') != $request->get('HoraSalida')){
            $registro->EncargadoUpdt = $request->get('EncargadoUpdt');
        }
        $registro->Observacion = $request->get('Observacion');
        $registro->update();
        return Redirect::to('dashboard-administrador');
    }


    public function store(EmpresaFormRequest $request)
    {
        $empresa = new Empresa;
        //  $empresa->nomEmpresa = $request->get('sindato');
        $hii= $request->get('sindato');
        $rest = substr($hii, 1,-1);

        $array = explode(",", $rest);
        for ($i=0; $i < count($array); $i++) {
            $array[$i] = str_replace('"','',$array[$i]);

        }
        $empresa->nomEmpresa = $array[0];
        $empresa->Direccion = $array[1];
        $empresa->Latitud = $array[2];
        $empresa->Longitud = $array[3];
        $empresa->radio = $array[4];
        $empresa->save();
        return Redirect::to('dashboard-administrador');
    }

    public function detallePdf($query, $query2){
            $empresa=DB::table('empresa')->first();

            $mytime = Carbon::now();
            $fecha = $mytime->toDateString();



            $anio = intval($mytime->format('Y'));
            $anios_proximos = [$anio - 3, $anio - 2, $anio - 1, $anio];
            $meses_disponibles = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];

            // Indicamos los datos del mes a buscar
            if (empty($query2)){
                $anio_o = $anio;
            }else{
                $anio_o = $query2;
            }

            if (empty($query)){
                $mes_actual = $mytime->format('m');
                $mes_recibido = $anio_o . '-' . $mes_actual;
                $cant_dias = $mytime->format('t');
                $aux_nombre_mes = $mytime->format('n');
            }else{
                for ($i=0; $i < count($meses_disponibles); $i++) {
                    if ($query == $meses_disponibles[$i]) {
                        $mes_recibido = $anio_o . '-' . ($i+1) . "-01";
                        $aux_nombre_mes = $i +1;
                        break;
                    }
                }
                $cant_dias = date('t', strtotime($mes_recibido));
                $mes_actual = date('m', strtotime( $mes_recibido));
            }
            $mes_recibido = $anio_o  . '-' . date('m', strtotime( $mes_recibido));
             //dia_actual
            $dia_ac = '-1';
            if ($mes_actual == $mytime->format('m')) {
                $dia_ac = $mytime->format('d');
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

            $usuario=DB::table('usuario as u')
             ->join('branch_office as b', 'u.idBranch_office', 'b.id')

             ->where('TipoUsuario', 'PERSONAL')->get();
            $k=0;$k2=0;
            $promedio = 0;
            $asistencia = [];
            $estadistica = [];
            foreach($usuario as $u){
                $registro=DB::table('registro as r')->join('usuario as u', 'r.IdUsuario', '=', 'u.IdUsuario')
                ->select('IdRegistro', 'FechaRegistro', 'HoraEntrada','HoraSalida', 'u.Nombres', 'HoraEntrada as promedioEntrada',
                'EncargadoUpdt')
                ->where('FechaRegistro', 'LIKE','%'. $mes_recibido . '%')
                ->where('u.IdUsuario', '=', $u->IdUsuario)

                ->get();
                $solo_nombre = explode(" ", $u->Nombres);
                $asistencia[$k]= $solo_nombre[0];
                $estadistica[$k2] = $u->Nombres;
                $k += 1; $k2 += 1;
                $correctas = 0; $malas = 0; $tardanza = 0;
                foreach ($dias_mes_n as $dn){
                    foreach ($registro as $r){
                        $fecha = date("d", strtotime($r->FechaRegistro));
                        if($fecha == $dn){
                            $identificador = $r->IdRegistro;
                            $indicador = $r->HoraEntrada;
                            $modificacion = 'no';
                            if (isset($r->EncargadoUpdt)){
                                $modificacion = 'si';
                            }
                            $promedio +=  strtotime($r->promedioEntrada);
                        }

                    }
                    if(isset($indicador)){
                        if ($indicador <= $empresa->HoraEntrada) {
                            $asistencia[$k] = "*_" . $identificador . '_' . $modificacion;
                            $correctas += 1;
                        }else{
                            $asistencia[$k] = "T_" . $identificador . '_' . $modificacion;
                            $tardanza += 1;
                        }
                        unset($identificador);
                        unset($indicador);
                    }else{
                        $asistencia[$k] = "F_" . '2_' . 'no';
                        $malas +=1;
                    }
                    $k += 1;

                }
                $estadistica[$k2] = $correctas . ' Asistencias';
                $estadistica[$k2+1] = $tardanza . ' Tardanza';
                $estadistica[$k2+2] = $malas . ' Faltas';
                $k2 += 3;
            }

        $pdf = \PDF::loadView('dashboard-administrador.reporte', ["dias_mes_l"=>$dias_mes_l,
        "dia_ac"=>$dia_ac, "anio_o"=>$anio_o, "dias_mes_n"=>$dias_mes_n, "asistencia"=>$asistencia,
        "cant_dias"=>$cant_dias, "estadistica"=>$estadistica, "empresa"=>$empresa,
        "query"=>$query, "query2"=>$query2])
        ->setPaper('a4', 'landscape');
        return $pdf->stream();
    }
}
