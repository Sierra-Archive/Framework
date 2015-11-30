<?php
$configModule = function () {
    return Array(
        'Nome'                      =>  'biblioteca',
        'Descrição'                 =>  '',
        'System_Require'            =>  '3.1.0',
        'Version'                   =>  '3.1.1',
        'Dependencias'              =>  false,
    );
};
$configMenu = function () {
    return Array(
        'Biblioteca'=>Array(
            'Nome'                  => __('Biblioteca'),
            'Link'                  => 'biblioteca/Biblioteca/Bibliotecas',
            'Gravidade'             => 90,
            'Img'                   => '',
            'Icon'                  => 'folder-open',
            'Filhos'                => false,
        ),
    );
};
$config_Permissoes = function () {
    return Array(
        Array(
            'Nome'                  => __('Biblioteca - Listagem'),
            'Desc'                  => '',
            'Chave'                 => 'biblioteca_Biblioteca_Bibliotecas',
            'End'                   => 'biblioteca/Biblioteca/Bibliotecas', // Endereco da url de permissão
            'Modulo'                => 'biblioteca', // Modulo Referente
            'SubModulo'             => 'biblioteca',   // Submodulo Referente
            'Metodo'                => 'Bibliotecas',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => __('Biblioteca - Add'),
            'Desc'                  => '',
            'Chave'                 => 'biblioteca_Biblioteca_Bibliotecas_Add', // CHave unica nunca repete, chave primaria
            'End'                   => 'biblioteca/Biblioteca/Bibliotecas_Add', // Endereco da url de permissão
            'Modulo'                => 'biblioteca', // Modulo Referente
            'SubModulo'             => 'Biblioteca',   // Submodulo Referente
            'Metodo'                => 'Bibliotecas_Add,Bibliotecas_Add2',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => __('Biblioteca - Editar'),
            'Desc'                  => '',
            'Chave'                 => 'biblioteca_Biblioteca_Bibliotecas_Edit', // CHave unica nunca repete, chave primaria
            'End'                   => 'biblioteca/Biblioteca/Bibliotecas_Edit', // Endereco da url de permissão
            'Modulo'                => 'biblioteca', // Modulo Referente
            'SubModulo'             => 'Biblioteca',// Submodulo Referente
            'Metodo'                => 'Bibliotecas_Edit,Bibliotecas_Edit2',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => __('Biblioteca - Deletar'),
            'Desc'                  => '',
            'Chave'                 => 'biblioteca_Biblioteca_Bibliotecas_Del', // CHave unica nunca repete, chave primaria
            'End'                   => 'biblioteca/Biblioteca/Bibliotecas_Del', // Endereco da url de permissão
            'Modulo'                => 'biblioteca', // Modulo Referente
            'SubModulo'             => 'Biblioteca',   // Submodulo Referente
            'Metodo'                => 'Bibliotecas_Del',  // Metodos referentes separados por virgula
        ),
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
?>
