<?php

namespace Sig\Http\Requests\Juridica;

use Sig\Http\Requests\Request;

class JuridicaRequest extends Request
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
    
        
         $validate =  [ 'archivo'=> 'mimes:application/vnd.openxmlformats-officedocument.wordprocessingml.document'
        
        ];   

        return $validate;
    }
}
