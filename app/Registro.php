<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Registro extends Model
{
    protected $table='registro';
    protected $primaryKey="IdRegistro";

    public $timestamps=false;

    protected $fillable=[
        'LatitudEntrada','LongitudEntrada','FechaRegistro',
        'HoraEntrada','HoraSalida','LatitudSalida', 'LongitudSalida', 'IdUsuario'
    ];
    protected $guarded =[

    ];
}
