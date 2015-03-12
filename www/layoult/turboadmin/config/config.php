<?php
function config_template(){
    return Array(
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
        'camada_maior'      => '#main-content-left',
        'camada_menor'      => '#loadcoldir',
        'camada_unica'      => false,
        //'TEMA_JS_UNIFORM'   => 'SIM',
        'javascript'        => Array(
            'datatable_sdom'            => 'padrao',
            'datatable_sPaginationType' => 'full_numbers',
            'datatable_bJQueryUI'       => false,
            'datatable_bAutoWidth'      => true,
        )
    );
}
//Configuracoes_Template['menu_desactive']
?>
