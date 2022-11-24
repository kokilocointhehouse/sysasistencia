<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Registro;
use App\Http\Requests\RegistroFormRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Intervention\Image\ImageManagerStatic as Image;
use DateTime;
// use 'App\Https\ds';
use Carbon\Carbon;
class RegistroController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index(Request $request){
        $mytime = Carbon::now();
        if ($request){
            $fecha = $mytime->toDateString();
            $hora_actual = $mytime->toTimeString();
            $informe=DB::table('registro')
            ->where('FechaRegistro', '=', $fecha)
            ->where('IdUsuario', '=', auth()->user()->IdUsuario)
            ->first();

            $fecha_letra = fechaCastellano($fecha);
            // $empresa=DB::table('empresa')->first();

            $empresa = Db::table('empresa')->first();


            $diasH = "";
             // Reemplazamos la tilde de los sabados
             $a = str_replace("Ã", "Á", utf8_encode(strtoupper(substr($fecha_letra, 0, 2))));
             if (strlen($empresa->diasHabilitados) > 2){
                 $diasH = explode("_", $empresa->diasHabilitados);
                 $aux = false;
                 foreach ($diasH as $k) {
                     if ($a == $k) {
                         $aux = true;
                         break;
                     }
                 }
             }
             if($aux){
                // if (!($hora_actual >= $empresa->AperturaSistema && $hora_actual <= $empresa->departureTime)){
                 if (!($hora_actual >= $empresa->AperturaSistema )){
                     $aux = false;
                 }
             }

             $empresa = Db::table('branch_office as b')
            ->join('empresa as e', 'b.idEmpresa', 'e.idEmpresa')
            ->select('b.name', 'latitude', 'longitude', 'radius', 'address', 'e.idEmpresa', 'AperturaSistema', 'diasHabilitados')
            ->where('b.id', auth()->user()->idBranch_office)->first();

            $fecha_actual = fechaCastellano($mytime->toDateString()) . " / " . $mytime->toTimeString();
            return view('asistencia.registro.index',["fecha_letra"=>$fecha_letra,
            "empresa"=>$empresa,"informe"=>$informe, "aux"=>$aux,
            "fecha_actual"=>$fecha_actual,"fecha"=>$fecha]);
        }

    }

    public function store(RegistroFormRequest $request)
    {
        $registro = new Registro;
        $registro -> LatitudEntrada = $request -> get ('latitud_entrada');
        $registro -> LongitudEntrada = $request -> get ('longitud_entrada');
        $registro -> FechaRegistro = $request -> get ('fecha_entrada');
        $registro -> HoraEntrada = $request -> get ('hora_entrada');
        $registro -> Consideracion = $request -> get ('consideracion_input');

        $img = $request -> get ('fotocamara');
        $img = str_replace('data:image/png;base64,', '', $img);
        $img = str_replace(' ', '+', $img);
        $image = base64_decode($img);
        $extension="png";
        $filename=$request -> get ('idusuario').date('h-i-s'). date('m-d') . '.'.$extension;
        $registro -> capturaEntrada = $filename;
        Image::make($image)->save(public_path("capturas_asistencia"."/".$filename));

        $registro -> IdUsuario = $request -> get ('idusuario');
        $registro -> save();
        return Redirect::to('asistencia/informe')->with(['success' => 'Asistencia registrada correctamente.']);
    }

    public function marcarsalida(){
        $mytime = Carbon::now();
        if ($_POST['latitud_entrada'] == ''){
            Session::flash('error', 'Permita acceder a su ubicación, por favor. Recargue nuevamente la página');
        }else{
            $registro=Registro::findOrFail($_POST['idregistro']);
            $registro->LatitudSalida=$_POST['latitud_entrada'];
            $registro->LongitudSalida=$_POST['longitud_entrada'];
            $registro->HoraSalida=$mytime->toTimeString();
            $registro->Consideracion2=$_POST['consideracion_input'];

            $img = $_POST['fotocamara'];
            $img = str_replace('data:image/png;base64,', '', $img);
            $img = str_replace(' ', '+', $img);
            $image = base64_decode($img);
            $extension="png";
            $filename= $_POST['idregistro'] .date('h-i-s'). date('m-d') . '.'.$extension;
            $registro -> capturaSalida = $filename;
            Image::make($image)->save(public_path("capturas_asistencia"."/".$filename));

            $registro->update();
        }
        return Redirect::to('asistencia/registro')->with(['success' => 'Salida registrada correctamente.']);

    }

    public function detallePdf($id){
        $mytime = Carbon::now();
        $fecha = $mytime->toDateString();
        $empresa=DB::table('empresa')->first();
        $informe=DB::table('registro')->where('IdRegistro', '=', $id)->first();
        $usuario=DB::table('usuario')->where('IdUsuario', '=', $informe->IdUsuario)->first();

        $pdf = \PDF::loadView('asistencia/registro.report', ["usuario"=>$usuario,"informe"=>$informe,
        "fecha"=>$fecha, "empresa"=>$empresa]);
        return $pdf->stream('Detalle de asistencia');
    }

    public static function  RestarHoras($timeini,$timefin)
    {
        $fecha1= new DateTime($timeini);
        $fecha2= new DateTime($timefin);
        $resultado = $fecha1 -> diff($fecha2);
        return $resultado -> format ('%H:%I:%S');
    }

}
function fechaCastellano ($fecha) {
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


