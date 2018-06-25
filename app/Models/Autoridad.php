<?php

namespace Sig\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Autoridad extends Model
{
	use SoftDeletes;

	protected $table = 'Autoridad_emisora';

 

}
