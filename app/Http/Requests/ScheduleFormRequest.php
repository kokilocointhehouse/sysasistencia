<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;
class ScheduleFormRequest extends FormRequest
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
            'name'=>'max:191|required|unique:schedule,name,'.  $this->id . ',id,idEmpresa,' . $miEmpresa->idEmpresa,
            'checkinTime'=>'required',
            'departureTime'=>'required|after:checkinTime'
        ];
    }

    public function messages()
    {

        return [
            'name.unique'=> 'El valor del nombre del horario ya está en uso.',
            'departureTime.after' => 'El valor de la hora de salida debe ser una hora posterior al de la hora de entrada.'
        ];
    }
}
