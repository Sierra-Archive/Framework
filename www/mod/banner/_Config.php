<?php
$config_Modulo = function (){
    return Array(
        'Nome'                      =>  'banner',
        'Descrição'                 =>  '',
        'System_Require'            =>  '3.0.0',
        'Version'                   =>  '3.0.1',
        'Dependencias'              =>  false,
    );
};
$config_Menu = function (){
    return Array(
        'Administrar'=>Array(
            'Filhos'                => Array('Banners'=>Array(
                'Nome'                  => 'Banners',
                'Link'                  => 'banner/Admin/Main/',
                'Gravidade'             => 3,
                'Img'                   => 'turboadmin/m-dashboard.png',
                'Icon'                  => 'picture',
                'Filhos'                => false,
            ),),
        ),
    );
};
$config_Permissoes = function (){
    return Array(
        Array(
            'Nome'                  => 'Banners - Listagem',
            'Desc'                  => '',
            'Chave'                 => 'banner_Admin',
            'End'                   => 'banner/Admin', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'banner', // Modulo Referente
            'SubModulo'             => 'Admin',   // Submodulo Referente
            'Metodo'                => '*',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => 'Banners - Add',
            'Desc'                  => '',
            'Chave'                 => 'banner_Admin_Banners_Add', // CHave unica nunca repete, chave primaria
            'End'                   => 'banner/Admin/banners_Add', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'banner', // Modulo Referente
            'SubModulo'             => 'Admin',   // Submodulo Referente
            'Metodo'                => 'banners_Add,banners_Add2',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => 'Banners - Editar',
            'Desc'                  => '',
            'Chave'                 => 'banner_Admin_Banners_Edit', // CHave unica nunca repete, chave primaria
            'End'                   => 'banner/Admin/banners_Edit', // Endereco que deve conter a url para permitir acesso // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'banner', // Modulo Referente // Modulo Referente
            'SubModulo'             => 'Admin',   // Submodulo Referente   // Submodulo Referente
            'Metodo'                => 'banners_Edit,banners_Edit2',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => 'Banners - Deletar',
            'Desc'                  => '',
            'Chave'                 => 'banner_Admin_Banners_Del', // CHave unica nunca repete, chave primaria
            'End'                   => 'banner/Admin/Banners_Del', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'banner', // Modulo Referente
            'SubModulo'             => 'Admin',   // Submodulo Referente
            'Metodo'                => 'Banners_Del',  // Metodos referentes separados por virgula
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
