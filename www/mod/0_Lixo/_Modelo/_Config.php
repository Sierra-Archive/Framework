<?php
$config_Modulo = function (){
    return Array(
        'Nome'                      =>  'comercio_venda',
        'Descrição'                 =>  '',
        'System_Require'            =>  '3.1.0',
        'Version'                   =>  '0.2.1',
        'Dependencias'              =>  false,
    );
};
$config_Menu = function (){
    return Array(
        'Relatório'=>Array(
            'Filhos'                => Array('Processos'=>Array(
                'Nome'                  => 'Processos',
                'Link'                  => 'comercio_venda/Relatorio/Main',
                'Gravidade'             => 70,
                'Img'                   => 'menusuperior/varas.png',
                'Icon'                  => '',
                'Filhos'                => false,
            ),),
        ),
    );
};
$config_Permissoes = function (){
    return Array(
        Array(
            'Nome'                  => 'Visualizar Relatórios',
            'Desc'                  => '',
            'Chave'                 => 'comercio_venda_Relatorio',
            'End'                   => 'comercio_venda/Relatorio',
            'Modulo'                => 'comercio_venda', // Modulo Referente
            'SubModulo'             => 'Relatorio',   // Submodulo Referente
            'Metodo'                => '*',  // Metodos referentes separados por virgula
        )
    );
};
/**
 * Serve Para Personalizar o Modulo de Acordo com o gosto de cada "Servidor"
 * @return type
 * 
 * @author Ricardo Sierra <web@ricardosierra.com.br>
 */
$config_Funcional = function (){
    return Array();
};
?>
