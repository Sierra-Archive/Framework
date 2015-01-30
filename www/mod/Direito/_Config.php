<?php
$config_Modulo = function (){
    return Array(
        'Nome'                      =>  'Direito',
        'Descrição'                 =>  '',
        'System_Require'            =>  '2.21.1',
        'Version'                   =>  '0.2.1',
        'Dependencias'              =>  false,
    );
};
$config_Menu = function (){
    return Array(
        'Relatório'=>Array(
            'Filhos'                => Array('Processos'=>Array(
                'Nome'                  => 'Processos',
                'Link'                  => 'Direito/Relatorio/Main',
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
            'Chave'                 => 'Direito_Relatorio',
            'End'                   => 'Direito/Relatorio',
            'Modulo'                => 'Direito', // Modulo Referente
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
