<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UsuarioFormRequest extends FormRequest
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
        return [
            'Nombres'=>'max:80|required',
            'NumDocumento'=>'max:10|required|unique:usuario,NumDocumento,'.  $this->IdUsuario . ',IdUsuario',
            'password' => !empty($this->password) ? ['string', 'min:4', 'confirmed'] : '',
            'clave'=>'max:50',
            'Direccion'=>'max:191',
            'TelefCel'=>'max:15',
            'Correo'=>'max:50',
            'Estado'=>'max:20',
            'TipoUsuario'=>'max:20',
            'foto'=>'mimes:jpg,jpeg,bmp,png',
            'pagoHora' => $this->TipoUsuario == 'PERSONAL' ? 'required' : '',
            'idBranch_office' => $this->TipoUsuario == 'PERSONAL' ? 'required' : '',
        ];
    }

    public function messages()
    {

        return [
            'Nombres.required'=> 'Tiene que ingresar el nombre del Usuario.',
            'NumDocumento.required'=> 'Tiene que ingresar el N° de documento del Usuario.',
            'NumDocumento.unique'=> 'Ya existe un usuario registrado con el mismo N° de documento.',
            'NumDocumento.max' => 'El valor del N° de documento no debe contener más de 10 caracteres.',
            'idBranch_office.required' => 'El valor de la sucursal es obligatorio.',
        ];
    }
}
