<?php

namespace Sig\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Industria extends Model
{
  
 use SoftDeletes;

 protected $table = 'industria';

 protected $primaryKey ='idindustria';

 protected $fillable = ['sector_id','industria','idindustria'];

 public $timestamps = false;

 public static function industrias($id){
  return Industria::where('sector_id','=',$id)
  ->get();

 }
   

}
