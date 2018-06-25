<?php


namespace Sig\Http\Requests\usuario;

use Sig\Http\Requests\Request;

class UsuarioCreateRequest extends Request
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
        $validate =  ['nombre' => 'required|min:7|regex:/^[\pL\s\-]+$/u|max:45|unique:usuarios',
        
        'correo'=>'required|email|unique:usuarios',
       
        'password'=> 'required|min:8|max:18',

        'usuario'=> 'required|min:4|alpha|max:12|unique:usuarios',];

        return        
            $validate;
    }
}
