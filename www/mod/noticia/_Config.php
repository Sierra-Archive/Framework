<?php
$config_Modulo = function (){
    return Array(
        'Nome'                      =>  'noticia',
        'Descrição'                 =>  '',
        'System_Require'            =>  '3.1.0',
        'Version'                   =>  '3.1.1',
        'Dependencias'              =>  false,
    );
};
$config_Menu = function (){
    return Array(
        /*'Noticias'=>Array(
            'Nome'                  => __('Noticias'),
            'Link'                  => 'noticia/Listar/Main',
            'Gravidade'             => 75,
            'Img'                   => 'turboadmin/m-dashboard.png',
            'Icon'                  => 'rss',
            'Filhos'                => false,
        ),*/'Administrar'=>Array(
            'Filhos'                => Array('Noticias'=>Array(
                'Nome'                  => __('Noticias'),
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
            'Nome'                  => __('Noticias - Administrar Noticias'),
            'Desc'                  => '',
            'Chave'                 => 'noticia_Admin_Noticias',
            'End'                   => 'noticia/Admin/Noticias', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'noticia', // Modulo Referente
            'SubModulo'             => 'Admin',   // Submodulo Referente
            'Metodo'                => '*',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => __('Noticias - Add Noticias'),
            'Desc'                  => '',
            'Chave'                 => 'noticia_Admin_Noticias_Add', // CHave unica nunca repete, chave primaria
            'End'                   => 'noticia/Admin/Noticias_Add', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'noticia', // Modulo Referente
            'SubModulo'             => 'Admin',   // Submodulo Referente
            'Metodo'                => 'Noticias_Add,Noticias_Add2',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => __('Noticias - Editar Noticias'),
            'Desc'                  => '',
            'Chave'                 => 'noticia_Admin_Noticias_Edit', // CHave unica nunca repete, chave primaria
            'End'                   => 'noticia/Admin/Noticias_Edit', // Endereco que deve conter a url para permitir acesso // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'noticia', // Modulo Referente // Modulo Referente
            'SubModulo'             => 'Admin',   // Submodulo Referente   // Submodulo Referente
            'Metodo'                => 'Noticias_Edit,Noticias_Edit2',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => __('Noticias - Deletar Noticias'),
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
    return Array(
        'noticia_Categoria'  => Array(
            'Nome'                  => __('Se possui categoria em noticias'),
            'Desc'                  => __('Se possui categoria em noticias'),
            'chave'                 => 'noticia_Categoria',
            'Valor'                 => true,
        )
    );
};
/**
 * Configurações que podem ser Alteradas por Admin ou outros usuarios do Sistema (Parametros Opcionais: Mascara e Max
 * @return type
 * 
 * @author Ricardo Sierra <web@ricardosierra.com.br>
 */
$config_Publico = function (){
    return Array(
        /*'{chave}'  => Array(
            'Nome'                  => 'Nome',
            'Desc'                  => __('Descricao'),
            'chave'                 => '{chave}',
            'Valor'                 => 'valor_padrao'
        )*/
    );
};
?>
