<?php



Route::get('Excel',array('as'=>'Excel','uses'=>'MatrizController@excel_upload_interface'));

Route::get('Correo',array('as'=>'Mail','uses'=>'MailController@index'));

Route::post('Upload/Excel','MatrizController@excel_upload_file');

Route::get("matriz/matrices",array('as'=>'matriz.matrices','uses'=>"MatrizController@index"));

Route::get("matriz/arreglos",array('as'=>'matriz.arreglos','uses'=>"MatrizController@data_to_fix"));

Route::get("matriz/herramientas",array('as'=>'matriz.herramientas','uses'=>"ToolController@herramientas"));

Route::get("matriz/graficas",array('as'=>'matriz.graficas','uses'=>"ReportController@graficas"));

Route::get("matriz/management_filterenterprise/{enterprise}","MatrizController@filter_enterprise");

Route::get("matriz/fixing_filter/{enterprise}","MatrizController@filter_enterprise2");

Route::get("matriz/management_other_filters/{empresa}/{tipo_matriz}/{factores}/{categorias}/{tipo_norma}/{norma}/{year}/{articulos}/{autoridad_emisora}/{version}/{estado_requisitos}","MatrizController@other_filters");

Route::get ('matriz/filterfactores/{id}','FilterController@filter_factores');

Route::get ('matriz/filtercategorias/{id}','FilterController@filter_categorias');

Route::get ('matriz/filternormas/{id}','FilterController@filter_normas');

Route::get ('matriz/filterarticulos/{id}','FilterController@filter_articulos');

Route::post ('matriz/get_emision_and_autority','FilterController@get_emision_and_autority');

Route::get ('matriz/filterautoridad/{id}','FilterController@filter_autoridad');

Route::get ('matriz/filteryear/{id}','FilterController@filter_year');

Route::get ('matriz/filterliteral/{id}','FilterController@filter_literal');

Route::get ('matriz/insertar_factor/{value}/{foid}','MatrizController@insertar_factor');

Route::get ('matriz/insertar_categoria/{value}/{foid}','MatrizController@insertar_categoria');

Route::get ('matriz/insertar_tpnorma/{value}','MatrizController@insertar_tpnorma');

Route::get ('matriz/insertar_autoridad/{value}','MatrizController@insertar_autoridad');

Route::get ('matriz/insertar_articulo/{value}/{foid}','MatrizController@insertar_articulo');

Route::get ('matriz/insertar_literal/{value}/{foid}','MatrizController@insertar_literal');

Route::get ('matriz/insertar_norma/{value}/{tp}/{y}/{au}','MatrizController@insertar_norma');

Route::post('matriz/create_requisito','MatrizController@create_requisito');

Route::get('matriz/edit_requisito/{id}','MatrizController@edit_requisito');

Route::any('matriz/update_requisito/{id}','MatrizController@update_requisito');

Route::get('matriz/delete_requisito/{id}','MatrizController@delete_requisito');

Route::get("matriz/passdata/{id}",'MatrizController@pass_data');

Route::post('matriz/evaluate','MatrizController@make_evaluation');

Route::get('matriz/evalinfo/{id}','MatrizController@evalinfo');

Route::post('matriz/matriz_update_cumplimiento','MatrizController@update_cump');

Route::get("matriz/passdata2/{id}",'MatrizController@pass_data2');

Route::get('borrando',array('as'=>'delete_no_valid','uses'=>'MatrizController@delete_no_valid'));

Route::get('borrando2',array('as'=>'delete_no_valid_2','uses'=>'MatrizController@delete_no_valid_2'));

Route::get("matriz/herramientas/normas",'ToolController@normas');

Route::get("matriz/herramientas/articulos",'ToolController@articulos');

Route::get("matriz/herramientas/literales",'ToolController@literales');

Route::get("matriz/herramientas/tpnorma",'ToolController@tpnorma');

Route::get("matriz/herramientas/autoridad",'ToolController@autoridad');

