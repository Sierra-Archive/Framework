<?php
$config_Modulo = function (){
    return Array(
        'Nome'                      =>  'Agenda',
        'Descrição'                 =>  '',
        'System_Require'            =>  '2.21.1',
        'Version'                   =>  '0.0.1',
        'Dependencias'              =>  false,
    );
};
$config_Menu = function (){
    return Array(
        'Agenda'=>Array(
            'Nome'                  => 'Agenda',
            'Link'                  => '#',
            'Gravidade'             => 10,
            'Img'                   => 'turboadmin/m-dashboard.png',
            'Icon'                  => 'time',
            'Filhos'                => Array('Pastas'=>Array(
                'Nome'                  => 'Pastas',
                'Link'                  => 'Agenda/Pasta/Main',
                'Gravidade'             => 10,
                'Img'                   => 'turboadmin/m-dashboard.png',
                'Icon'                  => 'calendar',
                'Filhos'                => false,
            ),'Compromissos'=>Array(
                'Nome'                  => 'Compromissos',
                'Link'                  => 'Agenda/compromisso/Main',
                'Gravidade'             => 7,
                'Img'                   => 'turboadmin/m-dashboard.png',
                'Icon'                  => 'calendar',
                'Filhos'                => false,
            ),'Atividades'=>Array(
                'Nome'                  => 'Atividades',
                'Link'                  => 'Agenda/Atividades/Main',
                'Gravidade'             => 5,
                'Img'                   => 'turboadmin/m-dashboard.png',
                'Icon'                  => 'time',
                'Filhos'                => false,
            ),),
        ),
        'Administrar'=>Array(
            'Nome'                  => 'Administrar',
            'Filhos'                => Array('Pastas Cores'=>Array(
                'Nome'                  => 'Pastas Cores',
                'Link'                  => 'Agenda/Pasta/Cores',
                'Gravidade'             => 10,
                'Img'                   => 'turboadmin/m-dashboard.png',
                'Icon'                  => 'time',
                'Filhos'                => false,
            ),),
        ),
    );
};
$config_Permissoes = function (){
    return Array(
        Array(
            'Nome'                  => 'Administrar Compromissos',
            'Desc'                  => '',
            'Chave'                 => 'Agenda_compromisso',
            'End'                   => 'Agenda/compromisso', // Endereco que deve conter a url para permitir acesso // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Agenda', // Modulo Referente // Modulo Referente
            'SubModulo'             => 'Compromisso',   // Submodulo Referente   // Submodulo Referente
            'Metodo'                => 'Compromissos_Edit,Compromissos_Edit2',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => 'Add Compromissos',
            'Desc'                  => '',
            'Chave'                 => 'Agenda_Compromissos_Add', // CHave unica nunca repete, chave primaria
            'End'                   => 'Agenda/Compromisso/Compromissos_Add', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Agenda', // Modulo Referente
            'SubModulo'             => 'Compromisso',   // Submodulo Referente
            'Metodo'                => 'Compromissos_Add,Compromissos_Add2',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => 'Editar Compromissos',
            'Desc'                  => '',
            'Chave'                 => 'Agenda_Edit', // CHave unica nunca repete, chave primaria
            'End'                   => 'Agenda/Compromisso/Compromissos_Edit', // Endereco que deve conter a url para permitir acesso // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Agenda', // Modulo Referente // Modulo Referente
            'SubModulo'             => 'Compromisso',   // Submodulo Referente   // Submodulo Referente
            'Metodo'                => 'Compromissos_Edit,Compromissos_Edit2',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => 'Deletar Compromissos',
            'Desc'                  => '',
            'Chave'                 => 'Agenda_Del', // CHave unica nunca repete, chave primaria
            'End'                   => 'Agenda/Compromisso/Compromissos_del', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Agenda', // Modulo Referente
            'SubModulo'             => 'Compromisso',   // Submodulo Referente
            'Metodo'                => 'Compromissos_del',  // Metodos referentes separados por virgula
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
