<?php

namespace Sig\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Articulos extends Model
{
	use SoftDeletes;

protected $table = 'Articulos';

 
}
