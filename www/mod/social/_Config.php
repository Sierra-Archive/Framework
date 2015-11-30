<?php
$configModule = function () {
    return Array(
        'Nome'                      =>  'social',
        'Descrição'                 =>  '',
        'System_Require'            =>  '3.1.0',
        'Version'                   =>  '3.1.1',
        'Dependencias'              =>  false,
    );
};
$configMenu = function () {
    return Array(
        'Social'=>Array(
            'Nome'                  => __('Social'),
            'Link'                  => '#',
            'Gravidade'             => 80,
            'Img'                   => 'turboadmin/m-dashboard.png',
            'Icon'                  => 'male',
            'Filhos'                => Array(__('Pessoas')=>Array(
                'Nome'                  => __('Pessoas'),
                'Link'                  => 'social/Persona/Personas',
                'Gravidade'             => 9,
                'Img'                   => 'turboadmin/m-users.png',
                'Icon'                  => 'male',
                'Filhos'                => false,
            ),'Ações'=>Array(
                'Nome'                  => __('Ações'),
                'Link'                  => 'social/Acao/Acao',
                'Gravidade'             => 9,
                'Img'                   => 'turboadmin/m-users.png',
                'Icon'                  => 'eye-close',
                'Filhos'                => false,
            ),'Midias'=>Array(
                'Nome'                  => __('Midias'),
                'Link'                  => 'social/Midia/Midias',
                'Gravidade'             => 9,
                'Img'                   => 'turboadmin/m-users.png',
                'Icon'                  => 'camera',
                'Filhos'                => false,
            ) 
        ),
        'Administrar'=>Array(
            'Caracteristicas'=>Array(
                'Nome'                  => __('Caracteristicas'),
                'Link'                  => 'social/Caracteristica/Caracteristicas',
                'Gravidade'             => 9,
                'Img'                   => 'turboadmin/m-users.png',
                'Icon'                  => 'sunglasses',
                'Filhos'                => false,
            ),
            'Tarefas'=>Array(
                'Nome'                  => __('Tarefas'),
                'Link'                  => 'social/Tarefa/Tarefas',
                'Gravidade'             => 9,
                'Img'                   => 'turboadmin/m-users.png',
                'Icon'                  => 'wrench',
                'Filhos'                => false,
            ),'Atributos'=>Array(
                'Nome'                  => __('Atributos'),
                'Link'                  => 'social/Atributo/Atributos',
                'Gravidade'             => 9,
                'Img'                   => 'turboadmin/m-users.png',
                'Icon'                  => 'briefcase',
                'Filhos'                => false,
            ),'Gosto'=>Array(
                'Nome'                  => __('Gostos'),
                'Link'                  => 'social/Gosto/Gostos',
                'Gravidade'             => 9,
                'Img'                   => 'turboadmin/m-users.png',
                'Icon'                  => 'heart-empty',
                'Filhos'                => false,
            ),),
        ),
    );
};
$config_Permissoes = function () {
    return Array(
        Array(
            'Nome'                  => __('Social (Pessoas) - Listagem'),
            'Desc'                  => '',
            'Chave'                 => 'social_Persona_Personas',
            'End'                   => 'social/Persona/Personas', // Endereco da url de permissão
            'Modulo'                => 'social', // Modulo Referente
            'SubModulo'             => 'Persona',   // Submodulo Referente
            'Metodo'                => 'Personas',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => __('Social (Pessoas) - Add'),
            'Desc'                  => '',
            'Chave'                 => 'social_Persona_Personas_Add', // CHave unica nunca repete, chave primaria
            'End'                   => 'social/Persona/Personas_Add', // Endereco da url de permissão
            'Modulo'                => 'social', // Modulo Referente
            'SubModulo'             => 'Persona',   // Submodulo Referente
            'Metodo'                => 'Personas_Add,Personas_Add2',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => __('Social (Pessoas) - Editar'),
            'Desc'                  => '',
            'Chave'                 => 'social_Persona_Personas_Edit', // CHave unica nunca repete, chave primaria
            'End'                   => 'social/Persona/Personas_Edit', // Endereco da url de permissão
            'Modulo'                => 'social', // Modulo Referente
            'SubModulo'             => 'Persona',// Submodulo Referente
            'Metodo'                => 'Personas_Edit,Personas_Edit2',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => __('Social (Pessoas) - Deletar'),
            'Desc'                  => '',
            'Chave'                 => 'social_Persona_Personas_Del', // CHave unica nunca repete, chave primaria
            'End'                   => 'social/Persona/Personas_Del', // Endereco da url de permissão
            'Modulo'                => 'social', // Modulo Referente
            'SubModulo'             => 'Persona',   // Submodulo Referente
            'Metodo'                => 'Personas_Del',  // Metodos referentes separados por virgula
        ),
        
        Array(
            'Nome'                  => __('Social (Caracteristicas) - Administrar'),
            'Desc'                  => '',
            'Chave'                 => 'social_Caracteristica_Caracteristicas',
            'End'                   => 'social/Caracteristica/Caracteristicas', // Endereco da url de permissão
            'Modulo'                => 'social', // Modulo Referente
            'SubModulo'             => 'Caracteristica',   // Submodulo Referente
            'Metodo'                => 'Caracteristicas',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => __('Social (Caracteristicas) - Add'),
            'Desc'                  => '',
            'Chave'                 => 'social_Caracteristica_Caracteristicas_Add', // CHave unica nunca repete, chave primaria
            'End'                   => 'social/Caracteristica/Caracteristicas_Add', // Endereco da url de permissão
            'Modulo'                => 'social', // Modulo Referente
            'SubModulo'             => 'Caracteristica',   // Submodulo Referente
            'Metodo'                => 'Caracteristicas_Add,Caracteristicas_Add2',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => __('Social (Caracteristicas) - Editar'),
            'Desc'                  => '',
            'Chave'                 => 'social_Caracteristica_Caracteristicas_Edit', // CHave unica nunca repete, chave primaria
            'End'                   => 'social/Caracteristica/Caracteristicas_Edit', // Endereco da url de permissão
            'Modulo'                => 'social', // Modulo Referente
            'SubModulo'             => 'Caracteristica',// Submodulo Referente
            'Metodo'                => 'Caracteristicas_Edit,Caracteristicas_Edit2',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => __('Social (Caracteristicas) - Deletar'),
            'Desc'                  => '',
            'Chave'                 => 'social_Caracteristica_Caracteristicas_Del', // CHave unica nunca repete, chave primaria
            'End'                   => 'social/Caracteristica/Caracteristicas_Del', // Endereco da url de permissão
            'Modulo'                => 'social', // Modulo Referente
            'SubModulo'             => 'Caracteristica',   // Submodulo Referente
            'Metodo'                => 'Caracteristicas_Del',  // Metodos referentes separados por virgula
        ),
        
        Array(
            'Nome'                  => __('Social (Ações) - Administrar'),
            'Desc'                  => '',
            'Chave'                 => 'social_Acao_Acao',
            'End'                   => 'social/Acao/Acao', // Endereco da url de permissão
            'Modulo'                => 'social', // Modulo Referente
            'SubModulo'             => 'Acao',   // Submodulo Referente
            'Metodo'                => 'Acao',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => __('Social (Ações) - Add'),
            'Desc'                  => '',
            'Chave'                 => 'social_Acao_Acoes_Add', // CHave unica nunca repete, chave primaria
            'End'                   => 'social/Acao/Acoes_Add', // Endereco da url de permissão
            'Modulo'                => 'social', // Modulo Referente
            'SubModulo'             => 'Acao',   // Submodulo Referente
            'Metodo'                => 'Acoes_Add,Acoes_Add2',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => __('Social (Ações) - Editar'),
            'Desc'                  => '',
            'Chave'                 => 'social_Acao_Acoes_Edit', // CHave unica nunca repete, chave primaria
            'End'                   => 'social/Acao/Acoes_Edit', // Endereco da url de permissão
            'Modulo'                => 'social', // Modulo Referente
            'SubModulo'             => 'PAcao',// Submodulo Referente
            'Metodo'                => 'Acoes_Edit,Acoes_Edit2',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => __('Social (Ações) - Deletar'),
            'Desc'                  => '',
            'Chave'                 => 'social_Acao_Acoes_Del', // CHave unica nunca repete, chave primaria
            'End'                   => 'social/Acao/Acoes_Del', // Endereco da url de permissão
            'Modulo'                => 'social', // Modulo Referente
            'SubModulo'             => 'Acao',   // Submodulo Referente
            'Metodo'                => 'Acoes_Del',  // Metodos referentes separados por virgula
        ),
        
        Array(
            'Nome'                  => __('Social (Midias) - Administrar'),
            'Desc'                  => '',
            'Chave'                 => 'social_Midia_Midias',
            'End'                   => 'social/Midia/Midias', // Endereco da url de permissão
            'Modulo'                => 'social', // Modulo Referente
            'SubModulo'             => 'Midia',   // Submodulo Referente
            'Metodo'                => 'Midias',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => __('Social (Midias) - Add'),
            'Desc'                  => '',
            'Chave'                 => 'social_Midia_Midias_Add', // CHave unica nunca repete, chave primaria
            'End'                   => 'social/Midia/Midias_Add', // Endereco da url de permissão
            'Modulo'                => 'social', // Modulo Referente
            'SubModulo'             => 'Midia',   // Submodulo Referente
            'Metodo'                => 'Midias_Add,Midias_Add2',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => __('Social (Midias) - Editar'),
            'Desc'                  => '',
            'Chave'                 => 'social_Midia_Midias_Edit', // CHave unica nunca repete, chave primaria
            'End'                   => 'social/Midia/Midias_Edit', // Endereco da url de permissão
            'Modulo'                => 'social', // Modulo Referente
            'SubModulo'             => 'Midia',// Submodulo Referente
            'Metodo'                => 'Midias_Edit,Midias_Edit2',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => __('Social (Midias) - Deletar'),
            'Desc'                  => '',
            'Chave'                 => 'social_Midia_Midias_Del', // CHave unica nunca repete, chave primaria
            'End'                   => 'social/Midia/Midias_Del', // Endereco da url de permissão
            'Modulo'                => 'social', // Modulo Referente
            'SubModulo'             => 'Midia',   // Submodulo Referente
            'Metodo'                => 'Midias_Del',  // Metodos referentes separados por virgula
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
