<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PagoFormRequest extends FormRequest
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
            'IdUsuario'=>'required',
            'monto'=>'required|numeric',
            'nota'=>'max:180',
        ];
    }

    public function messages()
    {

        return [
            'IdUsuario.required' => 'Tiene que seleccionar un personal.'
        ];
    }
}
