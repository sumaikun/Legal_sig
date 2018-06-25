<?php

namespace Sig\Http\Requests\Requisito;

use Sig\Http\Requests\Request;

class CreateRequisitoRequest extends Request
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
       $validate =  ['empresa' => 'required',
        'factorRiesgo' => 'required',
        'categoria' => 'required',
        'temas_grupo' => 'required',
        'normaid' => 'required',
        'articulos' => 'required',
        ];       

        return $validate;
    }
}
