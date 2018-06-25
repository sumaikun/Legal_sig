<?php

namespace Sig\Models;

use Illuminate\Database\Eloquent\Model;

class MailPermission extends Model
{
	public $timestamps = false;
    protected $table = 'permisos_usuarios_correos';
}
