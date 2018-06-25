<?php

namespace Sig\Http\Middleware;
use Illuminate\Contracts\Auth\Guard;
use Closure;
use Session;

class Consultor
{

    protected $auth;

    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
           if($this->auth->user()->rol_id ==3)
        {
             return redirect('admin')->with('message','noAllowed');
        }
            return $next($request);
    }

}
