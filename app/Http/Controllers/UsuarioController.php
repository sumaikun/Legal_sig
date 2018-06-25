<?php


namespace sig\Http\Controllers;

use Illuminate\Http\Request;
use Sig\Models\Usuario;
use Sig\Models\Rol;
use Sig\Http\Requests;
use Sig\Http\Requests\usuario\UsuarioCreateRequest; 
use Sig\Http\Requests\usuario\UsuarioUpdateRequest;
use Sig\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;

class UsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
        public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('Admin',['only'=>['create','edit']]);      
    }
    
    public function redirection()
    {
        return view('admin.principal');
    }

    public function index() 
    {
        $users = Usuario::get();
        $roles = Rol::lists('nombre','idrol');
       // $users = \Sig\Usuario::All();
        return view('usuario.visualizar',compact('users','roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Rol::lists('nombre','idrol');
        return view('usuario.crear',compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UsuarioCreateRequest $request)
    {
        

        if($_POST['rol']==null)
        { 
          return redirect('Usuario/create')->with('message','invalid');    
           
         }
         else {
             Usuario::create([
           

               'nombre' => $request['nombre'],
               'usuario' => $request['usuario'],
               'password' => $_POST['password'],
               'correo' => $_POST['correo'],
                $rol =$_POST['rol'],
                $rolint = (int)$rol,              
                'rol_id' => $rolint,                
            ]);
             return redirect('Usuario')->with('message','store');

         }    

    }



    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

            $usuario = Usuario::find($id);
        return view('usuario.CambioEstado',['usuario'=>$usuario]);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit ($id)
    {
        $user = Usuario::find($id);
        return $user;  
    }

  

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $id = $request->id;

        $consulta = Usuario::where('correo', '=', $request->correo)->count();   
            
        $consulta2 = Usuario::where('correo', '=', $request->correo)->value('idusuario');
          
        if(($consulta==1 and $id==$consulta2)||($consulta==0))
        {
            $user = Usuario::find($id);
            $user->rol_id =  $request['rol'];
            $user->correo = $request->correo;
            $user->nombre = $request->nombre;
            $user->estado = $request->estado;            
            $user-> save();
            return redirect('/Usuario')->with('message','update');
        } 
        
        elseif ($consulta>1) {
            return redirect('Usuario')->with('message','error_correos');
           }   

        else
        {
           return redirect('Usuario')->with('message','error_correos');  
        }  
 
    }

    public function cambiarPsw(Request $request)
    {       
            $usuario = Usuario::find($request->id);
            $usuario->password = $request->password;           
            $usuario-> save();
            return redirect('Usuario')->with('message','update');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy ($id)
    {        
          $user = Usuario::find($id);
          $user -> delete();
            return redirect('Usuario')->with('message','deleted');
    }

    public function checkedempresa($id)
    {
        $query = Usuario::Where('idusuario','=',$id)->value('EmpresasPermiso');
        return $query;
    }

    


}
