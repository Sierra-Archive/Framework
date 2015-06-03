<?php
$config_Modulo = function (){
    return Array(
        'Nome'                      =>  'usuario_mensagem',
        'Descrição'                 =>  'É um modulo para Atendimento telefonico de grandes empresas',
        'System_Require'            =>  '3.1.0',
        'Version'                   =>  '0.1.0',
        'Dependencias'              =>  false,
    );
};
$config_Menu = function (){
    return Array(
        'Relatório' => Array(
            'Filhos'                => Array('Chamados'=>Array(
                'Nome'                  => 'Chamados',
                'Link'                  => 'usuario_mensagem/Relatorio/Relatorio',
                'Gravidade'             => 5,
                'Img'                   => 'envelope',
                'Icon'                  => 'envelope',
                'Filhos'                => false,
            ),),
        ),
        'Suporte' => Array(
            'Nome'                  => 'Suporte',
            'Link'                  => '#',
            'Gravidade'             => 12,
            'Img'                   => 'turboadmin/m-dashboard.png',
            'Icon'                  => '',
            'Filhos'                => Array(
            'Suporte' => Array(
                'Nome'                  => 'Tickets',
                'Link'                  => 'usuario_mensagem/Suporte/Mensagens',
                'Gravidade'             => 70,
                'Img'                   => 'menusuperior/ticket.png',
                'Icon'                  => 'envelope',
                'Filhos'                => false,
            ),'Setores'=>Array(
                'Nome'                  => 'Setores',
                'Link'                  => 'usuario_mensagem/Setor/Main',
                'Gravidade'             => 68,
                'Img'                   => 'turboadmin/m-dashboard.png',
                'Icon'                  => 'smile',
                'Filhos'                => false,
            ),'Assuntos'=>Array(
                'Nome'                  => 'Assuntos',
                'Link'                  => 'usuario_mensagem/Assunto/Mensagens',
                'Gravidade'             => 67,
                'Img'                   => 'turboadmin/m-dashboard.png',
                'Icon'                  => 'shopping-cart',
                'Filhos'                => false,
            ),),
        ),
    );
};
$config_Permissoes = function (){
    return Array(        
        Array(
            'Nome'                  => 'Mensagens (Suporte) - Listagem',
            'Desc'                  => '',
            'Chave'                 => 'usuario_mensagem_Suporte_Mensagens',
            'End'                   => 'usuario_mensagem/Suporte/Mensagens', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'usuario_mensagem', // Modulo Referente
            'SubModulo'             => 'Admin',   // Submodulo Referente
            'Metodo'                => 'Mensagens',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => 'Mensagens (Suporte) - Editar Suportes',
            'Desc'                  => '',
            'Chave'                 => 'usuario_mensagem_Admin_Mensagem_Editar', // CHave unica nunca repete, chave primaria
            'End'                   => 'usuario_mensagem/Admin/Mensagem_Editar', // Endereco que deve conter a url para permitir acesso // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'usuario_mensagem', // Modulo Referente // Modulo Referente
            'SubModulo'             => 'Admin',   // Submodulo Referente   // Submodulo Referente
            'Metodo'                => 'Mensagem_Editar,Mensagem_Editar2',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => 'Mensagens (Suporte) - Deletar Suportes',
            'Desc'                  => '',
            'Chave'                 => 'usuario_mensagem_Admin_Mensagem_Del', // CHave unica nunca repete, chave primaria
            'End'                   => 'usuario_mensagem/Admin/Mensagem_Del', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'usuario_mensagem', // Modulo Referente
            'SubModulo'             => 'Admin',   // Submodulo Referente
            'Metodo'                => 'Mensagem_Del',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => 'Mensagens (Suporte) - Visualizar Suportes',
            'Desc'                  => '',
            'Chave'                 => 'usuario_mensagem_Suporte_VisualizadordeMensagem',
            'End'                   => 'usuario_mensagem/Suporte/VisualizadordeMensagem', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'usuario_mensagem', // Modulo Referente
            'SubModulo'             => 'Suporte',   // Submodulo Referente
            'Metodo'                => 'VisualizadordeMensagem',  // Metodos referentes separados por virgula
        ),
        
        Array(
            'Nome'                  => 'Mensagens (Assuntos) - Listagem',
            'Desc'                  => '',
            'Chave'                 => 'usuario_mensagem_Assunto_Assuntos',
            'End'                   => 'usuario_mensagem/Assunto/Assuntos', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'usuario_mensagem', // Modulo Referente
            'SubModulo'             => 'Assunto',   // Submodulo Referente
            'Metodo'                => 'Assuntos',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => 'Mensagens (Assuntos) - Add',
            'Desc'                  => '',
            'Chave'                 => 'usuario_mensagem_Assunto_Assuntos_Add', // CHave unica nunca repete, chave primaria
            'End'                   => 'usuario_mensagem/Assunto/Assuntos_Add', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'usuario_mensagem', // Modulo Referente
            'SubModulo'             => 'Assunto',   // Submodulo Referente
            'Metodo'                => 'Assuntos_Add,Assuntos_Add2',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => 'Mensagens (Assuntos) - Editar',
            'Desc'                  => '',
            'Chave'                 => 'usuario_mensagem_Assunto_Assuntos_Edit', // CHave unica nunca repete, chave primaria
            'End'                   => 'usuario_mensagem/Assunto/Assuntos_Edit', // Endereco que deve conter a url para permitir acesso // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'usuario_mensagem', // Modulo Referente // Modulo Referente
            'SubModulo'             => 'Assunto',   // Submodulo Referente   // Submodulo Referente
            'Metodo'                => 'Assuntos_Edit,Assuntos_Edit2',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => 'Mensagens (Assuntos) - Deletar',
            'Desc'                  => '',
            'Chave'                 => 'usuario_mensagem_Assunto_Assuntos_Del', // CHave unica nunca repete, chave primaria
            'End'                   => 'usuario_mensagem/Assunto/Assuntos_Del', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'usuario_mensagem', // Modulo Referente
            'SubModulo'             => 'Assunto',   // Submodulo Referente
            'Metodo'                => 'Assuntos_Del',  // Metodos referentes separados por virgula
        ),
        
        Array(
            'Nome'                  => 'Mensagens (Setores) - Listagem',
            'Desc'                  => '',
            'Chave'                 => 'usuario_mensagem_Setor_Setores',
            'End'                   => 'usuario_mensagem/Setor/Setores', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'usuario_mensagem', // Modulo Referente
            'SubModulo'             => 'Setor',   // Submodulo Referente
            'Metodo'                => 'Setores',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => 'Mensagens (Setores) - Add',
            'Desc'                  => '',
            'Chave'                 => 'usuario_mensagem_Setor_Setores_Add', // CHave unica nunca repete, chave primaria
            'End'                   => 'usuario_mensagem/Setor/Setores_Add', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'usuario_mensagem', // Modulo Referente
            'SubModulo'             => 'Setor',   // Submodulo Referente
            'Metodo'                => 'Setores_Add,Setores_Add2',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => 'Mensagens (Setores) - Editar',
            'Desc'                  => '',
            'Chave'                 => 'usuario_mensagem_Setor_Setores_Edit', // CHave unica nunca repete, chave primaria
            'End'                   => 'usuario_mensagem/Setor/Setores_Edit', // Endereco que deve conter a url para permitir acesso // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'usuario_mensagem', // Modulo Referente // Modulo Referente
            'SubModulo'             => 'Setor',   // Submodulo Referente   // Submodulo Referente
            'Metodo'                => 'Setores_Edit,Setores_Edit2',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => 'Mensagens (Setores) - Deletar',
            'Desc'                  => '',
            'Chave'                 => 'usuario_mensagem_Setor_Setores_Del', // CHave unica nunca repete, chave primaria
            'End'                   => 'usuario_mensagem/Setor/Setores_Del', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'usuario_mensagem', // Modulo Referente
            'SubModulo'             => 'Setor',   // Submodulo Referente
            'Metodo'                => 'Setores_Del',  // Metodos referentes separados por virgula
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
        'usuario_mensagem_EmailSetor'  => Array(
            'Nome'                  => 'Usuarios -> Email  Setor',
            'Desc'                  => 'Enviar Email para setor',
            'chave'                 => 'usuario_mensagem_EmailSetor',
            'Valor'                 => false,
        ),
        'usuario_mensagem_Obs'  => Array(
            'Nome'                  => 'Usuarios Mensagens -> Observacao como mensagem',
            'Desc'                  => 'Se observação conta como mensagem',
            'chave'                 => 'usuario_mensagem_Obs',
            'Valor'                 => false,
        )
    );
};
?>
