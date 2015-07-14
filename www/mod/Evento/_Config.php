<?php
$config_Modulo = function (){
    return Array(
        'Nome'                      =>  'Evento',
        'Descrição'                 =>  '',
        'System_Require'            =>  '3.1.0',
        'Version'                   =>  '3.1.1',
        'Dependencias'              =>  false,
    );
};
$config_Menu = function (){
    return Array(
        'Administrar' => Array(
            'Nome'                  => __('Administrar'),
            'Link'                  => '#',
            'Gravidade'             => 80,
            'Img'                   => '',
            'Icon'                  => 'building',
            'Filhos'                => Array('Eventos'=>Array(
                'Nome'                  => __('Eventos'),
                'Link'                  => 'Evento/Evento/Main',
                'Gravidade'             => 90,
                'Img'                   => '',
                'Icon'                  => 'building',
                'Filhos'                => false,
            )),
        ),
    );
};
$config_Permissoes = function (){
    return Array(
        Array(
            'Nome'                  => __('Eventos - Listagem'),
            'Desc'                  => '',
            'Chave'                 => 'Evento_Evento',
            'End'                   => 'Evento/Evento', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Evento', // Modulo Referente
            'SubModulo'             => 'Evento',   // Submodulo Referente
            'Metodo'                => '*',  // Metodos referentes separados por virgula // Endereco que deve conter a url para permitir acesso
        ),
        Array(
            'Nome'                  => __('Eventos - Add'),
            'Desc'                  => '',
            'Chave'                 => 'Evento_Evento_Eventos_Add', // CHave unica nunca repete, chave primaria
            'End'                   => 'Evento/Evento/Eventos_Add', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Evento', // Modulo Referente
            'SubModulo'             => 'Evento',   // Submodulo Referente
            'Metodo'                => 'Eventos_Add,Eventos_Add2',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => __('Eventos - Editar'),
            'Desc'                  => '',
            'Chave'                 => 'Evento_Evento_Eventos_Edit', // CHave unica nunca repete, chave primaria
            'End'                   => 'Evento/Evento/Eventos_Edit', // Endereco que deve conter a url para permitir acesso // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Evento', // Modulo Referente // Modulo Referente
            'SubModulo'             => 'Evento',   // Submodulo Referente   // Submodulo Referente
            'Metodo'                => 'Eventos_Edit,Eventos_Edit2',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => __('Eventos - Deletar'),
            'Desc'                  => '',
            'Chave'                 => 'Evento_Evento_Eventos_Del', // CHave unica nunca repete, chave primaria
            'End'                   => 'Evento/Evento/Eventos_Del', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Evento', // Modulo Referente
            'SubModulo'             => 'Evento',   // Submodulo Referente
            'Metodo'                => 'Eventos_Del',  // Metodos referentes separados por virgula
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
