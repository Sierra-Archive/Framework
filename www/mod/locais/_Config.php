<?php
$config_Modulo = function (){
    return Array(
        'Nome'                      =>  'locais',
        'Descrição'                 =>  '',
        'System_Require'            =>  '3.1.0',
        'Version'                   =>  '3.1.1',
        'Dependencias'              =>  false,
    );
};
$config_Menu = function (){
    return Array(
        'Administrar' => Array(
            'Filhos'                => Array('Locais' =>Array(
                'Nome'                  => 'Locais',
                'Link'                  => 'locais/locais/Locais',
                'Gravidade'             => 10,
                'Img'                   => 'turboadmin/m-dashboard.png',
                'Icon'                  => 'map-marker',
                'Permissao_Func'        => Array(// Permissoes NEcessarias
                    'locais_Acesso' => true
                ),
                'Filhos'                => false,
            ),),
        ),
    );
};
$config_Permissoes = function (){
    return Array(
        Array(
            'Nome'                  => 'Locais - Listagem',
            'Desc'                  => '',
            'Chave'                 => 'locais_locais_Locais',
            'End'                   => 'locais/locais/Locais', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'locais', // Modulo Referente
            'SubModulo'             => 'locais',   // Submodulo Referente
            'Metodo'                => 'Locais',  // Metodos referentes separados por virgula
            'Permissao_Func'        => Array(// Permissoes NEcessarias
                'locais_Acesso' => true
            ),
        ),
        Array(
            'Nome'                  => 'Locais - Add',
            'Desc'                  => '',
            'Chave'                 => 'locais_locais_Locais_Add', // CHave unica nunca repete, chave primaria
            'End'                   => 'locais/locais/Locais_Add', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'locais', // Modulo Referente
            'SubModulo'             => 'locais',   // Submodulo Referente
            'Metodo'                => 'Locais_Add,Locais_Add2',  // Metodos referentes separados por virgula
            'Permissao_Func'        => Array(// Permissoes NEcessarias
                'locais_Acesso' => true
            ),
        ),
        Array(
            'Nome'                  => 'Locais - Editar',
            'Desc'                  => '',
            'Chave'                 => 'locais_locais_Locais_Edit', // CHave unica nunca repete, chave primaria
            'End'                   => 'locais/locais/Locais_Edit', // Endereco que deve conter a url para permitir acesso // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'locais', // Modulo Referente // Modulo Referente
            'SubModulo'             => 'locais',   // Submodulo Referente   // Submodulo Referente
            'Metodo'                => 'Locais_Edit,Locais_Edit2',  // Metodos referentes separados por virgula
            'Permissao_Func'        => Array(// Permissoes NEcessarias
                'locais_Acesso' => true
            ),
        ),
        Array(
            'Nome'                  => 'Locais - Deletar',
            'Desc'                  => '',
            'Chave'                 => 'locais_locais_Locais_Del', // CHave unica nunca repete, chave primaria
            'End'                   => 'locais/locais/Locais_Del', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'locais', // Modulo Referente
            'SubModulo'             => 'locais',   // Submodulo Referente
            'Metodo'                => 'Locais_Del',  // Metodos referentes separados por virgula
            'Permissao_Func'        => Array(// Permissoes NEcessarias
                'locais_Acesso' => true
            ),
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
        'locais_Acesso'  => Array(
            'Nome'                  => 'Locais -> Se usuario tem acesso',
            'Desc'                  => 'Se usuario tem acesso aos locais',
            'chave'                 => 'locais_Acesso',
            'Valor'                 => true,
        ),
    );
};
?>
