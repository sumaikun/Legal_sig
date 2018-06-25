<?php

namespace Sig\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Year extends Model
{
	use SoftDeletes;
	
    protected $table = 'Emision';

    
}
