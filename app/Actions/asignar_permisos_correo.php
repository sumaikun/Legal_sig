<?php

namespace Sig\Actions;

use Sig\Models\MailPermission;

class asignar_permisos_correo extends MailPermission implements actions 
{
    public function get_desc_action()
    {
    	return "Asignar permisos de usuario a correos";
    }

    public function get_title_action()
    {
    	return "Asignar permisos ";
    }

    public function get_url()
    {
    	return "asignarpermisos";
    }

    public function get_controller()
    {
        return "MailController@assign_permission";
    }

   
}
//Deberia haber una ruta hacia el lugar donde quiero asignar el permiso
?>