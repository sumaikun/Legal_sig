//esta función identifica cuando se inicia y finaliza una ejecución ajax para mostrar y ocultar el modal esperando
//-------------------------------------------------------------------------------------------------
var __USE_GENERIC_LOADING__ = true;
 
$(document).ajaxSend(function (r, s) {
if (__USE_GENERIC_LOADING__)
    
    on_preload();

    //setTimeout(function () {waitingDialog.hide();}, 3000);
    //$("#contentLoading").show();
});
 
$(document).ajaxStop(function (r, s) {
    if (__USE_GENERIC_LOADING__)
        off_preload();
        //$("#contentLoading").fadeOut("fast");
});
 
function invalidateGenericLoading() {
        __USE_GENERIC_LOADING__ = false;
}
//-------------------------------------------------------------------------------------------------


$(function () {
 	$('#preload').addClass("hide");
})

function on_preload(){
	$('#preload').removeClass("hide");
	$('#preload').removeClass("show");
	$('#preload').addClass("show");
}

function off_preload(){
	$('#preload').removeClass("hide");
	$('#preload').removeClass("show");
	$('#preload').addClass("hide");
}