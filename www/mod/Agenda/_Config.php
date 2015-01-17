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

// Menu
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
                'Link'                  => 'Agenda/Pasta/Pastas',
                'Gravidade'             => 10,
                'Img'                   => 'turboadmin/m-dashboard.png',
                'Icon'                  => 'calendar',
                'Filhos'                => false,
            ),'Compromissos'=>Array(
                'Nome'                  => 'Compromissos',
                'Link'                  => 'Agenda/Compromisso/Compromissos',
                'Gravidade'             => 7,
                'Img'                   => 'turboadmin/m-dashboard.png',
                'Icon'                  => 'calendar',
                'Filhos'                => false,
            ),'Atividades'=>Array(
                'Nome'                  => 'Atividades',
                'Link'                  => 'Agenda/Atividades/Atividades',
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
            'Nome'                  => 'Agenda (Compromissos) - Listagem',
            'Desc'                  => '',
            'Chave'                 => 'Agenda_Compromisso',
            'End'                   => 'Agenda/Compromisso', // Endereco que deve conter a url para permitir acesso // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Agenda', // Modulo Referente // Modulo Referente
            'SubModulo'             => 'Compromisso',   // Submodulo Referente   // Submodulo Referente
            'Metodo'                => 'Compromissos',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => 'Agenda (Compromissos) - Add Compromissos',
            'Desc'                  => '',
            'Chave'                 => 'Agenda_Compromissos_Add', // CHave unica nunca repete, chave primaria
            'End'                   => 'Agenda/Compromisso/Compromissos_Add', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Agenda', // Modulo Referente
            'SubModulo'             => 'Compromisso',   // Submodulo Referente
            'Metodo'                => 'Compromissos_Add,Compromissos_Add2',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => 'Agenda (Compromissos) - Editar Compromissos',
            'Desc'                  => '',
            'Chave'                 => 'Agenda_Edit', // CHave unica nunca repete, chave primaria
            'End'                   => 'Agenda/Compromisso/Compromissos_Edit', // Endereco que deve conter a url para permitir acesso // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Agenda', // Modulo Referente // Modulo Referente
            'SubModulo'             => 'Compromisso',   // Submodulo Referente   // Submodulo Referente
            'Metodo'                => 'Compromissos_Edit,Compromissos_Edit2',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => 'Agenda (Compromissos) - Deletar Compromissos',
            'Desc'                  => '',
            'Chave'                 => 'Agenda_Del', // CHave unica nunca repete, chave primaria
            'End'                   => 'Agenda/Compromisso/Compromissos_Del', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Agenda', // Modulo Referente
            'SubModulo'             => 'Compromisso',   // Submodulo Referente
            'Metodo'                => 'Compromissos_Del',  // Metodos referentes separados por virgula
        ),
        
        
        
        
        Array(
            'Nome'                  => 'Agenda (Pastas) - Listagem',
            'Desc'                  => '',
            'Chave'                 => 'Agenda_Pasta',
            'End'                   => 'Agenda/Pasta', // Endereco que deve conter a url para permitir acesso // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Agenda', // Modulo Referente // Modulo Referente
            'SubModulo'             => 'Pasta',   // Submodulo Referente   // Submodulo Referente
            'Metodo'                => 'Pastas',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => 'Agenda (Pastas) - Add',
            'Desc'                  => '',
            'Chave'                 => 'Agenda_Pasta_Pastas_Add', // CHave unica nunca repete, chave primaria
            'End'                   => 'Agenda/Pasta/Pastas_Add', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Agenda', // Modulo Referente
            'SubModulo'             => 'Pasta',   // Submodulo Referente
            'Metodo'                => 'Pastas_Add,Pastas_Add2',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => 'Agenda (Pastas) - Editar',
            'Desc'                  => '',
            'Chave'                 => 'Agenda_Pasta_Pastas_Edit', // CHave unica nunca repete, chave primaria
            'End'                   => 'Agenda/Pasta/Pastas_Edit', // Endereco que deve conter a url para permitir acesso // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Agenda', // Modulo Referente // Modulo Referente
            'SubModulo'             => 'Pasta',   // Submodulo Referente   // Submodulo Referente
            'Metodo'                => 'Pastas_Edit,Pastas_Edit2',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => 'Agenda (Pastas) - Deletar',
            'Desc'                  => '',
            'Chave'                 => 'Agenda_Pasta_Pastas_Del', // CHave unica nunca repete, chave primaria
            'End'                   => 'Agenda/Pasta/Pastas_Del', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Agenda', // Modulo Referente
            'SubModulo'             => 'Pasta',   // Submodulo Referente
            'Metodo'                => 'Pastas_Del',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => 'Agenda (Pasta - Cores) - Listagem',
            'Desc'                  => '',
            'Chave'                 => 'Agenda_Pasta',
            'End'                   => 'Agenda/Pasta', // Endereco que deve conter a url para permitir acesso // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Agenda', // Modulo Referente // Modulo Referente
            'SubModulo'             => 'Pasta',   // Submodulo Referente   // Submodulo Referente
            'Metodo'                => 'Cores',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => 'Agenda (Pasta - Cores) - Add',
            'Desc'                  => '',
            'Chave'                 => 'Agenda_Pasta_Cores_Add', // CHave unica nunca repete, chave primaria
            'End'                   => 'Agenda/Pasta/Cores_Add', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Agenda', // Modulo Referente
            'SubModulo'             => 'Pasta',   // Submodulo Referente
            'Metodo'                => 'Cores_Add,Cores_Add2',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => 'Agenda (Pasta - Cores) - Editar',
            'Desc'                  => '',
            'Chave'                 => 'Agenda_Pasta_Cores_Edit', // CHave unica nunca repete, chave primaria
            'End'                   => 'Agenda/Pasta/Cores_Edit', // Endereco que deve conter a url para permitir acesso // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Agenda', // Modulo Referente // Modulo Referente
            'SubModulo'             => 'Pasta',   // Submodulo Referente   // Submodulo Referente
            'Metodo'                => 'Cores_Edit,Cores_Edit2',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => 'Agenda (Pasta - Cores) - Deletar',
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
$config_Funcional = function (){
    return Array();
};
?>
