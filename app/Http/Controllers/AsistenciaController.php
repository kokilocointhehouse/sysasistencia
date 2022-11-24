<?php

namespace App\Http\Controllers;

use App\BranchOffice;
use Illuminate\Http\Request;
use App\Registro;
use App\Schedule;
use App\User;
use Exception;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Intervention\Image\ImageManagerStatic as Image;

class AsistenciaController extends Controller
{

    public function store(Request $request)
    {
        $mytime = Carbon::now();
        $fecha = $mytime->toDateString();
        $informe = DB::table('registro as r')->join('usuario as u', 'r.IdUsuario', 'u.IdUsuario')
            ->where('FechaRegistro', $fecha)
            ->where('NumDocumento',  $request->get('NumDocumento'))
            ->first();

        $usuario = User::where('NumDocumento', $request->get('NumDocumento'))->where('TipoUsuario', 'PERSONAL')->first();

        if (isset($informe)) {
            if ($informe->HoraSalida == null) {
                try {
                    $consideracion = $this->obtener_rango($usuario->idBranch_office, $request->get('ubicacion'));
                    $ubicacion = explode(',', $request->get('ubicacion'));

                    $registro = Registro::findOrFail($informe->IdRegistro);
                    $registro->LatitudSalida = $ubicacion[0];
                    $registro->LongitudSalida = $ubicacion[1];
                    $registro->HoraSalida =  $mytime->toTimeString();
                    $registro->Consideracion2 = $consideracion;

                    $img = $_POST['fotocamara'];
                    $img = str_replace('data:image/png;base64,', '', $img);
                    $img = str_replace(' ', '+', $img);
                    $image = base64_decode($img);
                    $extension = "png";
                    $filename = $informe->IdRegistro . date('h-i-s') . date('m-d') . '.' . $extension;
                    $registro->capturaSalida = $filename;
                    Image::make($image)->save(public_path("capturas_asistencia" . "/" . $filename));
                    $registro->update();
                    return redirect()->back()->with(['success' => $usuario->Nombres . ' marcó su salida.']);
                } catch (Exception $th) {
                    return redirect()->back()->with(['error' => $th->getMessage()]);
                }
            } else {
                return redirect()->back()->with(['info' => 'El usuario ya marcó su entrada y salida.']);
            }
        } elseif (!isset($informe) && isset($usuario)) {
            try {
                $consideracion = $this->obtener_rango($usuario->idBranch_office, $request->get('ubicacion'));
                $ubicacion = explode(',', $request->get('ubicacion'));
                $registro = new Registro;
                $registro->LatitudEntrada = $ubicacion[0];
                $registro->LongitudEntrada = $ubicacion[1];
                $registro->FechaRegistro = $mytime->toDateString();
                $registro->HoraEntrada = $mytime->toTimeString();
                $registro->Consideracion = $consideracion;

                $img = $request->get('fotocamara');
                $img = str_replace('data:image/png;base64,', '', $img);
                $img = str_replace(' ', '+', $img);
                $image = base64_decode($img);
                $extension = "png";
                $filename = $usuario->IdUsuario . date('h-i-s') . date('m-d') . '.' . $extension;
                $registro->capturaEntrada = $filename;
                Image::make($image)->save(public_path("capturas_asistencia" . "/" . $filename));
                $registro->IdUsuario = $usuario->IdUsuario;
                $registro->save();
                return redirect()->back()->with(['success' => $usuario->Nombres . ' marcó su entrada.']);
            } catch (Exception $th) {
                return redirect()->back()->with(['error' => $th->getMessage()]);
            }
        } else {
            return redirect()->back()->with(['info' => 'Usuario no encontrado.']);
        }
        // return Redirect::to('acceso/usuarios')->with(['success' =>  $usuario->Nombres . ' agregado, correctamente!.']);
    }

    public function obtener_rango($id, $ubicacion)
    {
        $ubicacion = explode(',', $ubicacion);
        $ub_sucursal = BranchOffice::findOrfail($id);
        $aux = $ubicacion[0] * 10000000;
        $auy = $ubicacion[1] * 10000000;
        $lat_empresa = $ub_sucursal->latitude * 10000000;
        $log_empresa = $ub_sucursal->longitude * 10000000;
        $punto = pow(($aux - (1 * $lat_empresa)), 2) + pow(($auy - (1 * $log_empresa)), 2);
        $radio = $ub_sucursal->radius * 100;

        return $punto <= pow($radio, 2) ? 'CORRECTO' : 'FUERA DE RANGO';
    }
}
