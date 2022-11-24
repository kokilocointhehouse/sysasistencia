<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BranchOffice extends Model
{
    protected $table='branch_office';
    protected $primaryKey="id";

    public $timestamps=false;

    protected $fillable=[
        'name','latitude','longitude','radius', 'address', 'idEmpresa'
    ];
}
