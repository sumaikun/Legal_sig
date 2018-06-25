<?php

namespace Sig\Http\Requests\Requisito;

use Sig\Http\Requests\Request;

class CreateEvaluacionRequest extends Request
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
               
        $validate =  ['evidenciacump' => 'required|min:30|max:5000',
        'calificacion'=>'required',
       
        ];       

        return $validate;
    }
}
