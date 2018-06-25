<?php

namespace Sig\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Iatstuti\Database\Support\CascadeSoftDeletes;

class Normas extends Model
{
	use SoftDeletes,CascadeSoftDeletes;

  	protected $table = 'Normas';



	public function tp_norma()
	{
	    return $this->hasone('Sig\Models\Tiponorma','id','id_Tipo_norma');
	}

	public function autoridad()
	{
	    return $this->hasone('Sig\Models\Autoridad','id','id_Autoridad_emisora');
	}

	public function emision()
	{
	    return $this->hasone('Sig\Models\Year','id','id_Emision');
	}

	public function estado()
	{
	    return $this->hasone('Sig\Models\Vigencia','id','id_Estados_vigencia');
	}   

}