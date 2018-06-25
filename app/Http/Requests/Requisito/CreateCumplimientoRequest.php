<?php

namespace Sig\Http\Requests\Requisito;

use Sig\Http\Requests\Request;

class CreateCumplimientoRequest extends Request
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
         
        $validate =  ['Requisito' => 'required|min:30|max:5000',
        'Evidenciaes' => 'required|min:30|max:5000',
        'Responsable' => 'min:7|max:45',
        'Area' => 'min:3|max:45',
       
        ];       

        return $validate;
    
    }
}
