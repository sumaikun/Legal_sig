<?php


namespace sig\Http\Controllers;


use Illuminate\Http\Request;
use Auth;
use Session;
use Redirect;
use Sig\Http\Requests;
use Sig\Http\Controllers\Controller;
use Illuminate\Routing\Route;
use Sig\Models\Usuario;
use DB;


class LogController extends Controller
{
    

   /* public function __construct(){
         $this->beforeFilter('@find',['only'=>['edit','update','destroy']]);

    }*/
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)

    {
      
    
      $consulta = Usuario::where('usuario', '=', $request->usuario)->value('estado');
    
 
   

      //return $consulta;
       // $user = Usuario::where('usuario', '=', $request->usuario)->where('contraseña', '=', $request->contrasena)->first();
      $userdata=["usuario" =>$request->usuario,"password"=>$request->contrasena];   
     
     //return $user;
      if($consulta==2)
      {
        return redirect('/inicio')->with('message','inactivo');
      }
      elseif ($consulta==3) {
        return redirect('/inicio')->with('message','enMora');
      }

      else
      {

       if (Auth::attempt($userdata,false))
           {
                return Redirect::to('home');
                 
           }
        else 
           {
               return redirect('/inicio')->with('message','store');
           }        
     }


               
   }

    public function logout()
   {
        Auth::logout();
        return Redirect::to('/inicio');
   }


}
