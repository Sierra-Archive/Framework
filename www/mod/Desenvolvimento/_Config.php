<?php
$config_Modulo = function (){
    return Array(
        'Nome'                      =>  'Desenvolvimento',
        'Descrição'                 =>  'Modulo desenvolvido para Desenvolvimentos',
        'System_Require'            =>  '3.1.0',
        'Version'                   =>  '3.1.1',
        'Dependencias'              =>  false,
    );
};
$config_Menu = function (){
    return Array(
        'Dev'=>Array(
            'Nome'                  => __('Dev'),
            'Link'                  => '#',
            'Gravidade'             => 30,
            'Img'                   => 'turboadmin/m-dashboard.png',
            'Icon'                  => 'list-alt',
            'Filhos'                => Array('Projetos'=>Array(
                'Nome'                  => __('Projetos'),
                'Link'                  => 'Desenvolvimento/Projeto/Projetos',
                'Gravidade'             => 50,
                'Img'                   => 'turboadmin/m-users.png',
                'Icon'                  => 'list-alt',
                'Filhos'                => false,
            ),'Tarefas'=>Array(
                'Nome'                  => __('Tarefas'),
                'Link'                  => 'Desenvolvimento/Tarefa/Tarefas',
                'Gravidade'             => 40,
                'Img'                   => 'turboadmin/m-users.png',
                'Icon'                  => 'list-alt',
                'Filhos'                => false,
            ),'Fram. Módulos'=>Array(
                'Nome'                  => __('Fram. Módulos'),
                'Link'                  => 'Desenvolvimento/Framework/Modulos',
                'Gravidade'             => 30,
                'Img'                   => 'turboadmin/m-users.png',
                'Icon'                  => 'list-alt',
                'Filhos'                => false,
            ),'Fram. Módulos'=>Array(
                'Nome'                  => __('Fram. SubMódulos'),
                'Link'                  => 'Desenvolvimento/Framework/Submodulos',
                'Gravidade'             => 20,
                'Img'                   => 'turboadmin/m-users.png',
                'Icon'                  => 'list-alt',
                'Filhos'                => false,
            ),'Fram. Módulos'=>Array(
                'Nome'                  => __('Fram. Metodos'),
                'Link'                  => 'Desenvolvimento/Framework/Metodos',
                'Gravidade'             => 10,
                'Img'                   => 'turboadmin/m-users.png',
                'Icon'                  => 'list-alt',
                'Filhos'                => false,
            ),'M. Senhas'=>Array(
                'Nome'                  => __('M. Senhas'),
                'Link'                  => 'Desenvolvimento/Senha/Senhas',
                'Gravidade'             => 80,
                'Img'                   => 'turboadmin/m-users.png',
                'Icon'                  => 'list-alt',
                'Filhos'                => false,
            ),'T. Senhas'=>Array(
                'Nome'                  => __('T. Senhas'),
                'Link'                  => 'Desenvolvimento/Senha/Senhas_Todas',
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
            'Nome'                  => __('Desenvolvimento (Minhas Senhas) - Listagem'),
            'Desc'                  => '',
            'Chave'                 => 'Desenvolvimento_Senha_Senhas',
            'End'                   => 'Desenvolvimento/Senha/Senhas', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Desenvolvimento', // Modulo Referente
            'SubModulo'             => 'Senha',   // Submodulo Referente
            'Metodo'                => 'Senhas',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => __('Desenvolvimento (Minhas Senhas) - Add'),
            'Desc'                  => '',
            'Chave'                 => 'Desenvolvimento_Senha_Senhas_Add', // CHave unica nunca repete, chave primaria
            'End'                   => 'Desenvolvimento/Senha/Senhas_Add', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Desenvolvimento', // Modulo Referente
            'SubModulo'             => 'Senha',   // Submodulo Referente
            'Metodo'                => 'Senhas_Add,Senhas_Add2',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => __('Desenvolvimento (Minhas Senhas) - Editar'),
            'Desc'                  => '',
            'Chave'                 => 'Desenvolvimento_Senha_Senhas_Edit', // CHave unica nunca repete, chave primaria
            'End'                   => 'Desenvolvimento/Senha/Senhas_Edit', // Endereco que deve conter a url para permitir acesso // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Desenvolvimento', // Modulo Referente // Modulo Referente
            'SubModulo'             => 'Senha',   // Submodulo Referente   // Submodulo Referente
            'Metodo'                => 'Senhas_Edit,Senhas_Edit2',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => __('Desenvolvimento (Minhas Senhas) - Deletar'),
            'Desc'                  => '',
            'Chave'                 => 'Desenvolvimento_Senha_Senhas_Del', // CHave unica nunca repete, chave primaria
            'End'                   => 'Desenvolvimento/Senha/Senhas_Del', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Desenvolvimento', // Modulo Referente
            'SubModulo'             => 'Senha',   // Submodulo Referente
            'Metodo'                => 'Senhas_Del',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => __('Desenvolvimento (Minhas Senhas) - Status Alterar'),
            'Desc'                  => '',
            'Chave'                 => 'Desenvolvimento_Senha_Status', // CHave unica nunca repete, chave primaria
            'End'                   => 'Desenvolvimento/Senha/Status', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Desenvolvimento', // Modulo Referente
            'SubModulo'             => 'Senha',   // Submodulo Referente
            'Metodo'                => 'Status',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => __('Desenvolvimento (Minhas Senhas) - Destaque Alterar'),
            'Desc'                  => '',
            'Chave'                 => 'Desenvolvimento_Senha_Destaque', // CHave unica nunca repete, chave primaria
            'End'                   => 'Desenvolvimento/Senha/Destaque', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Desenvolvimento', // Modulo Referente
            'SubModulo'             => 'Senha',   // Submodulo Referente
            'Metodo'                => 'Destaque',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => __('Desenvolvimento (Senhas_Todas) - Listagem'),
            'Desc'                  => '',
            'Chave'                 => 'Desenvolvimento_Senha_Senhas_Todas',
            'End'                   => 'Desenvolvimento/Senha/Senhas_Todas', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Desenvolvimento', // Modulo Referente
            'SubModulo'             => 'Senha',   // Submodulo Referente
            'Metodo'                => 'Senhas_Todas',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => __('Desenvolvimento (Senhas_Todas) - Add'),
            'Desc'                  => '',
            'Chave'                 => 'Desenvolvimento_Senha_Senhas_Todas_Add', // CHave unica nunca repete, chave primaria
            'End'                   => 'Desenvolvimento/Senha/Senhas_Todas_Add', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Desenvolvimento', // Modulo Referente
            'SubModulo'             => 'Senha',   // Submodulo Referente
            'Metodo'                => 'Senhas_Todas_Add,Senhas_Todas_Add2',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => __('Desenvolvimento (Senhas_Todas) - Editar'),
            'Desc'                  => '',
            'Chave'                 => 'Desenvolvimento_Senha_Senhas_Todas_Edit', // CHave unica nunca repete, chave primaria
            'End'                   => 'Desenvolvimento/Senha/Senhas_Todas_Edit', // Endereco que deve conter a url para permitir acesso // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Desenvolvimento', // Modulo Referente // Modulo Referente
            'SubModulo'             => 'Senha',   // Submodulo Referente   // Submodulo Referente
            'Metodo'                => 'Senhas_Todas_Edit,Senhas_Todas_Edit2',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => __('Desenvolvimento (Senhas_Todas) - Deletar'),
            'Desc'                  => '',
            'Chave'                 => 'Desenvolvimento_Senha_Senhas_Todas_Del', // CHave unica nunca repete, chave primaria
            'End'                   => 'Desenvolvimento/Senha/Senhas_Todas_Del', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Desenvolvimento', // Modulo Referente
            'SubModulo'             => 'Senha',   // Submodulo Referente
            'Metodo'                => 'Senhas_Todas_Del',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => __('Desenvolvimento (Senhas_Todas) - Status Alterar'),
            'Desc'                  => '',
            'Chave'                 => 'Desenvolvimento_Senha_Status_Todas', // CHave unica nunca repete, chave primaria
            'End'                   => 'Desenvolvimento/Senha/Status_Todas', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Desenvolvimento', // Modulo Referente
            'SubModulo'             => 'Senha',   // Submodulo Referente
            'Metodo'                => 'Status_Todas',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => __('Desenvolvimento (Senhas_Todas) - Destaque Alterar'),
            'Desc'                  => '',
            'Chave'                 => 'Desenvolvimento_Senha_Destaque_Todas', // CHave unica nunca repete, chave primaria
            'End'                   => 'Desenvolvimento/Senha/Destaque_Todas', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Desenvolvimento', // Modulo Referente
            'SubModulo'             => 'Senha',   // Submodulo Referente
            'Metodo'                => 'Destaque_Todas',  // Metodos referentes separados por virgula
        ),
        
        Array(
            'Nome'                  => __('Dev (Projetos) - Listagem'),
            'Desc'                  => '',
            'Chave'                 => 'Desenvolvimento_Projeto_Projetos',
            'End'                   => 'Desenvolvimento/Projeto/Projetos', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Desenvolvimento', // Modulo Referente
            'SubModulo'             => 'Projeto',   // Submodulo Referente
            'Metodo'                => 'Projetos',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => __('Dev (Projetos) - Add'),
            'Desc'                  => '',
            'Chave'                 => 'Desenvolvimento_Projeto_Projetos_Add', // CHave unica nunca repete, chave primaria
            'End'                   => 'Desenvolvimento/Projeto/Projetos_Add', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Desenvolvimento', // Modulo Referente
            'SubModulo'             => 'Projeto',   // Submodulo Referente
            'Metodo'                => 'Projetos_Add,Projetos_Add2',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => __('Dev (Projetos) - Editar'),
            'Desc'                  => '',
            'Chave'                 => 'Desenvolvimento_Projeto_Projetos_Edit', // CHave unica nunca repete, chave primaria
            'End'                   => 'Desenvolvimento/Projeto/Projetos_Edit', // Endereco que deve conter a url para permitir acesso // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Desenvolvimento', // Modulo Referente // Modulo Referente
            'SubModulo'             => 'Projeto',   // Submodulo Referente   // Submodulo Referente
            'Metodo'                => 'Projetos_Edit,Projetos_Edit2',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => __('Dev (Projetos) - Deletar'),
            'Desc'                  => '',
            'Chave'                 => 'Desenvolvimento_Projeto_Projetos_Del', // CHave unica nunca repete, chave primaria
            'End'                   => 'Desenvolvimento/Projeto/Projetos_Del', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Desenvolvimento', // Modulo Referente
            'SubModulo'             => 'Projeto',   // Submodulo Referente
            'Metodo'                => 'Projetos_Del',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => __('Dev (Projetos) - Status Alterar'),
            'Desc'                  => '',
            'Chave'                 => 'Desenvolvimento_Projeto_Status', // CHave unica nunca repete, chave primaria
            'End'                   => 'Desenvolvimento/Projeto/Status', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Desenvolvimento', // Modulo Referente
            'SubModulo'             => 'Projeto',   // Submodulo Referente
            'Metodo'                => 'Status',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => __('Dev (Projetos) - Destaque Alterar'),
            'Desc'                  => '',
            'Chave'                 => 'Desenvolvimento_Projeto_Destaque', // CHave unica nunca repete, chave primaria
            'End'                   => 'Desenvolvimento/Projeto/Destaque', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Desenvolvimento', // Modulo Referente
            'SubModulo'             => 'Projeto',   // Submodulo Referente
            'Metodo'                => 'Destaque',  // Metodos referentes separados por virgula
        ),
        
        
        Array(
            'Nome'                  => __('Dev (Tarefas) - Listagem'),
            'Desc'                  => '',
            'Chave'                 => 'Desenvolvimento_Tarefa_Tarefas',
            'End'                   => 'Desenvolvimento/Tarefa/Tarefas', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Desenvolvimento', // Modulo Referente
            'SubModulo'             => 'Tarefa',   // Submodulo Referente
            'Metodo'                => 'Tarefas',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => __('Dev (Tarefas) - Add'),
            'Desc'                  => '',
            'Chave'                 => 'Desenvolvimento_Tarefa_Tarefas_Add', // CHave unica nunca repete, chave primaria
            'End'                   => 'Desenvolvimento/Tarefa/Tarefas_Add', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Desenvolvimento', // Modulo Referente
            'SubModulo'             => 'Tarefa',   // Submodulo Referente
            'Metodo'                => 'Tarefas_Add,Tarefas_Add2',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => __('Dev (Tarefas) - Editar'),
            'Desc'                  => '',
            'Chave'                 => 'Desenvolvimento_Tarefa_Tarefas_Edit', // CHave unica nunca repete, chave primaria
            'End'                   => 'Desenvolvimento/Tarefa/Tarefas_Edit', // Endereco que deve conter a url para permitir acesso // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Desenvolvimento', // Modulo Referente // Modulo Referente
            'SubModulo'             => 'Tarefa',   // Submodulo Referente   // Submodulo Referente
            'Metodo'                => 'Tarefas_Edit,Tarefas_Edit2',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => __('Dev (Tarefas) - Deletar'),
            'Desc'                  => '',
            'Chave'                 => 'Desenvolvimento_Tarefa_Tarefas_Del', // CHave unica nunca repete, chave primaria
            'End'                   => 'Desenvolvimento/Tarefa/Tarefas_Del', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Desenvolvimento', // Modulo Referente
            'SubModulo'             => 'Tarefa',   // Submodulo Referente
            'Metodo'                => 'Tarefas_Del',  // Metodos referentes separados por virgula
        ),
        
        
        Array(
            'Nome'                  => __('Dev (Modulos) - Listagem'),
            'Desc'                  => '',
            'Chave'                 => 'Desenvolvimento_Framework_Modulos',
            'End'                   => 'Desenvolvimento/Framework/Modulos', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Desenvolvimento', // Modulo Referente
            'SubModulo'             => 'Framework',   // Submodulo Referente
            'Metodo'                => 'Modulos',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => __('Dev (Modulos) - Add'),
            'Desc'                  => '',
            'Chave'                 => 'Desenvolvimento_Framework_Modulos_Add', // CHave unica nunca repete, chave primaria
            'End'                   => 'Desenvolvimento/Framework/Modulos_Add', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Desenvolvimento', // Modulo Referente
            'SubModulo'             => 'Framework',   // Submodulo Referente
            'Metodo'                => 'Modulos_Add,Modulos_Add2',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => __('Dev (Modulos) - Editar'),
            'Desc'                  => '',
            'Chave'                 => 'Desenvolvimento_Framework_Modulos_Edit', // CHave unica nunca repete, chave primaria
            'End'                   => 'Desenvolvimento/Framework/Modulos_Edit', // Endereco que deve conter a url para permitir acesso // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Desenvolvimento', // Modulo Referente // Modulo Referente
            'SubModulo'             => 'Framework',   // Submodulo Referente   // Submodulo Referente
            'Metodo'                => 'Modulos_Edit,Modulos_Edit2',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => __('Dev (Modulos) - Deletar'),
            'Desc'                  => '',
            'Chave'                 => 'Desenvolvimento_Framework_Modulos_Del', // CHave unica nunca repete, chave primaria
            'End'                   => 'Desenvolvimento/Framework/Modulos_Del', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Desenvolvimento', // Modulo Referente
            'SubModulo'             => 'Framework',   // Submodulo Referente
            'Metodo'                => 'Modulos_Del',  // Metodos referentes separados por virgula
        ),
        
        
        Array(
            'Nome'                  => __('Dev (Submodulos) - Listagem'),
            'Desc'                  => '',
            'Chave'                 => 'Desenvolvimento_Framework_Submodulos',
            'End'                   => 'Desenvolvimento/Framework/Submodulos', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Desenvolvimento', // Modulo Referente
            'SubModulo'             => 'Framework',   // Submodulo Referente
            'Metodo'                => 'Submodulos',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => __('Dev (Submodulos) - Add'),
            'Desc'                  => '',
            'Chave'                 => 'Desenvolvimento_Framework_Submodulos_Add', // CHave unica nunca repete, chave primaria
            'End'                   => 'Desenvolvimento/Framework/Submodulos_Add', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Desenvolvimento', // Modulo Referente
            'SubModulo'             => 'Framework',   // Submodulo Referente
            'Metodo'                => 'Submodulos_Add,Submodulos_Add2',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => __('Dev (Submodulos) - Editar'),
            'Desc'                  => '',
            'Chave'                 => 'Desenvolvimento_Framework_Submodulos_Edit', // CHave unica nunca repete, chave primaria
            'End'                   => 'Desenvolvimento/Framework/Submodulos_Edit', // Endereco que deve conter a url para permitir acesso // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Desenvolvimento', // Modulo Referente
            'SubModulo'             => 'Framework',   // Submodulo Referente   // Submodulo Referente
            'Metodo'                => 'Submodulos_Edit,Submodulos_Edit2',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => __('Dev (Submodulos) - Deletar'),
            'Desc'                  => '',
            'Chave'                 => 'Desenvolvimento_Framework_Submodulos_Del', // CHave unica nunca repete, chave primaria
            'End'                   => 'Desenvolvimento/Framework/Submodulos_Del', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Desenvolvimento', // Modulo Referente
            'SubModulo'             => 'Framework',   // Submodulo Referente
            'Metodo'                => 'Submodulos_Del',  // Metodos referentes separados por virgula
        ),
        
        
        Array(
            'Nome'                  => __('Dev (Metodos) - Listagem'),
            'Desc'                  => '',
            'Chave'                 => 'Desenvolvimento_Framework_Metodos',
            'End'                   => 'Desenvolvimento/Framework/Metodos', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Desenvolvimento', // Modulo Referente
            'SubModulo'             => 'Framework',   // Submodulo Referente
            'Metodo'                => 'Metodos',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => __('Dev (Metodos) - Add'),
            'Desc'                  => '',
            'Chave'                 => 'Desenvolvimento_Framework_Metodos_Add', // CHave unica nunca repete, chave primaria
            'End'                   => 'Desenvolvimento/Framework/Metodos_Add', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Desenvolvimento', // Modulo Referente
            'SubModulo'             => 'Framework',   // Submodulo Referente
            'Metodo'                => 'Metodos_Add,Metodos_Add2',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => __('Dev (Metodos) - Editar'),
            'Desc'                  => '',
            'Chave'                 => 'Desenvolvimento_Framework_Metodos_Edit', // CHave unica nunca repete, chave primaria
            'End'                   => 'Desenvolvimento/Framework/Metodos_Edit', // Endereco que deve conter a url para permitir acesso // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Desenvolvimento', // Modulo Referente
            'SubModulo'             => 'Framework',   // Submodulo Referente   // Submodulo Referente
            'Metodo'                => 'Metodos_Edit,Metodos_Edit2',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => __('Dev (Metodos) - Deletar'),
            'Desc'                  => '',
            'Chave'                 => 'Desenvolvimento_Framework_Metodos_Del', // CHave unica nunca repete, chave primaria
            'End'                   => 'Desenvolvimento/Framework/Metodos_Del', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Desenvolvimento', // Modulo Referente
            'SubModulo'             => 'Framework',   // Submodulo Referente
            'Metodo'                => 'Metodos_Del',  // Metodos referentes separados por virgula
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
