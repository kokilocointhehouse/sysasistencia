<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Carbon\Carbon;
use App\User;
class RangoFecha implements FromView, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    private $f1, $f2;
    public function __construct($f1, $f2, $f3){

        $this->f1 = $f1;
        $this->f2 = $f2;
        $this->f3 = $f3;

    }
    public function view(): View{
        $mytime = Carbon::now();
        $fecha = $mytime->toDateString();
        if($this->f3 == 'TODO'){
            $this->f3 = '';
        }
        $empresa=DB::table('empresa')->first();

        $informe=DB::table('registro as r')
            ->join('usuario as u', 'r.IdUsuario', '=', 'u.IdUsuario')
            ->select('r.IdRegistro', 'FechaRegistro', 'HoraEntrada',
            'Nombres', 'EncargadoUpdt', 'HoraEntradaU', 'HoraSalidaU', 'Observacion',
            'HoraSalida', 'u.Nombres', 'u.NumDocumento', 'LatitudEntrada', 'LongitudEntrada',
            'LatitudSalida', 'LongitudSalida', 'Consideracion', 'Consideracion2')
            ->whereBetween('FechaRegistro',array($this->f1, $this->f2))
            ->where('u.IdUsuario', empty($this->f3) ? '!=' : '=',  empty($this->f3) ? '-1' : $this->f3)
            // ->where('s.idEmpresa', auth()->user()->TipoUsuario == 'ADMINISTRADOR' ? '=' : '!=', auth()->user()->TipoUsuario == 'ADMINISTRADOR' ? $miEmpresa->idEmpresa : '-1')
            ->where('u.Estado', '=', 'ACTIVO')
            ->orderBy('FechaRegistro', 'desc')
            ->orderBy('u.IdUsuario')
            ->orderBy('HoraEntrada','desc')
            ->get();
        $usuario = empty($this->f3) ? '' : User::findOrfail($this->f3);

        return view('exports.reportrange', ["id"=>$this->f1, "id2"=>$this->f2,
        "id3"=>$this->f3,"fecha"=>$fecha,"informe"=>$informe, "empresa"=>$empresa, "usuario"=>$usuario]);
    }
}