Route::get("matriz/herramientas/year",'ToolController@year');

Route::get("matriz/herramientas/factores",'ToolController@factores');

Route::get("matriz/herramientas/categorias",'ToolController@categorias');

Route::get ('matriz/filterfactoreswithemp/{id}/{emp}','FilterController@filter_factores_emp');

Route::get ('matriz/filtercategoriaswithemp/{id}/{emp}','FilterController@filter_categorias_emp');

Route::get ('matriz/filtertpswithemp/{id}','FilterController@filter_tpnorma_emp');

Route::get ('matriz/filteraeswithemp/{id}','FilterController@filter_autoridad_emp');

Route::get ('matriz/filternormaswithemp/{id}/{emp}','FilterController@filter_normas_emp');

Route::get ('matriz/filterarticuloswithemp/{id}/{emp}','FilterController@filter_articulos_emp');

Route::get ('matriz/get_versions/{id}','MatrizController@filter_versions');

//-----------Crud de elementos de la matriz----------------------------//

Route::post("matriz/actualizar_categoria",'ToolController@actualizar_categoria');

Route::post("matriz/nueva_categoria",'ToolController@nueva_categoria');

Route::get("matriz/eliminar_categoria/{id}",'ToolController@eliminar_categoria');

Route::post("matriz/nuevo_factor",'ToolController@nuevo_factor');

Route::post("matriz/actualizar_factor",'ToolController@actualizar_factor');

Route::get("matriz/eliminar_factor/{id}",'ToolController@eliminar_factor');

Route::post("matriz/nuevo_year",'ToolController@nuevo_year');

Route::post("matriz/actualizar_year",'ToolController@actualizar_year');

Route::get("matriz/eliminar_year/{id}",'ToolController@eliminar_year');

Route::post("matriz/nueva_autoridad",'ToolController@nueva_autoridad');

Route::post("matriz/actualizar_autoridad",'ToolController@actualizar_autoridad');

Route::get("matriz/eliminar_autoridad/{id}",'ToolController@eliminar_autoridad');

Route::post("matriz/nuevo_tpnorma",'ToolController@nuevo_tpnorma');

Route::post("matriz/actualizar_tpnorma",'ToolController@actualizar_tpnorma');

Route::get("matriz/eliminar_tpnorma/{id}",'ToolController@eliminar_tpnorma');

Route::post("matriz/nuevo_literal",'ToolController@nuevo_literal');

Route::post("matriz/actualizar_literal",'ToolController@actualizar_literal');

Route::get("matriz/eliminar_literal/{id}",'ToolController@eliminar_literal');

Route::post("matriz/nuevo_articulo",'ToolController@nuevo_articulo');

Route::post("matriz/actualizar_articulo",'ToolController@actualizar_articulo');

Route::get("matriz/eliminar_articulo/{id}",'ToolController@eliminar_articulo');

Route::post("matriz/nueva_norma",'ToolController@nueva_norma');

Route::post("matriz/actualizar_norma",'ToolController@actualizar_norma');

Route::get("matriz/eliminar_norma/{id}",'ToolController@eliminar_norma');

//--------------------------------------------------------------------------------------------//


//--- Arreglar requisitos ----------------- //

Route::post("matriz/manual_fixing",'FixingupController@manual_fixing');

Route::get("matriz/eliminar_requisito_noguardado/{id}",'FixingupController@eliminar_requisito');

Route::post("matriz/change_fixreq_tpnorma",'FixingupController@fixreq_tpnorma');

//-----------Derogar----------------------//

Route::get("matriz/derogar_norma/{foid}/{id}",'ToolController@derogar_norma');

Route::get("matriz/derogar_articulo/{foid}/{id}",'ToolController@derogar_articulo');

Route::get("matriz/derogar_literal/{foid}/{id}",'ToolController@derogar_literal');

Route::get("matriz/derogar_info/{id}",'ToolController@derogar_info');

Route::get("matriz/derogar_info_2/{id}",'ToolController@derogar_info_2');

