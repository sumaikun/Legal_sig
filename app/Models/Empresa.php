<?php


namespace Sig\Models;


use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
class Empresa extends Model
{
    protected $table = 'empresa';

    protected $primaryKey ='idempresa';

	protected $fillable = ['nombre','representante_legal','cargo','estado','comentario','sector_id','industria_id','path','factores','calificacion','aspectos','Usuario'];

    public function setPathAttribute($path){
    	if(!empty($path)){
			$name = Carbon::now()->second.$path->getClientOriginalName();
			$this->attributes['path'] = $name;
			\Storage::disk('local')->put($name, \File::get($path));
    	}
	}
	     
}

