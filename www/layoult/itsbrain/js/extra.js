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
    $( ".tabs" ).tabs();
    $( "#blocounico > .widget" ).first().addClass( "first" );
    return true;
}
// widget tools
function Control_Layoult_Botoes()
{
    jQuery('.widget .tools .fa-chevron-down, .widget .tools .fa-chevron-up').click(function () {
        var el = jQuery(this).parents(".widget").children(".widget-body");
        if (jQuery(this).hasClass("fa-chevron-down")) {
            jQuery(this).removeClass("fa-chevron-down").addClass("fa-chevron-up");
            el.slideUp(200);
        } else {
            jQuery(this).removeClass("fa-chevron-up").addClass("fa-chevron-down");
            el.slideDown(200);
        }
    });
    jQuery('.widget .tools .fa-remove').click(function () {
        jQuery(this).parents(".widget").parent().remove();
    });
}


$(function() {
	//===== Information boxes =====//
	$(".hideit").click(function() {
		$(this).fadeTo(200, 0.00, function(){ //fade
			$(this).slideUp(300, function() { //slide up
				$(this).remove(); //then remove from the DOM
			});
		});
	});
	//=====Resizable table columns =====//
	var onSampleResized = function(e){
		var columns = $(e.currentTarget).find("th");
		var msg = "columns widths: ";
		columns.each(function(){ msg += $(this).width() + "px; "; })
	};
	$(".resize").colResizable({
            liveDrag:true, 
            gripInnerHtml:"<div class='grip'></div>", 
            draggingClass:"dragging", 
            onResize:onSampleResized
        });
	//===== Left navigation submenu animation =====//	
	$("ul.sub li a").hover(function() {
            $(this).stop().animate({ color: "#3a6fa5" }, 400);
	},function() {
            $(this).stop().animate({ color: "#494949" }, 400);
	});
	//===== Autofocus =====//
	$('.autoF').focus();
	//===== Tabs =====//
	$( ".tabs" ).tabs();
	var tabs = $( ".tabs-sortable" ).tabs();
        tabs.find( ".ui-tabs-nav" ).sortable({
            axis: "x",
            stop: function() {
            tabs.tabs( "refresh" );
            }
        });

	//===== User nav dropdown =====//		
	$('.dd').click(function () {
            $('ul.menu_body').slideToggle(200);
	});
	$(document).bind('click', function(e) {
	var $clicked = $(e.target);
	if (! $clicked.parents().hasClass("dd"))
            $("ul.menu_body").slideUp(200);
	});
	$('.acts').click(function () {
            $('ul.actsBody').slideToggle(100);
	});
	//===== Collapsible elements management =====//
	$('.exp').collapsible({
            defaultOpen: 'current',
            cookieName: 'navAct',
            cssOpen: 'active corner',
            cssClose: 'inactive',
            speed: 300
	});
	$('.opened').collapsible({
            defaultOpen: 'opened,toggleOpened',
            cssOpen: 'inactive',
            cssClose: 'normal',
            speed: 200
	});
	$('.closed').collapsible({
		defaultOpen: '',
		cssOpen: 'inactive',
		cssClose: 'normal',
		speed: 200
	});	
});
