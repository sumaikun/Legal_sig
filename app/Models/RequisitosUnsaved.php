<?php

namespace Sig\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RequisitosUnsaved extends Model
{
      use SoftDeletes;

     protected $table = 'Requisitos_unsaved';
}
