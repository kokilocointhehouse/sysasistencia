<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    protected $table='empresa';
    protected $primaryKey="idEmpresa";

    public $timestamps=false;

    protected $fillable=[
        'nomEmpresa','Direccion','Latitud','Longitud','Logo', 'Radio'
    ];
    protected $guarded =[

    ];
}
