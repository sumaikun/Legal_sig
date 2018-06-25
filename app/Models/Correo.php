<?php

namespace Sig\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Correo extends Model
{
    use SoftDeletes;
	protected $table = 'correos';

	  public function empresas()
	  {
	    return $this->hasone('Sig\Models\Empresa','idempresa','empresa');
	  }
}
