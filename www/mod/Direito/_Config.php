<?php
$configModule = function () {
    return Array(
        'Nome'                      =>  'Direito',
        'Descrição'                 =>  '',
        'System_Require'            =>  '3.1.0',
        'Version'                   =>  '0.2.1',
        'Dependencias'              =>  false,
    );
};
$configMenu = function () {
    return Array(
        'Relatório'=>Array(
            'Filhos'                => Array(__('Processos')=>Array(
                'Nome'                  => __('Processos'),
                'Link'                  => 'Direito/Relatorio/Main',
                'Gravidade'             => 70,
                'Img'                   => 'menusuperior/varas.png',
                'Icon'                  => '',
                'Filhos'                => false,
            ),),
        ),
    );
};
$config_Permissoes = function () {
    return Array(
        Array(
            'Nome'                  => __('Visualizar Relatórios'),
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
$configFunctional = function () {
    return Array();
};
/**
 * Configurações que podem ser Alteradas por Admin ou outros usuarios do Sistema (Parametros Opcionais: Mascara e Max
 * @return type
 * 
 * @author Ricardo Sierra <web@ricardosierra.com.br>
 */
$configPublic = function () {
    return Array(
        /*'{chave}'  => Array(
            'Nome'                  => 'Nome',
            'Desc'                  => __('Descricao'),
            'Chave'                 => '{chave}',
            'Valor'                 => 'valor_padrao'
        )*/
    );
};

