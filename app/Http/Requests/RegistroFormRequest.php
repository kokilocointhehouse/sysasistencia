<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegistroFormRequest extends FormRequest
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
            'fecha_entrada'=>'required|unique:registro,FechaRegistro,'. $this->IdRegistro  . ',IdRegistro,IdUsuario,'. $this->idusuario,
            'latitud_entrada'=>'required'


        ];
    }

    public function messages()
    {

        return [
            'fecha_entrada.unique'=> 'Tu asistencia ya fue registrada.',
            'latitud_entrada.required'=> 'Permita acceder a su ubicación, por favor. Recargue nuevamente la página',
        ];
    }
}
