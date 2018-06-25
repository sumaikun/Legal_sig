<?php


namespace sig\Http\Controllers;

use Illuminate\Http\Request;

use Sig\Http\Requests;
use Sig\Http\Controllers\Controller;


class FrontController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth',['only'=>'admin']);      
    }

    public function index()
    {
        //
    }
   public function admin(){
        
        return view('admin.principal');
   }


}
