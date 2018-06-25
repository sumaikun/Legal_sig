<?php

namespace Sig\Http\Requests\enterprise;

use Sig\Http\Requests\Request;

class EmpresaCreateRequest extends Request
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
         $validate =  ['nombre' => 'required|min:7|max:50',
        
        'representante_legal'=>'min:7|regex:/^[\pL\s\-]+$/u|max:50',

        'cargo' =>'min:5|regex:/^[\pL\s\-]+$/u|max:50',
       
        'comentario'=> 'min:15|max:280',

        'logo'=> 'required',

        'tipoevaluacion'=> 'required'];       

        return $validate;
    }
}
