<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PasistenciaController extends Controller
{
    public function index(Request $request)
    {
       if($request)
        {
        //     $query = trim ($request -> get('searchText'));
        //     $Cliente = DB::table('Cliente as a')
        //     ->join('TipoCliente as c','a.IdTipoCliente','=','c.IdTipoCliente')
        //     ->select('a.IdCliente','a.Nombre','a.Apellido','a.Celular'
        //     ,'a.Correo','a.TipDocumento','a.NumDocumento','a.Direccion','c.Denominacion as Denominacionc',)
        //     ->where('a.Nombre','LIKE','%'.$query.'%') 
        //     ->orwhere('c.Denominacion','LIKE','%'.$query.'%')     
        //     ->orderBy('IdCliente','desc')
        //     ->paginate(7);
          return view('personal.asistencia.index');
        //echo "ENTRE JAJA";
          }
    }
}

