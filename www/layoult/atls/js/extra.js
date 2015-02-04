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
	$('.menu_li_controle'/*+' > ul > li'*/).removeClass("active");
	elemento.parent().parent().parent().addClass("active");
	return false;
}
function Control_Atualizacao(){
	return true;
}
// widget tools
function Control_Layoult_Botoes()
{
}

