<?php

namespace Sig\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class Usuario extends Model implements AuthenticatableContract,
                                    AuthorizableContract, 
                                     CanResetPasswordContract                     
{
  use Authenticatable,Authorizable,CanResetPassword;

    protected $table = 'usuarios';

    protected $primaryKey = 'idusuario';

    protected $username = 'usuario';


  protected $fillable = ['rol_id','nombre', 'usuario', 'password','correo','estado','EmpresasPermiso'];

  protected $hidden = ['password', 'remember_token'];
  public function setPasswordAttribute($valor)
  {
    if(!empty($valor))
     {
       $this->attributes['password'] = \Hash::make($valor);
     }
  }

}