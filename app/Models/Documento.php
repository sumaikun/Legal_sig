<?php

namespace Sig\Models;

use Illuminate\Database\Eloquent\Model;
use Sig\Observers\MailObserver;

class Documento extends Model
{
    protected $table = 'documentos';


	  public function empresas()
	  {
	    return $this->hasone('Sig\Models\Empresa','idempresa','empresa');
	  }

	  public static function boot() {
        parent::boot();
 
        Documento::observe(new MailObserver());
    }  
}
