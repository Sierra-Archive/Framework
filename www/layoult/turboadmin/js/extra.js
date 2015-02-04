




/******************************
*  Funcao: Funcoes de Manipulação de Link
*  Criador: Ricardo Rebello Sierra (2011-10-29)
********************************/
function Control_Menu_Superior(elemento){
	$('.lajax-mesup').removeClass("active submenu-active");
	elemento.addClass("active");
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
        var el = jQuery(this).parents(".widget").children(".widget-body");
        if (jQuery(this).hasClass("glyphicon-chevron-down")) {
            jQuery(this).removeClass("glyphicon-chevron-down").addClass("glyphicon-chevron-up");
            el.slideUp(200);
        } else {
            jQuery(this).removeClass("glyphicon-chevron-up").addClass("glyphicon-chevron-down");
            el.slideDown(200);
        }
    });
    jQuery('.widget .tools .glyphicon-remove').click(function () {
        jQuery(this).parents(".widget").parent().remove();
    });
}

