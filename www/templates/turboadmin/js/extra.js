




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
    jQuery('.widget .tools .fa fa-chevron-down, .widget .tools .fa fa-chevron-up').click(function () {
        var el = jQuery(this).parents(".widget").children(".widget-body");
        if (jQuery(this).hasClass("fa fa-chevron-down")) {
            jQuery(this).removeClass("fa fa-chevron-down").addClass("fa fa-chevron-up");
            el.slideUp(200);
        } else {
            jQuery(this).removeClass("fa fa-chevron-up").addClass("fa fa-chevron-down");
            el.slideDown(200);
        }
    });
    jQuery('.widget .tools .fa fa-remove').click(function () {
        jQuery(this).parents(".widget").parent().remove();
    });
}

