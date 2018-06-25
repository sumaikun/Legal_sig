<?php

namespace Sig\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Iatstuti\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Tiponorma extends Model
{
	use SoftDeletes,CascadeSoftDeletes;

	protected $table = 'Tipo_norma';

	
	   public function normas()
 	{
        return $this->hasMany('Sig\Normas','id_Tipo_norma','id');
 	}    

}
