<?php
$config_Modulo = function (){
    return Array(
        'Nome'                      =>  'usuario',
        'Descrição'                 =>  '',
        'System_Require'            =>  '3.1.0',
        'Version'                   =>  '3.1.1',
        'Dependencias'              =>  false,
    );
};
$config_Menu = function (){
    return Array(
        'Lista Telefonica' => Array(
            'Nome'                  => __('Lista Telefonica'),
            'Link'                  => 'usuario/Telefone/Telefones',
            'Gravidade'             => 100,
            'Img'                   => 'turboadmin/m-users.png',
            'Icon'                  => 'phone',
            'Permissao_Func'        => Array(// Permissoes NEcessarias
                'usuario_Telefone_Lista' => true
            ),
            'Filhos'                => false,
        ),
        'Administrar'=>Array(
            'Filhos'                => Array('Usuários'=>Array(
                'Nome'                  => __('Usuários'),
                'Link'                  => 'usuario/Admin/ListarUsuario',
                'Gravidade'             => 9996,
                'Img'                   => 'turboadmin/m-dashboard.png',
                'Icon'                  => 'user',
                'Filhos'                => false,
            ),\Framework\App\Acl::Sistema_Modulos_Configs_Funcional('usuario_Funcionario_nome')=>Array(
                'Nome'                  => \Framework\App\Acl::Sistema_Modulos_Configs_Funcional('usuario_Funcionario_nome'),
                'Link'                  => 'usuario/Admin/ListarFuncionario',
                'Gravidade'             => 9994,
                'Img'                   => 'turboadmin/m-dashboard.png',
                'Icon'                  => 'group',
                'Permissao_Func'        => Array(// Permissoes NEcessarias
                    'usuario_Admin_Funcionario' => true
                ),
                'Filhos'                => false,
            ),\Framework\App\Acl::Sistema_Modulos_Configs_Funcional('usuario_Cliente_nome')=>Array(
                'Nome'                  => \Framework\App\Acl::Sistema_Modulos_Configs_Funcional('usuario_Cliente_nome'),
                'Link'                  => 'usuario/Admin/ListarCliente',
                'Gravidade'             => 9992,
                'Img'                   => 'turboadmin/m-dashboard.png',
                'Icon'                  => 'user',
                'Permissao_Func'        => Array(// Permissoes NEcessarias
                    'usuario_Admin_Cliente' => true
                ),
                'Filhos'                => false,
            )),
        ),'Configurações' => Array(
            'Nome'                  => __('Configurações'),
            'Filhos'                => Array('A. de Usuários'=>Array(
                'Nome'                  => __('A. de Usuários'),
                'Link'                  => 'usuario/Acesso/Listar_Clientesnao',
                'Gravidade'             => 1,
                'Img'                   => 'turboadmin/m-dashboard.png',
                'Icon'                  => 'dashboard',
                'Filhos'                => false,
            ),),
        ),
    );
};
$config_Permissoes = function (){
    return Array(
        
        
        // Grupos
        Array(
            'Nome'                  => __('Sistema - Controle Grupos - Listagem'),
            'Desc'                  => '',
            'Chave'                 => 'usuario_grupo', // CHave unica nunca repete, chave primaria
            'End'                   => 'usuario/grupo', // Endereco que deve conter a url para permitir acesso // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'usuario', // Modulo Referente
            'SubModulo'             => 'grupo',   // Submodulo Referente
            'Metodo'                => '*',  // Metodos referentes separados por virgula
            'Permissao_Func'        => Array(// Permissoes NEcessarias
                'usuario_grupo' => true
            ),
        ),
        // Funcionario
        Array(
            'Nome'                  => \Framework\App\Acl::Sistema_Modulos_Configs_Funcional('usuario_Funcionario_nome').' - Listagem',
            'Desc'                  => '',
            'Chave'                 => 'usuario_Admin_ListarFuncionario', // CHave unica nunca repete, chave primaria
            'End'                   => 'usuario/Admin/ListarFuncionario', // Endereco que deve conter a url para permitir acesso // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'usuario', // Modulo Referente
            'SubModulo'             => 'Admin',   // Submodulo Referente
            'Metodo'                => 'ListarFuncionario',  // Metodos referentes separados por virgula
            'Permissao_Func'        => Array(// Permissoes NEcessarias
                'usuario_Admin_Funcionario' => true
            ),
        ),
        Array(
            'Nome'                  => \Framework\App\Acl::Sistema_Modulos_Configs_Funcional('usuario_Funcionario_nome').' - Add',
            'Desc'                  => '',
            'Chave'                 => 'usuario_Admin_Funcionario_Add', // CHave unica nunca repete, chave primaria
            'End'                   => 'usuario/Admin/Funcionario_Add', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'usuario', // Modulo Referente
            'SubModulo'             => 'Admin',   // Submodulo Referente
            'Metodo'                => 'Funcionario_Add,Funcionario_Add2',  // Metodos referentes separados por virgula
            'Permissao_Func'        => Array(// Permissoes NEcessarias
                'usuario_Admin_Funcionario' => true
            ),
        ),
        Array(
            'Nome'                  => \Framework\App\Acl::Sistema_Modulos_Configs_Funcional('usuario_Funcionario_nome').' - Editar',
            'Desc'                  => '',
            'Chave'                 => 'usuario_Admin_Funcionario_Edit', // CHave unica nunca repete, chave primaria
            'End'                   => 'usuario/Admin/Funcionario_Edit', // Endereco que deve conter a url para permitir acesso // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'usuario', // Modulo Referente // Modulo Referente
            'SubModulo'             => 'Admin',   // Submodulo Referente   // Submodulo Referente
            'Metodo'                => 'Funcionario_Edit,Funcionario_Edit2',  // Metodos referentes separados por virgula
            'Permissao_Func'        => Array(// Permissoes NEcessarias
                'usuario_Admin_Funcionario' => true
            ),
        ),
        Array(
            'Nome'                  => \Framework\App\Acl::Sistema_Modulos_Configs_Funcional('usuario_Funcionario_nome').' - Deletar',
            'Desc'                  => '',
            'Chave'                 => 'usuario_Admin_Funcionario_Del', // CHave unica nunca repete, chave primaria
            'End'                   => 'usuario/Admin/Funcionario_Del', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'usuario', // Modulo Referente
            'SubModulo'             => 'Admin',   // Submodulo Referente
            'Metodo'                => 'Funcionario_Del',  // Metodos referentes separados por virgula
            'Permissao_Func'        => Array(// Permissoes NEcessarias
                'usuario_Admin_Funcionario' => true
            ),
        ),
        
        
        Array(
            'Nome'                  => \Framework\App\Acl::Sistema_Modulos_Configs_Funcional('usuario_Cliente_nome').' - Listagem',
            'Desc'                  => '',
            'Chave'                 => 'usuario_Admin_ListarCliente', // CHave unica nunca repete, chave primaria
            'End'                   => 'usuario/Admin/ListarCliente', // Endereco que deve conter a url para permitir acesso // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'usuario', // Modulo Referente
            'SubModulo'             => 'Admin',   // Submodulo Referente
            'Metodo'                => 'ListarCliente',  // Metodos referentes separados por virgula
            'Permissao_Func'        => Array(// Permissoes NEcessarias
                'usuario_Admin_Cliente' => true
            ),
        ),
        Array(
            'Nome'                  => \Framework\App\Acl::Sistema_Modulos_Configs_Funcional('usuario_Cliente_nome').' - Add',
            'Desc'                  => '',
            'Chave'                 => 'usuario_Admin_Cliente_Add', // CHave unica nunca repete, chave primaria
            'End'                   => 'usuario/Admin/Cliente_Add', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'usuario', // Modulo Referente
            'SubModulo'             => 'Admin',   // Submodulo Referente
            'Metodo'                => 'Cliente_Add,Cliente_Add2',  // Metodos referentes separados por virgula
            'Permissao_Func'        => Array(// Permissoes NEcessarias
                'usuario_Admin_Cliente' => true
            ),
        ),
        Array(
            'Nome'                  => \Framework\App\Acl::Sistema_Modulos_Configs_Funcional('usuario_Cliente_nome').' - Editar',
            'Desc'                  => '',
            'Chave'                 => 'usuario_Admin_Cliente_Edit', // CHave unica nunca repete, chave primaria
            'End'                   => 'usuario/Admin/Cliente_Edit', // Endereco que deve conter a url para permitir acesso // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'usuario', // Modulo Referente // Modulo Referente
            'SubModulo'             => 'Admin',   // Submodulo Referente   // Submodulo Referente
            'Metodo'                => 'Cliente_Edit,Cliente_Edit2',  // Metodos referentes separados por virgula
            'Permissao_Func'        => Array(// Permissoes NEcessarias
                'usuario_Admin_Cliente' => true
            ),
        ),
        Array(
            'Nome'                  => \Framework\App\Acl::Sistema_Modulos_Configs_Funcional('usuario_Cliente_nome').' - Deletar',
            'Desc'                  => '',
            'Chave'                 => 'usuario_Admin_Cliente_Del', // CHave unica nunca repete, chave primaria
            'End'                   => 'usuario/Admin/Cliente_Del', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'usuario', // Modulo Referente
            'SubModulo'             => 'Admin',   // Submodulo Referente
            'Metodo'                => 'Cliente_Del',  // Metodos referentes separados por virgula
            'Permissao_Func'        => Array(// Permissoes NEcessarias
                'usuario_Admin_Cliente' => true
            ),
        ),
        
        
        Array(
            'Nome'                  => __('Usuario - Listagem'),
            'Desc'                  => '',
            'Chave'                 => 'usuario_Admin_ListarUsuario', // CHave unica nunca repete, chave primaria
            'End'                   => 'usuario/Admin/ListarUsuario', // Endereco que deve conter a url para permitir acesso // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'usuario', // Modulo Referente
            'SubModulo'             => 'Admin',   // Submodulo Referente
            'Metodo'                => 'ListarUsuario',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => __('Usuario - Add'),
            'Desc'                  => '',
            'Chave'                 => 'usuario_Admin_Usuarios_Add', // CHave unica nunca repete, chave primaria
            'End'                   => 'usuario/Admin/Usuarios_Add', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'usuario', // Modulo Referente
            'SubModulo'             => 'Admin',   // Submodulo Referente
            'Metodo'                => 'Usuarios_Add,Usuarios_Add2',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => __('Usuario - Editar'),
            'Desc'                  => '',
            'Chave'                 => 'usuario_Admin_Usuarios_Edit', // CHave unica nunca repete, chave primaria
            'End'                   => 'usuario/Admin/Usuarios_Edit', // Endereco que deve conter a url para permitir acesso // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'usuario', // Modulo Referente // Modulo Referente
            'SubModulo'             => 'Admin',   // Submodulo Referente   // Submodulo Referente
            'Metodo'                => 'Usuarios_Edit,Usuarios_Edit2',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => __('Usuario - Deletar'),
            'Desc'                  => '',
            'Chave'                 => 'usuario_Admin_Usuarios_Del', // CHave unica nunca repete, chave primaria
            'End'                   => 'usuario/Admin/Usuarios_Del', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'usuario', // Modulo Referente
            'SubModulo'             => 'Admin',   // Submodulo Referente
            'Metodo'                => 'Usuarios_Del',  // Metodos referentes separados por virgula
        ),
        
        // PERMISSOES DE USUARIO
        Array(
            'Nome'                  => __('Permissões (Usuário) - Listagem'),
            'Desc'                  => '',
            'Chave'                 => 'usuario_Acesso', // CHave unica nunca repete, chave primaria
            'End'                   => 'usuario/Acesso', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'usuario', // Modulo Referente
            'SubModulo'             => 'Acesso',   // Submodulo Referente
            'Metodo'                => '*',  // Metodos referentes separados por virgula
        ),
        
        
        
        Array(
            'Nome'                  => __('Telefone - Listagem'),
            'Desc'                  => '',
            'Chave'                 => 'usuario_Telefone_Telefones', // CHave unica nunca repete, chave primaria
            'End'                   => 'usuario/Telefone/Telefones', // Endereco que deve conter a url para permitir acesso // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'usuario', // Modulo Referente
            'SubModulo'             => 'Telefone',   // Submodulo Referente
            'Metodo'                => 'Telefones',  // Metodos referentes separados por virgula
            'Permissao_Func'        => Array(// Permissoes NEcessarias
                'usuario_Telefone_Lista' => true
            ),
        ),
        Array(
            'Nome'                  => __('Telefone - Add'),
            'Desc'                  => '',
            'Chave'                 => 'usuario_Telefone_Telefones_Add', // CHave unica nunca repete, chave primaria
            'End'                   => 'usuario/Telefone/Telefones_Add', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'usuario', // Modulo Referente
            'SubModulo'             => 'Telefone',   // Submodulo Referente
            'Metodo'                => 'Telefones_Add,Telefones_Add2',  // Metodos referentes separados por virgula
            'Permissao_Func'        => Array(// Permissoes NEcessarias
                'usuario_Telefone_Lista' => true
            ),
        ),
        Array(
            'Nome'                  => __('Telefone - Editar'),
            'Desc'                  => '',
            'Chave'                 => 'usuario_Telefone_Telefones_Edit', // CHave unica nunca repete, chave primaria
            'End'                   => 'usuario/Telefone/Telefones_Edit', // Endereco que deve conter a url para permitir acesso // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'usuario', // Modulo Referente // Modulo Referente
            'SubModulo'             => 'Telefone',   // Submodulo Referente   // Submodulo Referente
            'Metodo'                => 'Telefones_Edit,Telefones_Edit2',  // Metodos referentes separados por virgula
            'Permissao_Func'        => Array(// Permissoes NEcessarias
                'usuario_Telefone_Lista' => true
            ),
        ),
        Array(
            'Nome'                  => __('Telefone - Deletar'),
            'Desc'                  => '',
            'Chave'                 => 'usuario_Telefone_Telefones_Del', // CHave unica nunca repete, chave primaria
            'End'                   => 'usuario/Telefone/Telefones_Del', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'usuario', // Modulo Referente
            'SubModulo'             => 'Telefone',   // Submodulo Referente
            'Metodo'                => 'Telefones_Del',  // Metodos referentes separados por virgula
            'Permissao_Func'        => Array(// Permissoes NEcessarias
                'usuario_Telefone_Lista' => true
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
$config_Funcional = function (){
    return Array(
        'usuario_grupo'  => Array(
            'Nome'                  => 'Grupos -> Se Mostra Opções de Grupos',
            'Desc'                  => __('Se Mostra Opções de Grupos'),
            'chave'                 => 'usuario_grupo',
            'Valor'                 => false,  // false, true, ou array com os grupos que pode
        ),
        'usuario_usuarios_showconfig'  => Array(
            'Nome'                  => 'Usuarios -> Ocultar Grupos',
            'Desc'                  => __('Se verdadeiro mostra so os clientes ativos'),
            'chave'                 => 'usuario_usuarios_showconfig',
            'Valor'                 => false,  // false, true, ou array com os grupos que pode
        ),
        'usuario_Grupo_Mostrar'  => Array(
            'Nome'                  => 'Usuarios -> Ocultar Grupos',
            'Desc'                  => __('Aonde mostra adição de grupos'),
            'chave'                 => 'usuario_Grupo_Mostrar',
            'Valor'                 => true,  // false, true, ou array com os grupos que pode
        ),
        // Grupos que tem login/senha
        'usuario_Login'  => Array(
            'Nome'                  => 'Usuarios -> Login',
            'Desc'                  => __('Se possue login em Usuarios'),
            'chave'                 => 'usuario_Login',
            'Valor'                 => true,  // false, true, ou array com as categorias de grupos que podem
        ),
        'usuario_Anexo'  => Array(
            'Nome'                  => 'Usuarios -> Anexo',
            'Desc'                  => __('Se possue Anexo em Usuarios'),
            'chave'                 => 'usuario_Anexo',
            'Valor'                 => false,
        ),
        'usuario_Admin_Site'  => Array(
            'Nome'                  => 'Usuarios -> Site',
            'Desc'                  => __('Se possue Site em Usuarios'),
            'chave'                 => 'usuario_Admin_Site',
            'Valor'                 => true,
        ),
        'usuario_Admin_Ativado'  => Array(
            'Nome'                  => 'Usuarios -> Status',
            'Desc'                  => __('Se possue Status em Usuarios (Ativado)'),
            'chave'                 => 'usuario_Admin_Ativado',
            'Valor'                 => true,
        ),
        'usuario_Admin_Ativado_Listar'  => Array(
            'Nome'                  => 'Usuarios -> Status Listagem',
            'Desc'                  => __('Se mostra na listagem o Status'),
            'chave'                 => 'usuario_Admin_Ativado_Listar',
            'Valor'                 => false,
        ),
        'usuario_Admin_Foto'  => Array(
            'Nome'                  => 'Usuarios -> Foto',
            'Desc'                  => __('Se possue Foto em Usuarios'),
            'chave'                 => 'usuario_Admin_Foto',
            'Valor'                 => true,  // false, true, ou array com os grupos que pode
        ),
        'usuario_Admin_Email'  => Array(
            'Nome'                  => 'Usuarios -> Email',
            'Desc'                  => __('Enviar Email Direto Entre Usuarios'),
            'chave'                 => 'usuario_Admin_Email',
            'Valor'                 => false,
        ),
        'usuario_Admin_EmailUnico'  => Array(
            'Nome'                  => 'Usuarios -> Email Unico',
            'Desc'                  => __('Se email nao puder repetir, vem como true'),
            'chave'                 => 'usuario_Admin_EmailUnico',
            'Valor'                 => true,
        ),
        'usuario_Principal_Widgets'  => Array(
            'Nome'                  => 'Usuarios -> Se mostra widget',
            'Desc'                  => __('Se mostra widgetna pagina inicial'),
            'chave'                 => 'usuario_Principal_Widgets',
            'Valor'                 => true,
        ),
        
        // Funcionario
        'usuario_Admin_Funcionario'  => Array(
            'Nome'                  => 'Usuarios -> Funcionarios',
            'Desc'                  => __('Se possui Funcionarios'),
            'chave'                 => 'usuario_Admin_Funcionario',
            'Valor'                 => true,
        ),
        'usuario_Funcionario_nome'  => Array(
            'Nome'                  => 'Usuarios -> Funcionarios',
            'Desc'                  => __('Nome Funcionarios'),
            'chave'                 => 'usuario_Funcionario_nome',
            'Valor'                 => 'Funcionários',
        ),
        
        // Cliente
        'usuario_Admin_Cliente'  => Array(
            'Nome'                  => 'Usuarios -> Funcionarios',
            'Desc'                  => __('Se possui Clientes'),
            'chave'                 => 'usuario_Admin_Cliente',
            'Valor'                 => true,
        ),
        'usuario_Cliente_nome'  => Array(
            'Nome'                  => 'Usuarios -> Nome do Cliente',
            'Desc'                  => __('Nome do Cliente'),
            'chave'                 => 'usuario_Cliente_nome',
            'Valor'                 => 'Clientes',
        ),
        'usuario_Cliente_PrecoDiferenciado'  => Array(
            'Nome'                  => 'Usuarios Cliente -> PrecoDiferenciado',
            'Desc'                  => __('Opcao preço normal ou diferenciado'),
            'chave'                 => 'usuario_Cliente_PrecoDiferenciado',
            'Valor'                 => false,
        ),
        'usuario_Comentarios'  => Array(
            'Nome'                  => 'Usuarios -> Comentarios',
            'Desc'                  => __('Se tem historico de comentarios em usuarios'),
            'chave'                 => 'usuario_Comentarios',
            'Valor'                 => false,
        ),
        'usuario_Telefone_Lista'  => Array(
            'Nome'                  => 'Telefone -> Listagem',
            'Desc'                  => __('Se possui listagem de telefones'),
            'chave'                 => 'usuario_Telefone_Lista',
            'Valor'                 => false,
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
