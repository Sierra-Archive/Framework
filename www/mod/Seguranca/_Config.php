<?php
$config_Modulo = function (){
    return Array(
        'Nome'                      =>  'Seguranca',
        'Descrição'                 =>  '',
        'System_Require'            =>  '2.21.1',
        'Version'                   =>  '0.0.1',
        'Dependencias'              =>  false,
    );
};
$config_Menu = function (){
    return Array(
        'Segurança'=>Array(
            'Nome'                  => 'Segurança',
            'Link'                  => '#',
            'Gravidade'             => 50,
            'Img'                   => 'turboadmin/m-dashboard.png',
            'Icon'                  => 'list-alt',
            'Filhos'                => Array('Senhas'=>Array(
                'Nome'                  => 'M. Senhas',
                'Link'                  => 'Seguranca/Senha/Senhas',
                'Gravidade'             => 80,
                'Img'                   => 'turboadmin/m-users.png',
                'Icon'                  => 'list-alt',
                'Filhos'                => false,
            ),'Senhas'=>Array(
                'Nome'                  => 'T. Senhas',
                'Link'                  => 'Seguranca/Senha/Senhas_Todas',
                'Gravidade'             => 50,
                'Img'                   => 'turboadmin/m-users.png',
                'Icon'                  => 'list-alt',
                'Filhos'                => false,
            )),
        ),
    );
};
$config_Permissoes = function (){
    return Array(
        Array(
            'Nome'                  => 'Segurança (Minhas Senhas) - Listagem',
            'Desc'                  => '',
            'Chave'                 => 'Seguranca_Senha_Senhas',
            'End'                   => 'Seguranca/Senha/Senhas', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Seguranca', // Modulo Referente
            'SubModulo'             => 'Senha',   // Submodulo Referente
            'Metodo'                => 'Senhas',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => 'Segurança (Minhas Senhas) - Add',
            'Desc'                  => '',
            'Chave'                 => 'Seguranca_Senha_Senhas_Add', // CHave unica nunca repete, chave primaria
            'End'                   => 'Seguranca/Senha/Senhas_Add', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Seguranca', // Modulo Referente
            'SubModulo'             => 'Senha',   // Submodulo Referente
            'Metodo'                => 'Senhas_Add,Senhas_Add2',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => 'Segurança (Minhas Senhas) - Editar',
            'Desc'                  => '',
            'Chave'                 => 'Seguranca_Senha_Senhas_Edit', // CHave unica nunca repete, chave primaria
            'End'                   => 'Seguranca/Senha/Senhas_Edit', // Endereco que deve conter a url para permitir acesso // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Seguranca', // Modulo Referente // Modulo Referente
            'SubModulo'             => 'Senha',   // Submodulo Referente   // Submodulo Referente
            'Metodo'                => 'Senhas_Edit,Senhas_Edit2',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => 'Segurança (Minhas Senhas) - Deletar',
            'Desc'                  => '',
            'Chave'                 => 'Seguranca_Senha_Senhas_Del', // CHave unica nunca repete, chave primaria
            'End'                   => 'Seguranca/Senha/Senhas_Del', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Seguranca', // Modulo Referente
            'SubModulo'             => 'Senha',   // Submodulo Referente
            'Metodo'                => 'Senhas_Del',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => 'Segurança (Minhas Senhas) - Status Alterar',
            'Desc'                  => '',
            'Chave'                 => 'Seguranca_Senha_Status', // CHave unica nunca repete, chave primaria
            'End'                   => 'Seguranca/Senha/Status', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Seguranca', // Modulo Referente
            'SubModulo'             => 'Senha',   // Submodulo Referente
            'Metodo'                => 'Status',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => 'Segurança (Minhas Senhas) - Destaque Alterar',
            'Desc'                  => '',
            'Chave'                 => 'Seguranca_Senha_Destaque', // CHave unica nunca repete, chave primaria
            'End'                   => 'Seguranca/Senha/Destaque', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Seguranca', // Modulo Referente
            'SubModulo'             => 'Senha',   // Submodulo Referente
            'Metodo'                => 'Destaque',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => 'Segurança (Senhas_Todas) - Listagem',
            'Desc'                  => '',
            'Chave'                 => 'Seguranca_Senha_Senhas_Todas',
            'End'                   => 'Seguranca/Senha/Senhas_Todas', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Seguranca', // Modulo Referente
            'SubModulo'             => 'Senha',   // Submodulo Referente
            'Metodo'                => 'Senhas_Todas',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => 'Segurança (Senhas_Todas) - Add',
            'Desc'                  => '',
            'Chave'                 => 'Seguranca_Senha_Senhas_Todas_Add', // CHave unica nunca repete, chave primaria
            'End'                   => 'Seguranca/Senha/Senhas_Todas_Add', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Seguranca', // Modulo Referente
            'SubModulo'             => 'Senha',   // Submodulo Referente
            'Metodo'                => 'Senhas_Todas_Add,Senhas_Todas_Add2',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => 'Segurança (Senhas_Todas) - Editar',
            'Desc'                  => '',
            'Chave'                 => 'Seguranca_Senha_Senhas_Todas_Edit', // CHave unica nunca repete, chave primaria
            'End'                   => 'Seguranca/Senha/Senhas_Todas_Edit', // Endereco que deve conter a url para permitir acesso // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Seguranca', // Modulo Referente // Modulo Referente
            'SubModulo'             => 'Senha',   // Submodulo Referente   // Submodulo Referente
            'Metodo'                => 'Senhas_Todas_Edit,Senhas_Todas_Edit2',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => 'Segurança (Senhas_Todas) - Deletar',
            'Desc'                  => '',
            'Chave'                 => 'Seguranca_Senha_Senhas_Todas_Del', // CHave unica nunca repete, chave primaria
            'End'                   => 'Seguranca/Senha/Senhas_Todas_Del', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Seguranca', // Modulo Referente
            'SubModulo'             => 'Senha',   // Submodulo Referente
            'Metodo'                => 'Senhas_Todas_Del',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => 'Segurança (Senhas_Todas) - Status Alterar',
            'Desc'                  => '',
            'Chave'                 => 'Seguranca_Senha_Status_Todas', // CHave unica nunca repete, chave primaria
            'End'                   => 'Seguranca/Senha/Status_Todas', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Seguranca', // Modulo Referente
            'SubModulo'             => 'Senha',   // Submodulo Referente
            'Metodo'                => 'Status_Todas',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => 'Segurança (Senhas_Todas) - Destaque Alterar',
            'Desc'                  => '',
            'Chave'                 => 'Seguranca_Senha_Destaque_Todas', // CHave unica nunca repete, chave primaria
            'End'                   => 'Seguranca/Senha/Destaque_Todas', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Seguranca', // Modulo Referente
            'SubModulo'             => 'Senha',   // Submodulo Referente
            'Metodo'                => 'Destaque_Todas',  // Metodos referentes separados por virgula
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
