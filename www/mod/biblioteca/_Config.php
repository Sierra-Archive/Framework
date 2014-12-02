<?php
$config_Modulo = function (){
    return Array(
        'Nome'                      =>  'biblioteca',
        'Descrição'                 =>  '',
        'System_Require'            =>  '2.21.1',
        'Version'                   =>  '0.0.1',
        'Dependencias'              =>  false,
    );
};
$config_Menu = function (){
    return Array(
        'Biblioteca'=>Array(
            'Nome'                  => 'Biblioteca',
            'Link'                  => 'biblioteca/Biblioteca/Bibliotecas',
            'Gravidade'             => 90,
            'Img'                   => '',
            'Icon'                  => 'folder-open',
            'Filhos'                => false,
        ),
    );
};
$config_Permissoes = function (){
    return Array(
        Array(
            'Nome'                  => 'Biblioteca - Listagem',
            'Desc'                  => '',
            'Chave'                 => 'biblioteca_Biblioteca_Bibliotecas',
            'End'                   => 'biblioteca/Biblioteca/Bibliotecas', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'biblioteca', // Modulo Referente
            'SubModulo'             => 'biblioteca',   // Submodulo Referente
            'Metodo'                => 'Bibliotecas',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => 'Biblioteca - Add',
            'Desc'                  => '',
            'Chave'                 => 'biblioteca_Biblioteca_Bibliotecas_Add', // CHave unica nunca repete, chave primaria
            'End'                   => 'biblioteca/Biblioteca/Bibliotecas_Add', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'biblioteca', // Modulo Referente
            'SubModulo'             => 'Biblioteca',   // Submodulo Referente
            'Metodo'                => 'Bibliotecas_Add,Bibliotecas_Add2',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => 'Biblioteca - Editar',
            'Desc'                  => '',
            'Chave'                 => 'biblioteca_Biblioteca_Bibliotecas_Edit', // CHave unica nunca repete, chave primaria
            'End'                   => 'biblioteca/Biblioteca/Bibliotecas_Edit', // Endereco que deve conter a url para permitir acesso // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'biblioteca', // Modulo Referente // Modulo Referente
            'SubModulo'             => 'Biblioteca',   // Submodulo Referente   // Submodulo Referente
            'Metodo'                => 'Bibliotecas_Edit,Bibliotecas_Edit2',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => 'Biblioteca - Deletar',
            'Desc'                  => '',
            'Chave'                 => 'biblioteca_Biblioteca_Bibliotecas_Del', // CHave unica nunca repete, chave primaria
            'End'                   => 'biblioteca/Biblioteca/Bibliotecas_Del', // Endereco que deve conter a url para permitir acesso
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
$config_Funcional = function (){
    return Array();
};
?>
