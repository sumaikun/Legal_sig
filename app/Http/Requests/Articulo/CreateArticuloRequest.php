<?php

namespace Sig\Http\Requests\Articulo;

use Sig\Http\Requests\Request;

class CreateArticuloRequest extends Request
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
         $validate =  ['normaid' => 'required',
        'numero_articulo' => 'required|max:31',
        'literal_numeral' => 'max:31',
        ];

        return  $validate;
    }
}
