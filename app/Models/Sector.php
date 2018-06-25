<?php

namespace Sig\Models;
use Iatstuti\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sector extends Model
{
	use SoftDeletes,CascadeSoftDeletes;

 protected $table = 'sector';

 protected $primaryKey ='idsector';

 protected $fillable = ['sector','idsector'];

 protected $cascadeDeletes = ['industrias'];

 public $timestamps = false;

  public function industrias()
 {
        return $this->hasMany('Sig\Industria','sector_id','idsector');
 }

}
