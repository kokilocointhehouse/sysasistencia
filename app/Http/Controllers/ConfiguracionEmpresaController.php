<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Empresa;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\EmpresaFormRequest;
use Illuminate\Support\Facades\Auth;


class ConfiguracionEmpresaController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }
    public function index()
    {
        if (auth()->user()->TipoUsuario =="PERSONAL"){
            Auth::logout();
            return redirect('/')
            ->with('flash','Usted no tiene privilegios para ingresar en la ruta solicitada.');
        }

        $miEmpresa = DB::table('usuario as u')
        ->join('branch_office as b', 'u.idBranch_office', 'b.id')
        ->where('u.IdUsuario', auth()->user()->IdUsuario)
        ->first();

        $empresa = Empresa::findOrfail($miEmpresa->idEmpresa);

        return view('configuracion.empresa.index',["empresa"=>$empresa]);


    }

    public function update(EmpresaFormRequest $request, $id)
    {
        $diasLaborados = "";
        if (!empty($request->get('diasLaborados'))){
            foreach ($request->get('diasLaborados') as $d) {
                $diasLaborados .= '_' . $d;
            }
            $diasLaborados = substr($diasLaborados, 1, strlen($diasLaborados));
        }
        $empresa=Empresa::findOrFail($id);
        $empresa->nomEmpresa = $request->get('nomEmpresa');
        $empresa->Direccion = $request->get('Direccion');

        if($request->hasFile('Logo')){
            $file = $request->file('Logo');
            $file->move(public_path().'/logo',$file->getClientOriginalName());
            $empresa -> Logo=$file->getClientOriginalName();
        }
        // $empresa->pagoHora = $request->get('pagoHora');
        $empresa->AperturaSistema = $request->get('AperturaSistema');
        $empresa->HoraEntrada = $request->get('HoraEntrada');
        $empresa->HoraSalida = $request->get('HoraSalida');
        // $ubicacion = explode(",", $request->get('ubicacion'));
        // $empresa->Latitud = $ubicacion[0];
        // $empresa->Longitud = $ubicacion[1];
        // $empresa->radio = $request->get('radio');
        $empresa->diasHabilitados = $diasLaborados;
        $empresa->update();
        return Redirect::to('configuracion/empresa')->with(['success' => 'La información fue modificada, correctamente!.']);

    }
}
