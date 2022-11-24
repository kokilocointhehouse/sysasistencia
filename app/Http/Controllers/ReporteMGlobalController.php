<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ReporteMensual;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class ReporteMGlobalController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(Request $request)
    {
        if (auth()->user()->TipoUsuario =="PERSONAL"){
            Auth::logout();
            return redirect('/')
            ->with('flash','Usted no tiene privilegios para ingresar en la ruta solicitada.');
        }

        if($request){

            $usuario=DB::table('usuario as u')
            ->join('branch_office as b', 'u.idBranch_office', 'b.id')
            // ->where('b.idEmpresa', $miEmpresa->idEmpresa)
            ->where('Estado', 'ACTIVO')
            ->where('TipoUsuario', 'PERSONAL')->get();

            $mes = trim ($request -> get('searchText'));
            $anio = trim ($request -> get('searchText2'));
            $query3 = trim ($request -> get('searchText3'));


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
                ->where('IdUsuario', '=', $query3)
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

            return view('asistencia.reporte_mensual.index',["usuario"=>$usuario,
                "fecha"=>$fecha,"array_fechas"=>$array_fechas, "empresa"=>$empresa,
            "searchText"=>$mes, "searchText2"=>$anio, "searchText3"=>$query3,"meses"=>$meses, "anios_vista"=>$anios_vista]);
        }
    }
}
