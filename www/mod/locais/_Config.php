<?php
$configModule = function () {
    return Array(
        'Nome'                      =>  'locais',
        'Descrição'                 =>  '',
        'System_Require'            =>  '3.1.0',
        'Version'                   =>  '3.1.1',
        'Dependencias'              =>  false,
    );
};
$configMenu = function () {
    return Array(
        'Administrar' => Array(
            'Filhos'                => Array(__('Locais') =>Array(
                'Nome'                  => __('Locais'),
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
$config_Permissoes = function () {
    return Array(
        Array(
            'Nome'                  => __('Locais - Listagem'),
            'Desc'                  => '',
            'Chave'                 => 'locais_locais_Locais',
            'End'                   => 'locais/locais/Locais', // Endereco da url de permissão
            'Modulo'                => 'locais', // Modulo Referente
            'SubModulo'             => 'locais',   // Submodulo Referente
            'Metodo'                => 'Locais',  // Metodos referentes separados por virgula
            'Permissao_Func'        => Array(// Permissoes NEcessarias
                'locais_Acesso' => true
            ),
        ),
        Array(
            'Nome'                  => __('Locais - Add'),
            'Desc'                  => '',
            'Chave'                 => 'locais_locais_Locais_Add', // CHave unica nunca repete, chave primaria
            'End'                   => 'locais/locais/Locais_Add', // Endereco da url de permissão
            'Modulo'                => 'locais', // Modulo Referente
            'SubModulo'             => 'locais',   // Submodulo Referente
            'Metodo'                => 'Locais_Add,Locais_Add2',  // Metodos referentes separados por virgula
            'Permissao_Func'        => Array(// Permissoes NEcessarias
                'locais_Acesso' => true
            ),
        ),
        Array(
            'Nome'                  => __('Locais - Editar'),
            'Desc'                  => '',
            'Chave'                 => 'locais_locais_Locais_Edit', // CHave unica nunca repete, chave primaria
            'End'                   => 'locais/locais/Locais_Edit', // Endereco da url de permissão
            'Modulo'                => 'locais', // Modulo Referente
            'SubModulo'             => 'locais',// Submodulo Referente
            'Metodo'                => 'Locais_Edit,Locais_Edit2',  // Metodos referentes separados por virgula
            'Permissao_Func'        => Array(// Permissoes NEcessarias
                'locais_Acesso' => true
            ),
        ),
        Array(
            'Nome'                  => __('Locais - Deletar'),
            'Desc'                  => '',
            'Chave'                 => 'locais_locais_Locais_Del', // CHave unica nunca repete, chave primaria
            'End'                   => 'locais/locais/Locais_Del', // Endereco da url de permissão
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
$configFunctional = function () {
    return Array(
        'locais_Acesso'  => Array(
            'Nome'                  => 'Locais -> Se usuario tem acesso',
            'Desc'                  => __('Se usuario tem acesso aos locais'),
            'chave'                 => 'locais_Acesso',
            'Valor'                 => true,
        ),
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
