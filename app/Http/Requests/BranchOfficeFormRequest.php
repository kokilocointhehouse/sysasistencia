<?php

namespace App\Http\Requests;

use App\Rules\LatLong;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;

class BranchOfficeFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $miEmpresa = DB::table('usuario as u')->join('branch_office as b', 'u.idBranch_office', 'b.id')
            ->where('u.IdUsuario', auth()->user()->IdUsuario)->first();
        return [
            'name'=>'max:191|required|unique:branch_office,name,'.  $this->id . ',id,idEmpresa,' . $miEmpresa->idEmpresa,
            'ubicacion'=>'required|max:191',
            'ubicacion'=>new LatLong(),
            'radius'=>'required|numeric',
            'address'=>'max:191',
        ];
    }

    public function messages()
    {
        return [
            'name.unique'=> 'El valor del nombre de la sucursal ya está en uso.',
            'latitude.required' => 'El valor de la latitud es requerido.',
            'longitude.required' => 'El valor de la longitud es requerido.',
            'radius.required' => 'El valor del radio es requerido.',
            'address.max' => 'El valor de la dirección no debe contener más de 191 caracteres'
        ];
    }
}
