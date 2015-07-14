<?php
$config_Modulo = function (){
    return Array(
        'Nome'                      =>  'Locomocao',
        'Descrição'                 =>  '',
        'System_Require'            =>  '3.1.0',
        'Version'                   =>  '3.1.1',
        'Dependencias'              =>  false,
    );
};
$config_Menu = function (){
    return Array(
        'Página Inicial' => Array(
            'Nome'                  => __('Página Inicial'),
            'Link'                  => 'Locomocao/Principal/Home',
            'Gravidade'             => 10000,
            'Img'                   => 'turboadmin/m-dashboard.png',
            'Icon'                  => 'dashboard',
            'Filhos'                => false,
        ),'Cadastros' => Array(
            'Nome'                  => __('Cadastros'),
            'Link'                  => '#',
            'Gravidade'             => 10,
            'Img'                   => 'turboadmin/m-dashboard.png',
            'Icon'                  => 'cog',
        ),'Administrar' => Array(
            'Nome'                  => __('Administrar'),
            'Link'                  => '#',
            'Gravidade'             => 8,
            'Img'                   => '',
            'Icon'                  => 'building',
        ),'Configurações' => Array(
            'Nome'                  => __('Configurações'),
            'Link'                  => '#',
            'Gravidade'             => 6,
            'Img'                   => 'turboadmin/m-dashboard.png',
            'Icon'                  => 'wrench',
            'Filhos'                => Array('Grupos'=>Array(
                'Nome'                  => __('Grupos'),
                'Link'                  => 'Locomocao/Admin/Grupos',
                'Gravidade'             => 5,
                'Img'                   => 'turboadmin/m-dashboard.png',
                'Icon'                  => 'group',
                'Filhos'                => false,
            ),'Menus'=>Array(
                'Nome'                  => __('Menus'),
                'Link'                  => 'Locomocao/Admin/Menus',
                'Gravidade'             => 3,
                'Img'                   => 'turboadmin/m-dashboard.png',
                'Icon'                  => 'dashboard',
                'Permissao_Func'        => Array(// Permissoes NEcessarias
                    'Locomocao_Avancado' => true
                ),
                'Filhos'                => false,
            ),'Configurações'=>Array(
                'Nome'                  => __('Configurações'),
                'Link'                  => 'Locomocao/Admin/Configs',
                'Gravidade'             => 1,
                'Img'                   => 'turboadmin/m-dashboard.png',
                'Icon'                  => 'dashboard',
                'Permissao_Func'        => Array(// Permissoes NEcessarias
                    'Locomocao_Avancado' => true
                ),
                'Filhos'                => false,
            ))
        ),'Relatório' => Array(
            'Nome'                  => __('Relatório'),
            'Link'                  => '#',
            'Gravidade'             => 4,
            'Img'                   => 'turboadmin/m-dashboard.png',
            'Icon'                  => 'book',
        ),'Gráfico' => Array(
            'Nome'                  => __('Gráfico'),
            'Link'                  => '#',
            'Gravidade'             => 3,
            'Img'                   => 'turboadmin/m-dashboard.png',
            'Icon'                  => 'book',
        )
    );
};
$config_Permissoes = function (){
    return Array(
        Array(
            'Nome'                  => __('Sistema - Administração Avançada'),
            'Desc'                  => '',
            'Chave'                 => 'Locomocao_Admin',
            'End'                   => 'Locomocao/Admin', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Locomocao', // Modulo Referente
            'SubModulo'             => 'Admin',   // Submodulo Referente
            'Metodo'                => '*',  // Metodos referentes separados por virgula
            'Permissao_Func'        => Array(// Permissoes NEcessarias
                'Locomocao_Avancado' => true
            ),
        ),
        
        // Menu
        Array(
            'Nome'                  => __('Sistema (Menu) - Listagem'),
            'Desc'                  => '',
            'Chave'                 => 'Locomocao_Admin_Menus',
            'End'                   => 'Locomocao/Admin/Menus', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Locomocao', // Modulo Referente
            'SubModulo'             => 'Admin',   // Submodulo Referente
            'Metodo'                => 'Menus',  // Metodos referentes separados por virgula
            'Permissao_Func'        => Array(// Permissoes NEcessarias
                'Locomocao_Avancado' => true
            ),
        ),
        Array(
            'Nome'                  => __('Sistema (Menu) - Add'),
            'Desc'                  => '',
            'Chave'                 => 'Locomocao_Admin_Menus_Add', // CHave unica nunca repete, chave primaria
            'End'                   => 'Locomocao/Admin/Menus_Add', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Locomocao', // Modulo Referente
            'SubModulo'             => 'Admin',   // Submodulo Referente
            'Metodo'                => 'Menus_Add,Menus_Add2',  // Metodos referentes separados por virgula
            'Permissao_Func'        => Array(// Permissoes NEcessarias
                'Locomocao_Avancado' => true
            ),
        ), 
        Array(
            'Nome'                  => __('Sistema (Menu) - Add'),
            'Desc'                  => '',
            'Chave'                 => 'Locomocao_Admin_Menus_Add', // CHave unica nunca repete, chave primaria
            'End'                   => 'Locomocao/Admin/Menus_Add', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Locomocao', // Modulo Referente
            'SubModulo'             => 'Admin',   // Submodulo Referente
            'Metodo'                => 'Menus_Add,Menus_Add2',  // Metodos referentes separados por virgula
            'Permissao_Func'        => Array(// Permissoes NEcessarias
                'Locomocao_Avancado' => true
            ),
        ),
        Array(
            'Nome'                  => __('Sistema (Menu) - Editar'),
            'Desc'                  => '',
            'Chave'                 => 'Locomocao_Admin_Menus_Edit', // CHave unica nunca repete, chave primaria
            'End'                   => 'Locomocao/Admin/Menus_Edit', // Endereco que deve conter a url para permitir acesso // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Locomocao', // Modulo Referente // Modulo Referente
            'SubModulo'             => 'Admin',   // Submodulo Referente   // Submodulo Referente
            'Metodo'                => 'Menus_Edit,Menus_Edit2',  // Metodos referentes separados por virgula
            'Permissao_Func'        => Array(// Permissoes NEcessarias
                'Locomocao_Avancado' => true
            ),
        ),
        Array(
            'Nome'                  => __('Sistema (Menu) - Deletar'),
            'Desc'                  => '',
            'Chave'                 => 'Locomocao_Admin_Menus_Del', // CHave unica nunca repete, chave primaria
            'End'                   => 'Locomocao/Admin/Menus_Del', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Locomocao', // Modulo Referente
            'SubModulo'             => 'Admin',   // Submodulo Referente
            'Metodo'                => 'Menus_Del',  // Metodos referentes separados por virgula
            'Permissao_Func'        => Array(// Permissoes NEcessarias
                'Locomocao_Avancado' => true
            ),
        ),
        
        // Configuração Publica
        Array(
            'Nome'                  => __('Sistema (Configuração) - Listagem'),
            'Desc'                  => '',
            'Chave'                 => 'Locomocao_Admin_Configs',
            'End'                   => 'Locomocao/Admin/Configs', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Locomocao', // Modulo Referente
            'SubModulo'             => 'Admin',   // Submodulo Referente
            'Metodo'                => 'Configs',  // Metodos referentes separados por virgula
            'Permissao_Func'        => Array(// Permissoes NEcessarias
                'Locomocao_Avancado' => true
            ),
        ),
        Array(
            'Nome'                  => __('Sistema (Configuração) - Editar'),
            'Desc'                  => '',
            'Chave'                 => 'Locomocao_Admin_Configs_Edit', // CHave unica nunca repete, chave primaria
            'End'                   => 'Locomocao/Admin/Configs_Edit', // Endereco que deve conter a url para permitir acesso // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Locomocao', // Modulo Referente // Modulo Referente
            'SubModulo'             => 'Admin',   // Submodulo Referente   // Submodulo Referente
            'Metodo'                => 'Configs_Edit,Configs_Edit2',  // Metodos referentes separados por virgula
            'Permissao_Func'        => Array(// Permissoes NEcessarias
                'Locomocao_Avancado' => true
            ),
        ),
        
        // Newsletter
        Array(
            'Nome'                  => __('Newsletter - Listagem'),
            'Desc'                  => '',
            'Chave'                 => 'Locomocao_Admin_Newsletter',
            'End'                   => 'Locomocao/Admin/Newsletter', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Locomocao', // Modulo Referente
            'SubModulo'             => 'Admin',   // Submodulo Referente
            'Metodo'                => 'Newsletter',  // Metodos referentes separados por virgula
            'Permissao_Func'        => Array(// Permissoes NEcessarias
                'Locomocao_Newsletter' => true
            ),
        ),
        Array(
            'Nome'                  => __('Newsletter - Add'),
            'Desc'                  => '',
            'Chave'                 => 'Locomocao_Admin_Newsletter_Add', // CHave unica nunca repete, chave primaria
            'End'                   => 'Locomocao/Admin/Newsletter_Add', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Locomocao', // Modulo Referente
            'SubModulo'             => 'Admin',   // Submodulo Referente
            'Metodo'                => 'Newsletter_Add,Newsletter_Add2',  // Metodos referentes separados por virgula
            'Permissao_Func'        => Array(// Permissoes NEcessarias
                'Locomocao_Newsletter' => true
            ),
        ),
        Array(
            'Nome'                  => __('Newsletter - Editar'),
            'Desc'                  => '',
            'Chave'                 => 'Locomocao_Admin_Newsletter_Edit', // CHave unica nunca repete, chave primaria
            'End'                   => 'Locomocao/Admin/Newsletter_Edit', // Endereco que deve conter a url para permitir acesso // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Locomocao', // Modulo Referente // Modulo Referente
            'SubModulo'             => 'Admin',   // Submodulo Referente   // Submodulo Referente
            'Metodo'                => 'Newsletter_Edit,Newsletter_Edit2',  // Metodos referentes separados por virgula
            'Permissao_Func'        => Array(// Permissoes NEcessarias
                'Locomocao_Newsletter' => true
            ),
        ),
        Array(
            'Nome'                  => __('Newsletter - Deletar'),
            'Desc'                  => '',
            'Chave'                 => 'Locomocao_Admin_Newsletter_Del', // CHave unica nunca repete, chave primaria
            'End'                   => 'Locomocao/Admin/Newsletter_Del', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Locomocao', // Modulo Referente
            'SubModulo'             => 'Admin',   // Submodulo Referente
            'Metodo'                => 'Newsletter_Del',  // Metodos referentes separados por virgula
            'Permissao_Func'        => Array(// Permissoes NEcessarias
                'Locomocao_Newsletter' => true
            ),
        ),
        
        
        // Grupos
        
        Array(
            'Nome'                  => __('Sistema (Grupos) - Listagem'),
            'Desc'                  => '',
            'Chave'                 => 'Locomocao_Admin_Grupos',
            'End'                   => 'Locomocao/Admin/Grupos', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Locomocao', // Modulo Referente
            'SubModulo'             => 'Admin',   // Submodulo Referente
            'Metodo'                => 'Grupos',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => __('Sistema (Grupos) - Add'),
            'Desc'                  => '',
            'Chave'                 => 'Locomocao_Admin_Grupos_Add', // CHave unica nunca repete, chave primaria
            'End'                   => 'Locomocao/Admin/Grupos_Add', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Locomocao', // Modulo Referente
            'SubModulo'             => 'Admin',   // Submodulo Referente
            'Metodo'                => 'Grupos_Add,Grupos_Add2',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => __('Sistema (Grupos) - Editar'),
            'Desc'                  => '',
            'Chave'                 => 'Locomocao_Admin_Grupos_Edit', // CHave unica nunca repete, chave primaria
            'End'                   => 'Locomocao/Admin/Grupos_Edit', // Endereco que deve conter a url para permitir acesso // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Locomocao', // Modulo Referente // Modulo Referente
            'SubModulo'             => 'Admin',   // Submodulo Referente   // Submodulo Referente
            'Metodo'                => 'Grupos_Edit,Grupos_Edit2',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => __('Sistema (Grupos) - Deletar'),
            'Desc'                  => '',
            'Chave'                 => 'Locomocao_Admin_Grupos_Del', // CHave unica nunca repete, chave primaria
            'End'                   => 'Locomocao/Admin/Grupos_Del', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Locomocao', // Modulo Referente
            'SubModulo'             => 'Admin',   // Submodulo Referente
            'Metodo'                => 'Grupos_Del',  // Metodos referentes separados por virgula
        ),
        // PERMISSOES DE GRUPO
        Array(
            'Nome'                  => __('Permissões (Grupo) - Listagem'),
            'Desc'                  => '',
            'Chave'                 => 'Locomocao_Admin_Grupos', // CHave unica nunca repete, chave primaria
            'End'                   => 'Locomocao/Admin/Grupos', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Locomocao', // Modulo Referente
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
        'Locomocao_Newsletter'  => Array(
            'Nome'                  => 'Sistema -> Newsletter',
            'Desc'                  => __('Se possue Newsletter'),
            'chave'                 => 'Locomocao_Newsletter',
            'Valor'                 => false,  // false, true, ou array com os grupos que pode
        ),
        'Locomocao_Avancado'  => Array(
            'Nome'                  => 'Sistema -> Avancado',
            'Desc'                  => __('Se Carrega ou nao Permissao em Avancado e se aparece no menu'),
            'chave'                 => 'Locomocao_Avancado',
            'Valor'                 => true,  // false, true, ou array com os grupos que pode
        ),
    );
};
/**
 * Configurações que podem ser Alteradas por Admin ou outros usuarios do Sistema (Parametros Opcionais: Mascara e Max
 * @return type
 * 
 * @author Ricardo Sierra <web@ricardosierra.com.br>
 */
$config_Publico = function (){
    return Array(
        /*'{chave}'  => Array(
            'Nome'                  => 'Nome',
            'Desc'                  => __('Descricao'),
            'chave'                 => '{chave}',
            'Valor'                 => 'valor_padrao'
        )*/
    );
};
?>
