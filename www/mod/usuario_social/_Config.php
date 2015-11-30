<?php
$config_Modulo = function (){
    return Array(
        'Nome'                      =>  'usuario_social',
        'Descrição'                 =>  '',
        'System_Require'            =>  '2.21.1',
        'Version'                   =>  '0.0.1',
        'Dependencias'              =>  false,
    );
};
$config_Menu = function (){
    return Array(
        'Social'=>Array(
            'Nome'                  => 'Social',
            'Link'                  => '#',
            'Gravidade'             => 2,
            'Img'                   => 'turboadmin/m-dashboard.png',
            'Icon'                  => 'male',
            'Filhos'                => Array('Pessoas'=>Array(
                'Nome'                  => 'Pessoas',
                'Link'                  => 'usuario_social/Persona/Personas',
                'Gravidade'             => 9,
                'Img'                   => 'turboadmin/m-users.png',
                'Icon'                  => 'male',
                'Filhos'                => false,
            ),'Caracteristicas'=>Array(
                'Nome'                  => 'Caracteristicas',
                'Link'                  => 'usuario_social/Caracteristica/Caracteristicas',
                'Gravidade'             => 9,
                'Img'                   => 'turboadmin/m-users.png',
                'Icon'                  => 'group',
                'Filhos'                => false,
            ),'Ações'=>Array(
                'Nome'                  => 'Ações',
                'Link'                  => 'usuario_social/Acao/Acao',
                'Gravidade'             => 9,
                'Img'                   => 'turboadmin/m-users.png',
                'Icon'                  => 'group',
                'Filhos'                => false,
            ),'Lista Telefonica'=>Array(
                'Nome'                  => 'Lista Telefonica',
                'Link'                  => 'usuario_social/Telefone/Telefones',
                'Gravidade'             => 9,
                'Img'                   => 'turboadmin/m-users.png',
                'Icon'                  => 'phone',
                'Filhos'                => false,
            ),'Fotos'=>Array(
                'Nome'                  => 'Fotos',
                'Link'                  => 'usuario_social/Fotos/Fotos',
                'Gravidade'             => 9,
                'Img'                   => 'turboadmin/m-users.png',
                'Icon'                  => 'camera',
                'Filhos'                => false,
            ),),
        ),
    );
};
$config_Permissoes = function (){
    return Array(
        Array(
            'Nome'                  => 'Social (Pessoas) - Listagem',
            'Desc'                  => '',
            'Chave'                 => 'usuario_social_Persona_Personas',
            'End'                   => 'usuario_social/Persona/Personas', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'usuario_social', // Modulo Referente
            'SubModulo'             => 'Persona',   // Submodulo Referente
            'Metodo'                => 'Personas',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => 'Social (Pessoas) - Add',
            'Desc'                  => '',
            'Chave'                 => 'usuario_social_Persona_Personas_Add', // CHave unica nunca repete, chave primaria
            'End'                   => 'usuario_social/Persona/Personas_Add', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'usuario_social', // Modulo Referente
            'SubModulo'             => 'Persona',   // Submodulo Referente
            'Metodo'                => 'Personas_Add,Personas_Add2',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => 'Social (Pessoas) - Editar',
            'Desc'                  => '',
            'Chave'                 => 'usuario_social_Persona_Personas_Edit', // CHave unica nunca repete, chave primaria
            'End'                   => 'usuario_social/Persona/Personas_Edit', // Endereco que deve conter a url para permitir acesso // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'usuario_social', // Modulo Referente // Modulo Referente
            'SubModulo'             => 'Persona',   // Submodulo Referente   // Submodulo Referente
            'Metodo'                => 'Personas_Edit,Personas_Edit2',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => 'Social (Pessoas) - Deletar',
            'Desc'                  => '',
            'Chave'                 => 'usuario_social_Persona_Personas_Del', // CHave unica nunca repete, chave primaria
            'End'                   => 'usuario_social/Persona/Personas_Del', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'usuario_social', // Modulo Referente
            'SubModulo'             => 'Persona',   // Submodulo Referente
            'Metodo'                => 'Personas_Del',  // Metodos referentes separados por virgula
        ),
        
        Array(
            'Nome'                  => 'Social (Caracteristicas) - Administrar',
            'Desc'                  => '',
            'Chave'                 => 'usuario_social_Caracteristica_Caracteristicas',
            'End'                   => 'usuario_social/Caracteristica/Caracteristicas', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'usuario_social', // Modulo Referente
            'SubModulo'             => 'Caracteristica',   // Submodulo Referente
            'Metodo'                => 'Caracteristicas',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => 'Social (Caracteristicas) - Add',
            'Desc'                  => '',
            'Chave'                 => 'usuario_social_Caracteristica_Caracteristicas_Add', // CHave unica nunca repete, chave primaria
            'End'                   => 'usuario_social/Caracteristica/Caracteristicas_Add', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'usuario_social', // Modulo Referente
            'SubModulo'             => 'Caracteristica',   // Submodulo Referente
            'Metodo'                => 'Caracteristicas_Add,Caracteristicas_Add2',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => 'Social (Caracteristicas) - Editar',
            'Desc'                  => '',
            'Chave'                 => 'usuario_social_Caracteristica_Caracteristicas_Edit', // CHave unica nunca repete, chave primaria
            'End'                   => 'usuario_social/Caracteristica/Caracteristicas_Edit', // Endereco que deve conter a url para permitir acesso // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'usuario_social', // Modulo Referente // Modulo Referente
            'SubModulo'             => 'Caracteristica',   // Submodulo Referente   // Submodulo Referente
            'Metodo'                => 'Caracteristicas_Edit,Caracteristicas_Edit2',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => 'Social (Caracteristicas) - Deletar',
            'Desc'                  => '',
            'Chave'                 => 'usuario_social_Caracteristica_Caracteristicas_Del', // CHave unica nunca repete, chave primaria
            'End'                   => 'usuario_social/Caracteristica/Caracteristicas_Del', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'usuario_social', // Modulo Referente
            'SubModulo'             => 'Caracteristica',   // Submodulo Referente
            'Metodo'                => 'Caracteristicas_Del',  // Metodos referentes separados por virgula
        ),
        
        Array(
            'Nome'                  => 'Social (Ações) - Administrar',
            'Desc'                  => '',
            'Chave'                 => 'usuario_social_Acao_Acao',
            'End'                   => 'usuario_social/Acao/Acao', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'usuario_social', // Modulo Referente
            'SubModulo'             => 'Acao',   // Submodulo Referente
            'Metodo'                => 'Acao',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => 'Social (Ações) - Add',
            'Desc'                  => '',
            'Chave'                 => 'usuario_social_Acao_Acoes_Add', // CHave unica nunca repete, chave primaria
            'End'                   => 'usuario_social/Acao/Acoes_Add', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'usuario_social', // Modulo Referente
            'SubModulo'             => 'Acao',   // Submodulo Referente
            'Metodo'                => 'Acoes_Add,Acoes_Add2',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => 'Social (Ações) - Editar',
            'Desc'                  => '',
            'Chave'                 => 'usuario_social_Acao_Acoes_Edit', // CHave unica nunca repete, chave primaria
            'End'                   => 'usuario_social/Acao/Acoes_Edit', // Endereco que deve conter a url para permitir acesso // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'usuario_social', // Modulo Referente // Modulo Referente
            'SubModulo'             => 'PAcao',   // Submodulo Referente   // Submodulo Referente
            'Metodo'                => 'Acoes_Edit,Acoes_Edit2',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => 'Social (Ações) - Deletar',
            'Desc'                  => '',
            'Chave'                 => 'usuario_social_Acao_Acoes_Del', // CHave unica nunca repete, chave primaria
            'End'                   => 'usuario_social/Acao/Acoes_Del', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'usuario_social', // Modulo Referente
            'SubModulo'             => 'Acao',   // Submodulo Referente
            'Metodo'                => 'Acoes_Del',  // Metodos referentes separados por virgula
        ),
        
        Array(
            'Nome'                  => 'Social (Fotos) - Administrar',
            'Desc'                  => '',
            'Chave'                 => 'usuario_social_Foto_Fotos',
            'End'                   => 'usuario_social/Foto/Fotos', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'usuario_social', // Modulo Referente
            'SubModulo'             => 'Foto',   // Submodulo Referente
            'Metodo'                => 'Fotos',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => 'Social (Fotos) - Add',
            'Desc'                  => '',
            'Chave'                 => 'usuario_social_Foto_Fotos_Add', // CHave unica nunca repete, chave primaria
            'End'                   => 'usuario_social/Foto/Fotos_Add', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'usuario_social', // Modulo Referente
            'SubModulo'             => 'Foto',   // Submodulo Referente
            'Metodo'                => 'Fotos_Add,Fotos_Add2',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => 'Social (Fotos) - Editar',
            'Desc'                  => '',
            'Chave'                 => 'usuario_social_Foto_Fotos_Edit', // CHave unica nunca repete, chave primaria
            'End'                   => 'usuario_social/Foto/Fotos_Edit', // Endereco que deve conter a url para permitir acesso // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'usuario_social', // Modulo Referente // Modulo Referente
            'SubModulo'             => 'Foto',   // Submodulo Referente   // Submodulo Referente
            'Metodo'                => 'Fotos_Edit,Fotos_Edit2',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => 'Social (Fotos) - Deletar',
            'Desc'                  => '',
            'Chave'                 => 'usuario_social_Foto_Fotos_Del', // CHave unica nunca repete, chave primaria
            'End'                   => 'usuario_social/Foto/Fotos_Del', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'usuario_social', // Modulo Referente
            'SubModulo'             => 'Foto',   // Submodulo Referente
            'Metodo'                => 'Fotos_Del',  // Metodos referentes separados por virgula
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
