<?php

namespace Sig\Http\Controllers;

use Illuminate\Http\Request;

use Sig\Http\Requests;
use Sig\Models\Empresa;

use Auth;

use Session;


class ActionController extends Controller
{

  	public function __construct()
    {
    	$this->middleware('auth');

         if(Auth::user()!=null) 
        {  
         	$this->usuario = Auth::user()->idusuario;
        } 
        else
        {
            return  redirect()->guest('/');
        }
        if(Auth::user()->rol_id!=1)
        {           
            $array = Permission::Permission_array();
            $this->empresas=Empresa::Wherein('idempresa',$array)->lists('nombre','idempresa'); 
        }   
        else
        {     
            $this->empresas=Empresa::lists('nombre','idempresa');
        }
         
    }


    public function execute_action(Request $request)
    {
        
        $current_action = Session::get('current_action');
        $current_action->execute(); 
    }

   

}