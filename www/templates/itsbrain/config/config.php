<?php
function itsbrain_config() {
    return Array(
        'plugins'           => Array(
            'abas_inverter'         => false,
            'abas_id'               => 'tabs-',
            'abas_ativar'           => function ($id) {
                $id = (int) $id;
                return '$( ".tabs" ).tabs( "option", "active", '.($id-1).' );';
            },
        ),
        'camada_maior'      => '#blocomaior', //'.container > .row > .col-sm-8',
        'camada_menor'      => '#blocomenor', //'.container > .row > .col-sm-4',
        'camada_unica'      => '#blocounico', //'.container > .row > .col-sm-12'
        //'TEMA_JS_UNIFORM'   => 'NAO',
        'javascript'        => Array(
            'datatable_sdom'            => "<'datatable-header'fl>t<'datatable-footer'ip>",
            'datatable_sPaginationType' => 'full_numbers',
            'datatable_bJQueryUI'       => false,
            'datatable_bAutoWidth'      => false,
        )
    );
}
//Configuracoes_Template['menu_desactive']
?>
