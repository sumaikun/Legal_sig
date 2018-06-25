<?php

namespace Sig\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Factores extends Model
{
	use SoftDeletes;
		
    protected $table="Factores";

    public function tipo()
	{
	    return $this->hasone('Sig\Models\Tipomatriz','id','id_Tipo_matriz');
	}  
}
