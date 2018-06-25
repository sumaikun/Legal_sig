<?php

namespace Sig\Http\Controllers;

use Illuminate\Http\Request;

use Sig\Http\Requests;

use Sig\Models\Usuario;

use Sig\Models\Rol;

use Sig\Models\Empresa;

use Illuminate\Support\Facades\Input;



class InterfazController extends Controller
{
    
       public function __construct()
    {
        $this->middleware('auth');
    }


    public function permisosUsuarioEmpresa()
    {
    	$users = Usuario::where('rol_id','!=','1')->get();
        //$users = Usuario::paginate(10);
        $roles = Rol::lists('nombre','idrol');
        $Empresas = Empresa::lists('nombre','idempresa'); 
        $totalEmpresas = Empresa::All()->count();
        $way = 3;       
        return view('Permisos.EmpresasUsuario',compact('users','roles','totalEmpresas','Empresas','way'));
    }

    public function getnamePermisos(Request $request , $id)
    {
        $permisos = Usuario::where('idusuario', '=', $id)->pluck('EmpresasPermiso');
        $permisos = substr($permisos,2,strlen($permisos)-4);             
        return $permisos;         
    }

    public function AsignaEmpresas()
    {        
        $usuario = Input::get('idusuario');   
        $totalEmpresas = Empresa::All()->count();        
        $numeros=array();
        for($i=1;$i<$totalEmpresas+1;$i++)
        {
            if( $dato = Input::get('empresa'.$i))
            {                
                array_push($numeros, $dato);
            }
        }
        if($numeros == null)
        {        
          $permisos = 'ninguna';
        }

        if($numeros != null)
        {
            $permisos = implode(",", $numeros);
        }
        $user = Usuario::find($usuario);        
        $user->EmpresasPermiso = $permisos;      
        $user-> save();

        return redirect('/permisos1')->with('message','update');
    }






}
