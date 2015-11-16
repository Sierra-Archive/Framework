<?php
$config_Modulo = function () {
    return Array(
        'Nome'                      =>  'social',
        'Descrição'                 =>  '',
        'System_Require'            =>  '3.1.0',
        'Version'                   =>  '3.1.1',
        'Dependencias'              =>  false,
    );
};
$config_Menu = function () {
    return Array(
        'Social'=>Array(
            'Nome'                  => __('Social'),
            'Link'                  => '#',
            'Gravidade'             => 80,
            'Img'                   => 'turboadmin/m-dashboard.png',
            'Icon'                  => 'male',
            'Filhos'                => Array('Pessoas'=>Array(
                'Nome'                  => __('Pessoas'),
                'Link'                  => 'social/Persona/Personas',
                'Gravidade'             => 9,
                'Img'                   => 'turboadmin/m-users.png',
                'Icon'                  => 'male',
                'Filhos'                => FALSE,
            ),'Ações'=>Array(
                'Nome'                  => __('Ações'),
                'Link'                  => 'social/Acao/Acao',
                'Gravidade'             => 9,
                'Img'                   => 'turboadmin/m-users.png',
                'Icon'                  => 'eye-close',
                'Filhos'                => FALSE,
            ),'Midias'=>Array(
                'Nome'                  => __('Midias'),
                'Link'                  => 'social/Midia/Midias',
                'Gravidade'             => 9,
                'Img'                   => 'turboadmin/m-users.png',
                'Icon'                  => 'camera',
                'Filhos'                => FALSE,
            ) 
        ),
        'Administrar'=>Array(
            'Caracteristicas'=>Array(
                'Nome'                  => __('Caracteristicas'),
                'Link'                  => 'social/Caracteristica/Caracteristicas',
                'Gravidade'             => 9,
                'Img'                   => 'turboadmin/m-users.png',
                'Icon'                  => 'sunglasses',
                'Filhos'                => FALSE,
            ),
            'Tarefas'=>Array(
                'Nome'                  => __('Tarefas'),
                'Link'                  => 'social/Tarefa/Tarefas',
                'Gravidade'             => 9,
                'Img'                   => 'turboadmin/m-users.png',
                'Icon'                  => 'wrench',
                'Filhos'                => FALSE,
            ),'Atributos'=>Array(
                'Nome'                  => __('Atributos'),
                'Link'                  => 'social/Atributo/Atributos',
                'Gravidade'             => 9,
                'Img'                   => 'turboadmin/m-users.png',
                'Icon'                  => 'briefcase',
                'Filhos'                => FALSE,
            ),'Gosto'=>Array(
                'Nome'                  => __('Gostos'),
                'Link'                  => 'social/Gosto/Gostos',
                'Gravidade'             => 9,
                'Img'                   => 'turboadmin/m-users.png',
                'Icon'                  => 'heart-empty',
                'Filhos'                => FALSE,
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
            'End'                   => 'social/Persona/Personas', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'social', // Modulo Referente
            'SubModulo'             => 'Persona',   // Submodulo Referente
            'Metodo'                => 'Personas',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => __('Social (Pessoas) - Add'),
            'Desc'                  => '',
            'Chave'                 => 'social_Persona_Personas_Add', // CHave unica nunca repete, chave primaria
            'End'                   => 'social/Persona/Personas_Add', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'social', // Modulo Referente
            'SubModulo'             => 'Persona',   // Submodulo Referente
            'Metodo'                => 'Personas_Add,Personas_Add2',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => __('Social (Pessoas) - Editar'),
            'Desc'                  => '',
            'Chave'                 => 'social_Persona_Personas_Edit', // CHave unica nunca repete, chave primaria
            'End'                   => 'social/Persona/Personas_Edit', // Endereco que deve conter a url para permitir acesso // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'social', // Modulo Referente // Modulo Referente
            'SubModulo'             => 'Persona',   // Submodulo Referente   // Submodulo Referente
            'Metodo'                => 'Personas_Edit,Personas_Edit2',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => __('Social (Pessoas) - Deletar'),
            'Desc'                  => '',
            'Chave'                 => 'social_Persona_Personas_Del', // CHave unica nunca repete, chave primaria
            'End'                   => 'social/Persona/Personas_Del', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'social', // Modulo Referente
            'SubModulo'             => 'Persona',   // Submodulo Referente
            'Metodo'                => 'Personas_Del',  // Metodos referentes separados por virgula
        ),
        
        Array(
            'Nome'                  => __('Social (Caracteristicas) - Administrar'),
            'Desc'                  => '',
            'Chave'                 => 'social_Caracteristica_Caracteristicas',
            'End'                   => 'social/Caracteristica/Caracteristicas', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'social', // Modulo Referente
            'SubModulo'             => 'Caracteristica',   // Submodulo Referente
            'Metodo'                => 'Caracteristicas',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => __('Social (Caracteristicas) - Add'),
            'Desc'                  => '',
            'Chave'                 => 'social_Caracteristica_Caracteristicas_Add', // CHave unica nunca repete, chave primaria
            'End'                   => 'social/Caracteristica/Caracteristicas_Add', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'social', // Modulo Referente
            'SubModulo'             => 'Caracteristica',   // Submodulo Referente
            'Metodo'                => 'Caracteristicas_Add,Caracteristicas_Add2',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => __('Social (Caracteristicas) - Editar'),
            'Desc'                  => '',
            'Chave'                 => 'social_Caracteristica_Caracteristicas_Edit', // CHave unica nunca repete, chave primaria
            'End'                   => 'social/Caracteristica/Caracteristicas_Edit', // Endereco que deve conter a url para permitir acesso // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'social', // Modulo Referente // Modulo Referente
            'SubModulo'             => 'Caracteristica',   // Submodulo Referente   // Submodulo Referente
            'Metodo'                => 'Caracteristicas_Edit,Caracteristicas_Edit2',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => __('Social (Caracteristicas) - Deletar'),
            'Desc'                  => '',
            'Chave'                 => 'social_Caracteristica_Caracteristicas_Del', // CHave unica nunca repete, chave primaria
            'End'                   => 'social/Caracteristica/Caracteristicas_Del', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'social', // Modulo Referente
            'SubModulo'             => 'Caracteristica',   // Submodulo Referente
            'Metodo'                => 'Caracteristicas_Del',  // Metodos referentes separados por virgula
        ),
        
        Array(
            'Nome'                  => __('Social (Ações) - Administrar'),
            'Desc'                  => '',
            'Chave'                 => 'social_Acao_Acao',
            'End'                   => 'social/Acao/Acao', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'social', // Modulo Referente
            'SubModulo'             => 'Acao',   // Submodulo Referente
            'Metodo'                => 'Acao',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => __('Social (Ações) - Add'),
            'Desc'                  => '',
            'Chave'                 => 'social_Acao_Acoes_Add', // CHave unica nunca repete, chave primaria
            'End'                   => 'social/Acao/Acoes_Add', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'social', // Modulo Referente
            'SubModulo'             => 'Acao',   // Submodulo Referente
            'Metodo'                => 'Acoes_Add,Acoes_Add2',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => __('Social (Ações) - Editar'),
            'Desc'                  => '',
            'Chave'                 => 'social_Acao_Acoes_Edit', // CHave unica nunca repete, chave primaria
            'End'                   => 'social/Acao/Acoes_Edit', // Endereco que deve conter a url para permitir acesso // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'social', // Modulo Referente // Modulo Referente
            'SubModulo'             => 'PAcao',   // Submodulo Referente   // Submodulo Referente
            'Metodo'                => 'Acoes_Edit,Acoes_Edit2',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => __('Social (Ações) - Deletar'),
            'Desc'                  => '',
            'Chave'                 => 'social_Acao_Acoes_Del', // CHave unica nunca repete, chave primaria
            'End'                   => 'social/Acao/Acoes_Del', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'social', // Modulo Referente
            'SubModulo'             => 'Acao',   // Submodulo Referente
            'Metodo'                => 'Acoes_Del',  // Metodos referentes separados por virgula
        ),
        
        Array(
            'Nome'                  => __('Social (Midias) - Administrar'),
            'Desc'                  => '',
            'Chave'                 => 'social_Midia_Midias',
            'End'                   => 'social/Midia/Midias', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'social', // Modulo Referente
            'SubModulo'             => 'Midia',   // Submodulo Referente
            'Metodo'                => 'Midias',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => __('Social (Midias) - Add'),
            'Desc'                  => '',
            'Chave'                 => 'social_Midia_Midias_Add', // CHave unica nunca repete, chave primaria
            'End'                   => 'social/Midia/Midias_Add', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'social', // Modulo Referente
            'SubModulo'             => 'Midia',   // Submodulo Referente
            'Metodo'                => 'Midias_Add,Midias_Add2',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => __('Social (Midias) - Editar'),
            'Desc'                  => '',
            'Chave'                 => 'social_Midia_Midias_Edit', // CHave unica nunca repete, chave primaria
            'End'                   => 'social/Midia/Midias_Edit', // Endereco que deve conter a url para permitir acesso // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'social', // Modulo Referente // Modulo Referente
            'SubModulo'             => 'Midia',   // Submodulo Referente   // Submodulo Referente
            'Metodo'                => 'Midias_Edit,Midias_Edit2',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => __('Social (Midias) - Deletar'),
            'Desc'                  => '',
            'Chave'                 => 'social_Midia_Midias_Del', // CHave unica nunca repete, chave primaria
            'End'                   => 'social/Midia/Midias_Del', // Endereco que deve conter a url para permitir acesso
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
$config_Funcional = function () {
    return Array();
};
/**
 * Configurações que podem ser Alteradas por Admin ou outros usuarios do Sistema (Parametros Opcionais: Mascara e Max
 * @return type
 * 
 * @author Ricardo Sierra <web@ricardosierra.com.br>
 */
$config_Publico = function () {
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
