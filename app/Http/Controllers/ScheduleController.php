<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\ScheduleFormRequest;
use Illuminate\Support\Facades\Auth;
use App\Schedule;
use App\User;
use Illuminate\Support\Facades\Redirect;

class ScheduleController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }
    public function index(Request $request)
    {

        if (auth()->user()->TipoUsuario =="PERSONAL"){
            Auth::logout();
            return redirect('/')
            ->with('flash','Usted no tiene privilegios para ingresar en la ruta solicitada.');
        }
        if ($request) {
            $query=trim($request->get('searchText'));

            $miEmpresa = DB::table('usuario as u')->join('branch_office as b', 'u.idBranch_office', 'b.id')
            ->where('u.IdUsuario', auth()->user()->IdUsuario)->first();

            $schedule = Schedule::where('idEmpresa', $miEmpresa->idEmpresa)
            ->where('name', '!=', 'solo_admin')
            ->where(function ($q)  use ($query) {
                $q->orWhere('name', 'LIKE' , '%' . $query . '%');
            })
            ->paginate(10);

            return view('acceso.schedule.index',["schedule"=>$schedule,"searchText"=>$query]);
        }

    }

    public function store(ScheduleFormRequest $request)
    {
        $miEmpresa = DB::table('usuario as u')->join('branch_office as b', 'u.idBranch_office', 'b.id')->where('u.IdUsuario', auth()->user()->IdUsuario)
        ->first();

        $schedule = new Schedule();
        $schedule->name = $request->get('name');
        $schedule->checkinTime = $request->get('checkinTime');
        $schedule->departureTime = $request->get('departureTime');
        $schedule->idEmpresa = $miEmpresa->idEmpresa;
        $schedule->save();

        return Redirect::to('acceso/schedule')->with(['success' =>  $schedule->name . ' agregado, correctamente!.']);
    }

    public function edit($id)
    {
        return view("acceso.schedule.edit",["schedule"=>Schedule::findOrFail($id)]);
    }

    public function update(ScheduleFormRequest $request, $id)
    {
        $schedule = Schedule::findOrFail($id);
        $schedule->name = $request->get('name');
        $schedule->checkinTime = $request->get('checkinTime');
        $schedule->departureTime = $request->get('departureTime');
        $schedule->update();
        return Redirect::to('acceso/schedule')->with(['success' =>  $schedule->name . ' modificado, correctamente!.']);
    }


    public function destroy(Request $request, $id)
    {
        try {
            if ($request->ajax()) {

                $docu   = Schedule::findOrFail($id);

                if ($docu->delete()) {
                    return response()->json([
                        'success' => true,
                        'message' => '¡Satisfactorio!, Registro eliminado con éxito.',
                    ]);
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => '¡Error!, No se pudo eliminar.',
                    ]);
                }
            }
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => '¡Error!, Este registro tiene enlazado uno o mas registros.',
                ]);
            }
        }
    }

    public static function validation_destroy($id){
        return count(User::all()->where('idSchedule', $id)) > 0 ? true : false;
    }

}
