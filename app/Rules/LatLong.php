<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class LatLong implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $ubicacion = explode(",", $value);
        if (count($ubicacion) == 2){
            if(is_numeric($ubicacion[0]) && is_numeric($ubicacion[1])){
                return true;
            }
        }
        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Debe de ingresar una ubicación correcta.';
    }
}
