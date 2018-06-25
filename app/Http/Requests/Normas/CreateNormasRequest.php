<?php

namespace Sig\Http\Requests\Normas;

use Sig\Http\Requests\Request;

class CreateNormasRequest extends Request
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
        $validate =  ['numero_norma' => 'required|min:1|max:35',
        'norma_relacionadas' => 'max:400',
        'descripcion_norma' => 'max:1000',
        'yearemision_id' => 'required',
        'autoridad_emisora_id' => 'required',
        'tipo_norma_id' => 'required',

        ];

        return  $validate;
    }
}
