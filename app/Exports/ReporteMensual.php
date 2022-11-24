<?php

namespace App\Exports;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Carbon\Carbon;

class ReporteMensual implements FromView, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    private $f1, $f2, $f3;
    public function __construct($f1, $f2, $f3){
        $this->f1 = $f1;
        $this->f2 = $f2;
        $this->f3 = $f3;
    }
    public function view(): View{
            $mes = $this->f1;
            $anio = $this->f2;

            if($this->f3 == 'NADA'){
                $this->f3 = '-1';

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
                ->where('IdUsuario', $this->f3)
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
            $usuario=DB::table('usuario')->where('IdUsuario', '=', $this->f3)->first();
        //
        return view('exports.reportmonth', ["usuario"=>$usuario, "id"=>$this->f1, "id2"=>$this->f2,
         "empresa"=>$empresa, "fecha"=>$fecha, "array_fechas"=>$array_fechas]);
    }
}
