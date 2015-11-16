<?php
$configModule = function () {
    return Array(
        'Nome'                      =>  'Agenda',
        'Descrição'                 =>  '',
        'System_Require'            =>  '3.1.0',
        'Version'                   =>  '3.1.1',
        'Dependencias'              =>  FALSE,
    );
};

// Menu
$configMenu = function () {
    return Array(
        'Agenda'=>Array(
            'Nome'                  => __('Agenda'),
            'Link'                  => '#',
            'Gravidade'             => 90,
            'Img'                   => 'turboadmin/m-dashboard.png',
            'Icon'                  => 'time',
            'Filhos'                => Array('Pastas'=>Array(
                'Nome'                  => __('Pastas'),
                'Link'                  => 'Agenda/Pasta/Pastas',
                'Gravidade'             => 10,
                'Img'                   => 'turboadmin/m-dashboard.png',
                'Icon'                  => 'calendar',
                'Filhos'                => FALSE,
            ),'Agenda'=>Array(
                'Nome'                  => __('Agenda'),
                'Link'                  => 'Agenda/Agenda/Agendas',
                'Gravidade'             => 7,
                'Img'                   => 'turboadmin/m-dashboard.png',
                'Icon'                  => 'calendar',
                'Filhos'                => FALSE,
            ),'Atividades'=>Array(
                'Nome'                  => __('Atividades'),
                'Link'                  => 'Agenda/Atividades/Atividades',
                'Gravidade'             => 5,
                'Img'                   => 'turboadmin/m-dashboard.png',
                'Icon'                  => 'time',
                'Filhos'                => FALSE,
            ),),
        ),
        'Administrar'=>Array(
            'Filhos'                => Array('Pastas Cores'=>Array(
                'Nome'                  => __('Pastas Cores'),
                'Link'                  => 'Agenda/Pasta/Cores',
                'Gravidade'             => 10,
                'Img'                   => 'turboadmin/m-dashboard.png',
                'Icon'                  => 'time',
                'Filhos'                => FALSE,
            ),),
        ),
    );
};
$config_Permissoes = function () {
    return Array(
        Array(
            'Nome'                  => __('Agenda (Compromissos) - Listagem'),
            'Desc'                  => '',
            'Chave'                 => 'Agenda',
            'End'                   => 'Agenda/Compromisso', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Agenda', // Modulo Referente
            'SubModulo'             => 'Compromisso',// Submodulo Referente
            'Metodo'                => 'Compromissos',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => __('Agenda (Compromissos) - Add Compromissos'),
            'Desc'                  => '',
            'Chave'                 => 'Agendas_Add', // CHave unica nunca repete, chave primaria
            'End'                   => 'Agenda/Compromisso/Compromissos_Add', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Agenda', // Modulo Referente
            'SubModulo'             => 'Compromisso',   // Submodulo Referente
            'Metodo'                => 'Compromissos_Add,Compromissos_Add2',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => __('Agenda (Compromissos) - Editar Compromissos'),
            'Desc'                  => '',
            'Chave'                 => 'Agenda_Edit', // CHave unica nunca repete, chave primaria
            'End'                   => 'Agenda/Compromisso/Compromissos_Edit', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Agenda', // Modulo Referente
            'SubModulo'             => 'Compromisso',// Submodulo Referente
            'Metodo'                => 'Compromissos_Edit,Compromissos_Edit2',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => __('Agenda (Compromissos) - Deletar Compromissos'),
            'Desc'                  => '',
            'Chave'                 => 'Agenda_Del', // CHave unica nunca repete, chave primaria
            'End'                   => 'Agenda/Compromisso/Compromissos_Del', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Agenda', // Modulo Referente
            'SubModulo'             => 'Compromisso',   // Submodulo Referente
            'Metodo'                => 'Compromissos_Del',  // Metodos referentes separados por virgula
        ),
        
        
        
        
        Array(
            'Nome'                  => __('Agenda (Pastas) - Listagem'),
            'Desc'                  => '',
            'Chave'                 => 'Agenda_Pasta',
            'End'                   => 'Agenda/Pasta', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Agenda', // Modulo Referente
            'SubModulo'             => 'Pasta',// Submodulo Referente
            'Metodo'                => 'Pastas',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => __('Agenda (Pastas) - Add'),
            'Desc'                  => '',
            'Chave'                 => 'Agenda_Pasta_Pastas_Add', // CHave unica nunca repete, chave primaria
            'End'                   => 'Agenda/Pasta/Pastas_Add', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Agenda', // Modulo Referente
            'SubModulo'             => 'Pasta',   // Submodulo Referente
            'Metodo'                => 'Pastas_Add,Pastas_Add2',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => __('Agenda (Pastas) - Editar'),
            'Desc'                  => '',
            'Chave'                 => 'Agenda_Pasta_Pastas_Edit', // CHave unica nunca repete, chave primaria
            'End'                   => 'Agenda/Pasta/Pastas_Edit', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Agenda', // Modulo Referente
            'SubModulo'             => 'Pasta',// Submodulo Referente
            'Metodo'                => 'Pastas_Edit,Pastas_Edit2',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => __('Agenda (Pastas) - Deletar'),
            'Desc'                  => '',
            'Chave'                 => 'Agenda_Pasta_Pastas_Del', // CHave unica nunca repete, chave primaria
            'End'                   => 'Agenda/Pasta/Pastas_Del', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Agenda', // Modulo Referente
            'SubModulo'             => 'Pasta',   // Submodulo Referente
            'Metodo'                => 'Pastas_Del',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => __('Agenda (Pasta - Cores) - Listagem'),
            'Desc'                  => '',
            'Chave'                 => 'Agenda_Pasta',
            'End'                   => 'Agenda/Pasta', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Agenda', // Modulo Referente
            'SubModulo'             => 'Pasta',// Submodulo Referente
            'Metodo'                => 'Cores',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => __('Agenda (Pasta - Cores) - Add'),
            'Desc'                  => '',
            'Chave'                 => 'Agenda_Pasta_Cores_Add', // CHave unica nunca repete, chave primaria
            'End'                   => 'Agenda/Pasta/Cores_Add', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Agenda', // Modulo Referente
            'SubModulo'             => 'Pasta',   // Submodulo Referente
            'Metodo'                => 'Cores_Add,Cores_Add2',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => __('Agenda (Pasta - Cores) - Editar'),
            'Desc'                  => '',
            'Chave'                 => 'Agenda_Pasta_Cores_Edit', // CHave unica nunca repete, chave primaria
            'End'                   => 'Agenda/Pasta/Cores_Edit', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Agenda', // Modulo Referente
            'SubModulo'             => 'Pasta',// Submodulo Referente
            'Metodo'                => 'Cores_Edit,Cores_Edit2',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => __('Agenda (Pasta - Cores) - Deletar'),
            'Desc'                  => '',
            'Chave'                 => 'Agenda_Pasta_Cores_Del', // CHave unica nunca repete, chave primaria
            'End'                   => 'Agenda/Pasta/Cores_Del', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Agenda', // Modulo Referente
            'SubModulo'             => 'Pasta',   // Submodulo Referente
            'Metodo'                => 'Cores_Del',  // Metodos referentes separados por virgula
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

