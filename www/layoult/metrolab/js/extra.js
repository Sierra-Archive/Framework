/******************************
*  Funcao: Funcoes de Manipulação de Link
*  Criador: Ricardo Rebello Sierra (2011-10-29)
********************************/
function Control_Menu_Superior(elemento){
	$('.menu_li_controle').removeClass("active");
	elemento.parent().addClass("active");
	return false;
}
function Control_Menu_SuperiorSub(elemento){
	$('.sub > li').removeClass("active");
	elemento.parent().addClass("active");
	return false;
}
function Control_Atualizacao(){
	return true;
}
// widget tools
function Control_Layoult_Botoes()
{
    jQuery('.widget .tools .glyphicon-chevron-down, .widget .tools .glyphicon-chevron-up').click(function () {
        var elemento    = jQuery(this);
            el          = elemento.parents(".widget").children(".widget-body");
        if (elemento.hasClass("glyphicon-chevron-down")) {
            elemento.removeClass("glyphicon-chevron-down").addClass("glyphicon-chevron-up");
            el.slideUp(200);
        } else {
            elemento.removeClass("glyphicon-chevron-up").addClass("glyphicon-chevron-down");
            el.slideDown(200);
        }
    });
    jQuery('.widget .tools .glyphicon-remove').click(function () {
        jQuery(this).parents(".widget").parent().remove();
    });
}