Route::get("matriz/derogar_info_3/{id}",'ToolController@derogar_info_3');

Route::get("matriz/anular_derogar_norma/{id}",'ToolController@anular_derogar_norma');

Route::get("matriz/anular_derogar_articulo/{id}",'ToolController@anular_derogar_articulo');

Route::get("matriz/anular_derogar_literal/{id}",'ToolController@anular_derogar_literal');

//-----------------Pasar Datos -----------------------------------------------------------------//

Route::get("matriz/pass_autoridad/{id}/{foid}",'ToolController@pass_autoridad');

Route::get("matriz/pass_factor/{id}/{foid}",'ToolController@pass_factor');

Route::get("matriz/pass_categoria/{id}/{foid}",'ToolController@pass_categoria');

Route::get("matriz/reemplazar_norma/{foid}/{id}",'ToolController@replace_norma');

Route::get("matriz/reemplazar_articulo/{foid}/{id}",'ToolController@replace_articulo');

Route::get("matriz/pass_tpnorma/{id}/{foid}",'ToolController@pass_tpnorma');

//---Comentarios-------//

Route::post("matriz/registercomment",'MatrizController@nuevo_comentario');

Route::get("matriz/comments_in_req/{id}","MatrizController@lista_comentarios");

Route::get("matriz/archivo_comentario/{id}","MatrizController@archivo_comentario");

//-----------------------Lista evaluaciones ---------------------------------//

Route::get("matriz/all_evals/{id}","MatrizController@all_evals");

//----------------------------------------//

Route::get("matriz/gcharts/{empresa}/{tipo}","ReportController@draw_g");

//-------- Descarga Excel -----------//

Route::get("matriz/download_excel/{id}/{tipo}","EmpresaController@exportar");

Route::get("matriz/download_excel2/{id}/{tipo}","EmpresaController@exportar2");

//-----------------------------------//

//--------Correos--------------------//

Route::get("Correo/delete_mail/{id}","MailController@delete");

Route::get("Correo/look_by_form/{id}","MailController@form");

Route::post("Correo/sendemail","MailController@send");

Route::post("Correo/sendemail2","MailController@send2");

Route::get("Correo/permisos","MailController@permission");

Route::get("Correo/panel","MailController@email_panel");

Route::get("Correo/mipanel","MailController@emailbox");

Route::post("Correo/testmail","MailController@testmail");

//---------------------------------------//


//-----------NewSystem-----------//

Route::post("users_by_enterprise","EmpresaController@users_by_enterprise");

Route::post("Correo/asignarpermisos","MailController@assign_permission");

Route::post("Correo/info_plantilla_requisitos","MailController@info_plantilla_requisitos");

Route::post('matriz/replique_req','MatrizController@replique_req');

Route::post("angular/test","BrainController@test");

Route::get("angular/first_asistant_view","BrainController@verify_first_asistant_view");

Route::post("angular/first_asistant_view_watched","BrainController@verify_first_asistant_view_watched");

Route::post("angular/get_duplicate_records","BrainController@verify_duplicy_by_enterprise");

Route::get("angular/asistant_repair_duplicate","MatrizController@asistant_repair_duplicate");

Route::post("angular/repair_reqs","BrainController@repair_reqs");

Route::post("angular/automatic_repair","BrainController@automatic_repair");

Route::any("angular/CrudController","CrudController@dispatcher");

Route::any("angular/delete_replace","SystemController@delete_replace");

Route::any("angular/derogar","SystemController@derogar");

Route::any("angular/desderogar","SystemController@desderogar");

Route::post("angular/get_sessions","SystemController@user_session");

Route::post("angular/derogar_info","SystemController@derogar_info");

Route::post("angular/save_property_to_db","SystemController@save_property_to_db");

//--------------Versión 4 de matriz ------------------------------------------//

Route::get("matriz/matrizlegal",array('as'=>'matriz.version4','uses'=>"MatrizController@version4"));


