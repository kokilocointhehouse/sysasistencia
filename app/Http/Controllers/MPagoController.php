<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Carbon\Carbon;

class MPagoController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index(Request $request){
        if ($request) {
            $mytime = Carbon::now();
            $fecha = $mytime->toDateString();
            $start = Carbon::now()->startOfYear()->toDateString();

            $query=trim($request->get('searchText'));
            $query2=trim($request->get('searchText2'));

            if(empty($query)){
                $query = $start;
            }
            if(empty($query2)){
                $query2 = $fecha;
            }


            $pago = DB::table('pago as p')
            ->join('usuario as u', 'p.IdUsuario', '=', 'u.IdUsuario')
            ->whereBetween('fecha',array($query, $query2))
            ->where('u.Nombres', 'LIKE', '%' . auth()->user()->Nombres . '%')
            ->orderByDesc('IdPago')
            ->paginate(10);

            return view('reporte.mis_pagos.index',["pago"=>$pago,
            "searchText"=>$query, "searchText2"=>$query2]);
        }
    }

}
