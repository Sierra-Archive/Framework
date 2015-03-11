<?php
function config_template(){
    return Array(
        'Buscar'           => '<li class="pull-right search-wrap">
                <form class="hidden-xs formajax"  id="form_Sistema_Busca" action="'.URL_PATH.'_Sistema/Principal/Busca">
                    <div class="input-append search-input-area">
                        <input type="text" id="busca" class="">
                        <button type="button" class="btn"><i class="glyphicon-search"></i> </button>
                    </div>
                </form>
            </li>',
        'links_js'           => Array(
            'jqueryui'              => true,
            'bootstrap'             => true,
        ),
        'links_css'          => Array(
            'jqueryui'              => true,
            'bootstrap'             => true,
        ),
        'plugins'           => Array(
            'abas_inverter'         => true,
            'abas_id'               => 'windows_tab_',
            'abas_ativar'           => function ($id){
                return '$(".nav-tabs > li").removeClass("active");
                $(".tab-pane").removeClass("active");
                $(".nav-tabs > li > a[href=\'#windows_tab_'.$id.'\']").parent().addClass("active");
                $("#windows_tab_'.$id.'").addClass("active")';
            },
        ),
        'camada_maior'      => '#blocomaior', //'.container > .row > .col-sm-8',
        'camada_menor'      => '#blocomenor', //'.container > .row > .col-sm-4',
        'camada_unica'      => '#blocounico', //'.container > .row > .col-sm-12'
        //'TEMA_JS_UNIFORM'   => 'NAO',
        'javascript'        => Array(
            'datatable_sdom'            => "<'container-fluid'<'col-sm-6'l><'col-sm-6'f>r>t<'container-fluid'<'col-sm-6'i><'col-sm-6'p>>",
            'datatable_sPaginationType' => 'bootstrap',
            'datatable_bJQueryUI'       => false,
            'datatable_bAutoWidth'      => true,
        )
    );
}
//Configuracoes_Template['menu_desactive']
?>
