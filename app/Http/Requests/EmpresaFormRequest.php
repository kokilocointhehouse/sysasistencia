<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmpresaFormRequest extends FormRequest
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
            // 'idEmpresa'=>'max:11',
            'nomEmpresa'=>'max:30|required',
            'Direccion'=>'max:30',
            'Latitud'=>'max:30',
            'Longitud'=>'max:30',
            'Logo'=> !empty($this->Logo) ? 'mimes:jpg,jpeg,bmp,png' : '',
            // 'pagoHora'=>'|',
            'radio'=>'max:50'

        ];
    }

    public function messages()
    {

        return [
            'pagoHora.required'=> 'Tiene que ingresar el Pago por Hora.',
            'Nombre.required'=> 'Tiene que ingresar el Nombre de la Empresa.',
            'pagoHora.numeric'=> 'El pago de Hora tiene que ser un valor numérico.',

        ];
    }
}
