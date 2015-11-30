<?php
$configModule = function () {
    return Array(
        'Nome'                      =>  'noticia',
        'Descrição'                 =>  '',
        'System_Require'            =>  '3.1.0',
        'Version'                   =>  '3.1.1',
        'Dependencias'              =>  false,
    );
};
$configMenu = function () {
    return Array(
        'Administrar'=>Array(
            'Filhos'                => Array(__('Noticias')=>Array(
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
$config_Permissoes = function () {
    return Array(
        Array(
            'Nome'                  => __('Noticias - Administrar Noticias'),
            'Desc'                  => '',
            'Chave'                 => 'noticia_Admin_Noticias',
            'End'                   => 'noticia/Admin/Noticias', // Endereco da url de permissão
            'Modulo'                => 'noticia', // Modulo Referente
            'SubModulo'             => 'Admin',   // Submodulo Referente
            'Metodo'                => '*',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => __('Noticias - Add Noticias'),
            'Desc'                  => '',
            'Chave'                 => 'noticia_Admin_Noticias_Add', // CHave unica nunca repete, chave primaria
            'End'                   => 'noticia/Admin/Noticias_Add', // Endereco da url de permissão
            'Modulo'                => 'noticia', // Modulo Referente
            'SubModulo'             => 'Admin',   // Submodulo Referente
            'Metodo'                => 'Noticias_Add,Noticias_Add2',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => __('Noticias - Editar Noticias'),
            'Desc'                  => '',
            'Chave'                 => 'noticia_Admin_Noticias_Edit', // CHave unica nunca repete, chave primaria
            'End'                   => 'noticia/Admin/Noticias_Edit', // Endereco da url de permissão
            'Modulo'                => 'noticia', // Modulo Referente
            'SubModulo'             => 'Admin',// Submodulo Referente
            'Metodo'                => 'Noticias_Edit,Noticias_Edit2',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => __('Noticias - Deletar Noticias'),
            'Desc'                  => '',
            'Chave'                 => 'noticia_Admin_Noticias_Del', // CHave unica nunca repete, chave primaria
            'End'                   => 'noticia/Admin/Noticias_Del', // Endereco da url de permissão
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
$configFunctional = function () {
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
