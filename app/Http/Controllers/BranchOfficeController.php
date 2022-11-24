<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\BranchOfficeFormRequest;
use Illuminate\Support\Facades\Auth;
use App\BranchOffice;
use App\User;
use Exception;
use Illuminate\Support\Facades\Redirect;

class BranchOfficeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(Request $request)
    {

        if (auth()->user()->TipoUsuario == "PERSONAL") {
            Auth::logout();
            return redirect('/')
                ->with('flash', 'Usted no tiene privilegios para ingresar en la ruta solicitada.');
        }
        if ($request) {
            $query = trim($request->get('searchText'));

            $miEmpresa = DB::table('usuario as u')->join('branch_office as b', 'u.idBranch_office', 'b.id')
                ->where('u.IdUsuario', auth()->user()->IdUsuario)->first();

            $branchOffice = BranchOffice::where('idEmpresa', $miEmpresa->idEmpresa)
                ->where('name', '!=', 'solo_admin')
                ->where(function ($q)  use ($query) {
                    $q->orWhere('name', 'LIKE', '%' . $query . '%');
                })
                ->paginate(10);

            return view('acceso.branchoffice.index', ["branchOffice" => $branchOffice, "searchText" => $query]);
        }
    }

    public function store(BranchOfficeFormRequest $request)
    {
        $miEmpresa = DB::table('usuario as u')->join('branch_office as b', 'u.idBranch_office', 'b.id')->where('u.IdUsuario', auth()->user()->IdUsuario)
            ->first();

        try {
            $ubicacion = explode(",", $request->get('ubicacion'));
            $branchOffice = new BranchOffice();
            $branchOffice->name = $request->get('name');
            $branchOffice->latitude = $ubicacion[0];
            $branchOffice->longitude = trim($ubicacion[1]);
            $branchOffice->radius = $request->get('radius');
            $branchOffice->address = $request->get('address');
            $branchOffice->idEmpresa = $miEmpresa->idEmpresa;
            $branchOffice->save();
            return Redirect::to('acceso/branchoffice')->with(['success' =>  $branchOffice->name . ' agregado, correctamente!.']);
        } catch (Exception $e) {
            return Redirect::to('acceso/branchoffice')->with(['error' => $e->getMessage()]);
        }
    }

    public function edit($id)
    {
        return view("acceso.branchoffice.edit", ["branchOffice" => BranchOffice::findOrFail($id)]);
    }

    public function update(BranchOfficeFormRequest $request, $id)
    {

        $branchOffice = BranchOffice::findOrFail($id);
        $branchOffice->name = $request->get('name');
        $ubicacion = explode(",", $request->get('ubicacion'));
        $branchOffice->latitude = $ubicacion[0];
        $branchOffice->longitude = trim($ubicacion[1]);
        $branchOffice->radius = $request->get('radius');
        $branchOffice->address = $request->get('address');
        $branchOffice->update();

        return Redirect::to('acceso/branchoffice')->with(['success' =>  $branchOffice->name . ' modificado, correctamente!.']);
    }


    public function destroy(Request $request, $id)
    {
        try {
            if ($request->ajax()) {

                $docu   = BranchOffice::findOrFail($id);

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

    public static function validation_destroy($id)
    {
        return count(User::all()->where('idBranch_office', $id)) > 0 ? true : false;
    }
}
