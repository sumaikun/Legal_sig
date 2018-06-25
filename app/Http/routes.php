<?php


Route::get('error',function()
{
       abort(404);
});

Route::get('/', function () {
    return view('general.logging');
});


Route::get('inicio', function(){
	return View::make('general.logging');	
});


Route::get('home',array('as'=>'admin','uses'=>'FrontController@admin'));

Route::get('Layouts',array('as'=>'Empresa.layout','uses'=>'EmpresaController@layout'));

Route::get('SectorIndustria',array('as'=>'Empresa.sectorindustria','uses'=>'EmpresaController@sectorIndustria'));
//dsd

Route::get('Empresa/industria/{id}','EmpresaController@getIndustria');

Route::get('Empresa/{num}/industria/{id}','EmpresaController@getIndustria_edit');

Route::resource('Usuario','UsuarioController');

Route::post('Userupdate','UsuarioController@update');

Route::post('UserupdatePsw','UsuarioController@cambiarPsw');

Route::get('Usuario/user_info/{id}','UsuarioController@edit');

Route::get('deleteUsuario/{id}',array('as'=>'Usuario.erase','uses'=>'UsuarioController@destroy'));

Route::resource('Login','LogController');

Route::resource('email','emailController');

Route::post('insertfactor','EmpresaController@insertarfactor');

Route::post('insertaspecto','EmpresaController@insertaraspecto');

Route::resource('Empresa','EmpresaController');

Route::get('gJuridicaedit/{id}','LegalController@editjuridica');

Route::get('gBoletinedit/{id}','LegalController@editboletin');

Route::get('mPermisos/{id}','InterfazController@getnamePermisos');

Route::get('AgregaPer','InterfazController@AsignaEmpresas');

Route::get('logout',array('as'=>'logout','uses'=>'LogController@logout'));

Route::get('exportaecxelm/{id}/{tipo}','EmpresaController@exportar');

Route::get('permisos1',array('as'=>'permission','uses'=>'InterfazController@permisosUsuarioEmpresa'));

Route::post('Plantilla/save','EmpresaController@save_layout');

Route::post('matriz/template','MatrizController@download_template');

Route::post('Juridica/update','LegalController@updatejuridica');

Route::post('Boletin/update','LegalController@updateboletin');

Route::get('downloadlayout/{file}','EmpresaController@download_layout');

Route::get('deletelayout/{file}','EmpresaController@delete_layout');

Route::get('gsectorf','EmpresaController@formSector');

Route::get('sectoredit/{id}','EmpresaController@SectorEdit');

Route::get('gindustriaf','EmpresaController@formIndustria');

Route::post('Sector',array('as'=>'Empresa.sector','uses'=>'EmpresaController@createSector'));

Route::any('editionS/{id}','Empresacontroller@updateSector');

Route::get('deleteSector/{id}',array('as'=>'Sector.delete','uses'=>'EmpresaController@deleteSector'));

Route::post('Industria',array('as'=>'Empresa.industria','uses'=>'EmpresaController@createIndustria'));

Route::get('industriaedit/{id}','EmpresaController@IndustriaEdit');

Route::any('editionI/{id}','Empresacontroller@updateIndustria');

Route::get('deleteIndustria/{id}','EmpresaController@deleteIndustria');

Route::get('gtablesec','EmpresaController@tabla_sectores');

Route::get('gtableindus','EmpresaController@tabla_industrias');

Route::get('Documentos',array('as'=>'documentos','uses'=>'DocumentosController@show_documentos'));

Route::post('Categoria/save','DocumentosController@create_categoria');

Route::get('gCategoriaedit/{id}','DocumentosController@editar_categoria');

Route::post('Categoria/update','DocumentosController@update_categoria');

Route::get('ingresarCategoria/{id}','DocumentosController@ver_categoria');

Route::get ('ingresarCategoria/downloaddocumento/{file}','DocumentosController@downloadfile');

Route::get ('ingresarCategoria/downloadanexo/{file}','DocumentosController@downloadfile2');

Route::post('ingresarCategoria/Documentos/save','DocumentosController@create_documento');

Route::get('ingresarCategoria/gDocumentoedit/{id}','DocumentosController@editar_documento');

Route::post('ingresarCategoria/Documentos/update','DocumentosController@update_documento');

Route::get('ingresarCategoria/filter_view/{id}/{year}/{ent}','DocumentosController@filter_view');

Route::get('ingresarCategoria/deletedoc/{id}','DocumentosController@delete_doc');

Route::get('Normas/filter_view/{id}','NormasController@filter_view');

//Version 2.0 software "ManagementController@index"




//A empezar de nuevo

require (__DIR__ . '/routes/version3.php');

Route::get('Fixing/fixmatriz','FixingupController@fixmatriz');