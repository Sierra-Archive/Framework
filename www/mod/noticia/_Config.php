<?php
$config_Modulo = function (){
    return Array(
        'Nome'                      =>  'noticia',
        'Descrição'                 =>  '',
        'System_Require'            =>  '2.21.1',
        'Version'                   =>  '0.0.1',
        'Dependencias'              =>  false,
    );
};
$config_Menu = function (){
    return Array(
        /*'Noticias'=>Array(
            'Nome'                  => 'Noticias',
            'Link'                  => 'noticia/Listar/Main',
            'Gravidade'             => 75,
            'Img'                   => 'turboadmin/m-dashboard.png',
            'Icon'                  => 'rss',
            'Filhos'                => false,
        ),*/'Administrar'=>Array(
            'Filhos'                => Array('Noticias'=>Array(
                'Nome'                  => 'Noticias',
                'Link'                  => 'noticia/Admin/Noticias',
                'Gravidade'             => 75,
                'Img'                   => 'turboadmin/m-dashboard.png',
                'Icon'                  => 'rss',
                'Filhos'                => false,
            ),),
        ),
    );
};
$config_Permissoes = function (){
    return Array(
        Array(
            'Nome'                  => 'Administrar Noticias',
            'Desc'                  => '',
            'Chave'                 => 'noticia_Admin_Noticias',
            'End'                   => 'noticia/Admin/Noticias', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'noticia', // Modulo Referente
            'SubModulo'             => 'Admin',   // Submodulo Referente
            'Metodo'                => '*',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => 'Add Noticias',
            'Desc'                  => '',
            'Chave'                 => 'noticia_Admin_Noticias_Add', // CHave unica nunca repete, chave primaria
            'End'                   => 'noticia/Admin/Noticias_Add', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'noticia', // Modulo Referente
            'SubModulo'             => 'Admin',   // Submodulo Referente
            'Metodo'                => 'Noticias_Add,Noticias_Add2',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => 'Editar Noticias',
            'Desc'                  => '',
            'Chave'                 => 'noticia_Admin_Edit', // CHave unica nunca repete, chave primaria
            'End'                   => 'noticia/Admin/Noticias_Edit', // Endereco que deve conter a url para permitir acesso // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'noticia', // Modulo Referente // Modulo Referente
            'SubModulo'             => 'Admin',   // Submodulo Referente   // Submodulo Referente
            'Metodo'                => 'Noticias_Edit,Noticias_Edit2',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => 'Deletar Noticias',
            'Desc'                  => '',
            'Chave'                 => 'noticia_Admin_Noticias_Del', // CHave unica nunca repete, chave primaria
            'End'                   => 'noticia/Admin/Noticias_Del', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'noticia', // Modulo Referente
            'SubModulo'             => 'Admin',   // Submodulo Referente
            'Metodo'                => 'Noticias_Del',  // Metodos referentes separados por virgula
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
