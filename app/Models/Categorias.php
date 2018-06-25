<?php

namespace Sig\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Categorias extends Model
{
	use SoftDeletes;
    protected $table="Categorias";
    public function factor()
	{
	    return $this->hasone('Sig\Models\Factores','id','id_Factores');
	}
}
