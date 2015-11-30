<?php
$config_Modulo = function (){
    return Array(
        'Nome'                      =>  '_Sistema',
        'Descrição'                 =>  '',
        'System_Require'            =>  '2.21.1',
        'Version'                   =>  '0.0.1',
        'Dependencias'              =>  false,
    );
};
$config_Menu = function (){
    return Array(
        'Página Inicial' => Array(
            'Nome'                  => 'Página Inicial',
            'Link'                  => '_Sistema/Principal/Home',
            'Gravidade'             => 10000,
            'Img'                   => 'turboadmin/m-dashboard.png',
            'Icon'                  => 'dashboard',
            'Filhos'                => false,
        ),'Administrar' => Array(
            'Nome'                  => 'Administrar',
            'Link'                  => '#',
            'Gravidade'             => 10,
            'Img'                   => 'turboadmin/m-dashboard.png',
            'Icon'                  => 'cog',
        ),'Cadastros' => Array(
            'Nome'                  => 'Cadastros',
            'Link'                  => '#',
            'Gravidade'             => 8,
            'Img'                   => 'turboadmin/m-dashboard.png',
            'Icon'                  => 'cog',
        ),'Acesso' => Array(
            'Nome'                  => 'Acesso',
            'Link'                  => '#',
            'Gravidade'             => 6,
            'Img'                   => 'turboadmin/m-dashboard.png',
            'Icon'                  => 'user',
            'Filhos'                => Array('Grupos'=>Array(
                'Nome'                  => 'Grupos',
                'Link'                  => '_Sistema/Admin/Grupos',
                'Gravidade'             => 1,
                'Img'                   => 'turboadmin/m-dashboard.png',
                'Icon'                  => 'group',
                'Filhos'                => false,
            ))
        ),'Relatórios' => Array(
            'Nome'                  => 'Relatórios',
            'Link'                  => '#',
            'Gravidade'             => 4,
            'Img'                   => 'turboadmin/m-dashboard.png',
            'Icon'                  => 'book',
        ),'Avançado' => Array(
            'Nome'                  => 'Avançado',
            'Link'                  => '#',
            'Gravidade'             => 2,
            'Img'                   => 'turboadmin/m-dashboard.png',
            'Icon'                  => 'wrench',
            'Filhos'                => Array('Menu'=>Array(
                'Nome'                  => 'Menu',
                'Link'                  => '_Sistema/Admin/Menus',
                'Gravidade'             => 1,
                'Img'                   => 'turboadmin/m-dashboard.png',
                'Icon'                  => 'dashboard',
                'Permissao_Func'        => Array(// Permissoes NEcessarias
                    '_Sistema_Avancado' => true
                ),
                'Filhos'                => false,
            ))
        )
    );
};
$config_Permissoes = function (){
    return Array(
        Array(
            'Nome'                  => 'Sistema - Administração Avançada',
            'Desc'                  => '',
            'Chave'                 => '_Sistema_Admin',
            'End'                   => '_Sistema/Admin', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => '_Sistema', // Modulo Referente
            'SubModulo'             => 'Admin',   // Submodulo Referente
            'Metodo'                => '*',  // Metodos referentes separados por virgula
            'Permissao_Func'        => Array(// Permissoes NEcessarias
                '_Sistema_Avancado' => true
            ),
        ),
        
        // Menu
        Array(
            'Nome'                  => 'Sistema (Menu) - Listagem',
            'Desc'                  => '',
            'Chave'                 => '_Sistema_Admin_Menus',
            'End'                   => '_Sistema/Admin/Menus', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => '_Sistema', // Modulo Referente
            'SubModulo'             => 'Admin',   // Submodulo Referente
            'Metodo'                => '*',  // Metodos referentes separados por virgula
            'Permissao_Func'        => Array(// Permissoes NEcessarias
                '_Sistema_Avancado' => true
            ),
        ),
        Array(
            'Nome'                  => 'Sistema (Menu) - Add',
            'Desc'                  => '',
            'Chave'                 => '_Sistema_Admin_Menus_Add', // CHave unica nunca repete, chave primaria
            'End'                   => '_Sistema/Admin/Menus_Add', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => '_Sistema', // Modulo Referente
            'SubModulo'             => 'Admin',   // Submodulo Referente
            'Metodo'                => 'Menus_Add,Menus_Add2',  // Metodos referentes separados por virgula
            'Permissao_Func'        => Array(// Permissoes NEcessarias
                '_Sistema_Avancado' => true
            ),
        ),
        Array(
            'Nome'                  => 'Sistema (Menu) - Editar',
            'Desc'                  => '',
            'Chave'                 => '_Sistema_Admin_Menus_Edit', // CHave unica nunca repete, chave primaria
            'End'                   => '_Sistema/Admin/Menus_Edit', // Endereco que deve conter a url para permitir acesso // Endereco que deve conter a url para permitir acesso
            'Modulo'                => '_Sistema', // Modulo Referente // Modulo Referente
            'SubModulo'             => 'Admin',   // Submodulo Referente   // Submodulo Referente
            'Metodo'                => 'Menus_Edit,Menus_Edit2',  // Metodos referentes separados por virgula
            'Permissao_Func'        => Array(// Permissoes NEcessarias
                '_Sistema_Avancado' => true
            ),
        ),
        Array(
            'Nome'                  => 'Sistema (Menu) - Deletar',
            'Desc'                  => '',
            'Chave'                 => '_Sistema_Admin_Menus_Del', // CHave unica nunca repete, chave primaria
            'End'                   => '_Sistema/Admin/Menus_Del', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => '_Sistema', // Modulo Referente
            'SubModulo'             => 'Admin',   // Submodulo Referente
            'Metodo'                => 'Menus_Del',  // Metodos referentes separados por virgula
            'Permissao_Func'        => Array(// Permissoes NEcessarias
                '_Sistema_Avancado' => true
            ),
        ),
        
        // Newsletter
        Array(
            'Nome'                  => 'Newsletter - Listagem',
            'Desc'                  => '',
            'Chave'                 => '_Sistema_Admin_Newsletter',
            'End'                   => '_Sistema/Admin/Newsletter', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => '_Sistema', // Modulo Referente
            'SubModulo'             => 'Admin',   // Submodulo Referente
            'Metodo'                => '*',  // Metodos referentes separados por virgula
            'Permissao_Func'        => Array(// Permissoes NEcessarias
                '_Sistema_Newsletter' => true
            ),
        ),
        Array(
            'Nome'                  => 'Newsletter - Add',
            'Desc'                  => '',
            'Chave'                 => '_Sistema_Admin_Newsletter_Add', // CHave unica nunca repete, chave primaria
            'End'                   => '_Sistema/Admin/Newsletter_Add', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => '_Sistema', // Modulo Referente
            'SubModulo'             => 'Admin',   // Submodulo Referente
            'Metodo'                => 'Newsletter_Add,Newsletter_Add2',  // Metodos referentes separados por virgula
            'Permissao_Func'        => Array(// Permissoes NEcessarias
                '_Sistema_Newsletter' => true
            ),
        ),
        Array(
            'Nome'                  => 'Newsletter - Editar',
            'Desc'                  => '',
            'Chave'                 => '_Sistema_Admin_Newsletter_Edit', // CHave unica nunca repete, chave primaria
            'End'                   => '_Sistema/Admin/Newsletter_Edit', // Endereco que deve conter a url para permitir acesso // Endereco que deve conter a url para permitir acesso
            'Modulo'                => '_Sistema', // Modulo Referente // Modulo Referente
            'SubModulo'             => 'Admin',   // Submodulo Referente   // Submodulo Referente
            'Metodo'                => 'Newsletter_Edit,Newsletter_Edit2',  // Metodos referentes separados por virgula
            'Permissao_Func'        => Array(// Permissoes NEcessarias
                '_Sistema_Newsletter' => true
            ),
        ),
        Array(
            'Nome'                  => 'Newsletter - Deletar',
            'Desc'                  => '',
            'Chave'                 => '_Sistema_Admin_Newsletter_Del', // CHave unica nunca repete, chave primaria
            'End'                   => '_Sistema/Admin/Newsletter_Del', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => '_Sistema', // Modulo Referente
            'SubModulo'             => 'Admin',   // Submodulo Referente
            'Metodo'                => 'Newsletter_Del',  // Metodos referentes separados por virgula
            'Permissao_Func'        => Array(// Permissoes NEcessarias
                '_Sistema_Newsletter' => true
            ),
        ),
        
        
        // Grupos
        
        Array(
            'Nome'                  => 'Sistema (Grupos) - Listagem',
            'Desc'                  => '',
            'Chave'                 => '_Sistema_Admin_Grupos',
            'End'                   => '_Sistema/Admin/Grupos', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => '_Sistema', // Modulo Referente
            'SubModulo'             => 'Admin',   // Submodulo Referente
            'Metodo'                => '*',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => 'Sistema (Grupos) - Add',
            'Desc'                  => '',
            'Chave'                 => '_Sistema_Admin_Grupos_Add', // CHave unica nunca repete, chave primaria
            'End'                   => '_Sistema/Admin/Grupos_Add', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => '_Sistema', // Modulo Referente
            'SubModulo'             => 'Admin',   // Submodulo Referente
            'Metodo'                => 'Grupos_Add,Grupos_Add2',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => 'Sistema (Grupos) - Editar',
            'Desc'                  => '',
            'Chave'                 => '_Sistema_Admin_Grupos_Edit', // CHave unica nunca repete, chave primaria
            'End'                   => '_Sistema/Admin/Grupos_Edit', // Endereco que deve conter a url para permitir acesso // Endereco que deve conter a url para permitir acesso
            'Modulo'                => '_Sistema', // Modulo Referente // Modulo Referente
            'SubModulo'             => 'Admin',   // Submodulo Referente   // Submodulo Referente
            'Metodo'                => 'Grupos_Edit,Grupos_Edit2',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => 'Sistema (Grupos) - Deletar',
            'Desc'                  => '',
            'Chave'                 => '_Sistema_Admin_Grupos_Del', // CHave unica nunca repete, chave primaria
            'End'                   => '_Sistema/Admin/Grupos_Del', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => '_Sistema', // Modulo Referente
            'SubModulo'             => 'Admin',   // Submodulo Referente
            'Metodo'                => 'Grupos_Del',  // Metodos referentes separados por virgula
        ),
        // PERMISSOES DE GRUPO
        Array(
            'Nome'                  => 'Permissões (Grupo) - Listagem',
            'Desc'                  => '',
            'Chave'                 => '_Sistema_Admin_Grupos', // CHave unica nunca repete, chave primaria
            'End'                   => '_Sistema/Admin/Grupos', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => '_Sistema', // Modulo Referente
            'SubModulo'             => 'Admin',   // Submodulo Referente
            'Metodo'                => 'Grupos',  // Metodos referentes separados por virgula
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
        '_Sistema_Newsletter'  => Array(
            'Nome'                  => 'Sistema -> Newsletter',
            'Desc'                  => 'Se possue Newsletter',
            'chave'                 => '_Sistema_Newsletter',
            'Valor'                 => false,  // false, true, ou array com os grupos que pode
        ),
        '_Sistema_Avancado'  => Array(
            'Nome'                  => 'Sistema -> Avancado',
            'Desc'                  => 'Se possue acesso a parte Avancada do Sistema',
            'chave'                 => '_Sistema_Avancado',
            'Valor'                 => false,  // false, true, ou array com os grupos que pode
        ),
    );
};
?>
