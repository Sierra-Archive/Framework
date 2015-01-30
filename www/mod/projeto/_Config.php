<?php
$config_Modulo = function (){
    return Array(
        'Nome'                      =>  'projeto',
        'Descrição'                 =>  'Modulo desenvolvido para Desenvolvimentos',
        'System_Require'            =>  '2.21.1',
        'Version'                   =>  '0.0.1',
        'Dependencias'              =>  false,
    );
};
$config_Menu = function (){
    return Array(
        'Dev'=>Array(
            'Nome'                  => 'Dev',
            'Link'                  => '#',
            'Gravidade'             => 30,
            'Img'                   => 'turboadmin/m-dashboard.png',
            'Icon'                  => 'list-alt',
            'Filhos'                => Array('Projetos'=>Array(
                'Nome'                  => 'Projetos',
                'Link'                  => 'projeto/Projeto/Projetos',
                'Gravidade'             => 50,
                'Img'                   => 'turboadmin/m-users.png',
                'Icon'                  => 'list-alt',
                'Filhos'                => false,
            ),'Tarefas'=>Array(
                'Nome'                  => 'Tarefas',
                'Link'                  => 'projeto/Tarefa/Tarefas',
                'Gravidade'             => 40,
                'Img'                   => 'turboadmin/m-users.png',
                'Icon'                  => 'list-alt',
                'Filhos'                => false,
            ),'Fram. Módulos'=>Array(
                'Nome'                  => 'Fram. Módulos',
                'Link'                  => 'projeto/Framework/Modulos',
                'Gravidade'             => 30,
                'Img'                   => 'turboadmin/m-users.png',
                'Icon'                  => 'list-alt',
                'Filhos'                => false,
            ),'Fram. Módulos'=>Array(
                'Nome'                  => 'Fram. SubMódulos',
                'Link'                  => 'projeto/Framework/Submodulos',
                'Gravidade'             => 20,
                'Img'                   => 'turboadmin/m-users.png',
                'Icon'                  => 'list-alt',
                'Filhos'                => false,
            ),'Fram. Módulos'=>Array(
                'Nome'                  => 'Fram. Metodos',
                'Link'                  => 'projeto/Framework/Metodos',
                'Gravidade'             => 10,
                'Img'                   => 'turboadmin/m-users.png',
                'Icon'                  => 'list-alt',
                'Filhos'                => false,
            ),),
        ),
    );
};
$config_Permissoes = function (){
    return Array(
        Array(
            'Nome'                  => 'Dev (Projetos) - Listagem',
            'Desc'                  => '',
            'Chave'                 => 'projeto_Projeto_Projetos',
            'End'                   => 'projeto/Projeto/Projetos', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'projeto', // Modulo Referente
            'SubModulo'             => 'Projeto',   // Submodulo Referente
            'Metodo'                => 'Projetos',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => 'Dev (Projetos) - Add',
            'Desc'                  => '',
            'Chave'                 => 'projeto_Projeto_Projetos_Add', // CHave unica nunca repete, chave primaria
            'End'                   => 'projeto/Projeto/Projetos_Add', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'projeto', // Modulo Referente
            'SubModulo'             => 'Projeto',   // Submodulo Referente
            'Metodo'                => 'Projetos_Add,Projetos_Add2',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => 'Dev (Projetos) - Editar',
            'Desc'                  => '',
            'Chave'                 => 'projeto_Projeto_Projetos_Edit', // CHave unica nunca repete, chave primaria
            'End'                   => 'projeto/Projeto/Projetos_Edit', // Endereco que deve conter a url para permitir acesso // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'projeto', // Modulo Referente // Modulo Referente
            'SubModulo'             => 'Projeto',   // Submodulo Referente   // Submodulo Referente
            'Metodo'                => 'Projetos_Edit,Projetos_Edit2',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => 'Dev (Projetos) - Deletar',
            'Desc'                  => '',
            'Chave'                 => 'projeto_Projeto_Projetos_Del', // CHave unica nunca repete, chave primaria
            'End'                   => 'projeto/Projeto/Projetos_Del', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'projeto', // Modulo Referente
            'SubModulo'             => 'Projeto',   // Submodulo Referente
            'Metodo'                => 'Projetos_Del',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => 'Dev (Projetos) - Status Alterar',
            'Desc'                  => '',
            'Chave'                 => 'projeto_Projeto_Status', // CHave unica nunca repete, chave primaria
            'End'                   => 'projeto/Projeto/Status', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'projeto', // Modulo Referente
            'SubModulo'             => 'Projeto',   // Submodulo Referente
            'Metodo'                => 'Status',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => 'Dev (Projetos) - Destaque Alterar',
            'Desc'                  => '',
            'Chave'                 => 'projeto_Projeto_Destaque', // CHave unica nunca repete, chave primaria
            'End'                   => 'projeto/Projeto/Destaque', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'projeto', // Modulo Referente
            'SubModulo'             => 'Projeto',   // Submodulo Referente
            'Metodo'                => 'Destaque',  // Metodos referentes separados por virgula
        ),
        
        
        Array(
            'Nome'                  => 'Dev (Tarefas) - Listagem',
            'Desc'                  => '',
            'Chave'                 => 'projeto_Tarefa_Tarefas',
            'End'                   => 'projeto/Tarefa/Tarefas', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'projeto', // Modulo Referente
            'SubModulo'             => 'Tarefa',   // Submodulo Referente
            'Metodo'                => 'Tarefas',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => 'Dev (Tarefas) - Add',
            'Desc'                  => '',
            'Chave'                 => 'projeto_Tarefa_Tarefas_Add', // CHave unica nunca repete, chave primaria
            'End'                   => 'projeto/Tarefa/Tarefas_Add', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'projeto', // Modulo Referente
            'SubModulo'             => 'Tarefa',   // Submodulo Referente
            'Metodo'                => 'Tarefas_Add,Tarefas_Add2',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => 'Dev (Tarefas) - Editar',
            'Desc'                  => '',
            'Chave'                 => 'projeto_Tarefa_Tarefas_Edit', // CHave unica nunca repete, chave primaria
            'End'                   => 'projeto/Tarefa/Tarefas_Edit', // Endereco que deve conter a url para permitir acesso // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'projeto', // Modulo Referente // Modulo Referente
            'SubModulo'             => 'Tarefa',   // Submodulo Referente   // Submodulo Referente
            'Metodo'                => 'Tarefas_Edit,Tarefas_Edit2',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => 'Dev (Tarefas) - Deletar',
            'Desc'                  => '',
            'Chave'                 => 'projeto_Tarefa_Tarefas_Del', // CHave unica nunca repete, chave primaria
            'End'                   => 'projeto/Tarefa/Tarefas_Del', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'projeto', // Modulo Referente
            'SubModulo'             => 'Tarefa',   // Submodulo Referente
            'Metodo'                => 'Tarefas_Del',  // Metodos referentes separados por virgula
        ),
        
        
        Array(
            'Nome'                  => 'Dev (Modulos) - Listagem',
            'Desc'                  => '',
            'Chave'                 => 'projeto_Framework_Modulos',
            'End'                   => 'projeto/Framework/Modulos', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'projeto', // Modulo Referente
            'SubModulo'             => 'Framework',   // Submodulo Referente
            'Metodo'                => 'Modulos',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => 'Dev (Modulos) - Add',
            'Desc'                  => '',
            'Chave'                 => 'projeto_Framework_Modulos_Add', // CHave unica nunca repete, chave primaria
            'End'                   => 'projeto/Framework/Modulos_Add', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'projeto', // Modulo Referente
            'SubModulo'             => 'Framework',   // Submodulo Referente
            'Metodo'                => 'Modulos_Add,Modulos_Add2',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => 'Dev (Modulos) - Editar',
            'Desc'                  => '',
            'Chave'                 => 'projeto_Framework_Modulos_Edit', // CHave unica nunca repete, chave primaria
            'End'                   => 'projeto/Framework/Modulos_Edit', // Endereco que deve conter a url para permitir acesso // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'projeto', // Modulo Referente // Modulo Referente
            'SubModulo'             => 'Framework',   // Submodulo Referente   // Submodulo Referente
            'Metodo'                => 'Modulos_Edit,Modulos_Edit2',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => 'Dev (Modulos) - Deletar',
            'Desc'                  => '',
            'Chave'                 => 'projeto_Framework_Modulos_Del', // CHave unica nunca repete, chave primaria
            'End'                   => 'projeto/Framework/Modulos_Del', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'projeto', // Modulo Referente
            'SubModulo'             => 'Framework',   // Submodulo Referente
            'Metodo'                => 'Modulos_Del',  // Metodos referentes separados por virgula
        ),
        
        
        Array(
            'Nome'                  => 'Dev (Submodulos) - Listagem',
            'Desc'                  => '',
            'Chave'                 => 'projeto_Framework_Submodulos',
            'End'                   => 'projeto/Framework/Submodulos', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'projeto', // Modulo Referente
            'SubModulo'             => 'Framework',   // Submodulo Referente
            'Metodo'                => 'Submodulos',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => 'Dev (Submodulos) - Add',
            'Desc'                  => '',
            'Chave'                 => 'projeto_Framework_Submodulos_Add', // CHave unica nunca repete, chave primaria
            'End'                   => 'projeto/Framework/Submodulos_Add', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'projeto', // Modulo Referente
            'SubModulo'             => 'Framework',   // Submodulo Referente
            'Metodo'                => 'Submodulos_Add,Submodulos_Add2',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => 'Dev (Submodulos) - Editar',
            'Desc'                  => '',
            'Chave'                 => 'projeto_Framework_Submodulos_Edit', // CHave unica nunca repete, chave primaria
            'End'                   => 'projeto/Framework/Submodulos_Edit', // Endereco que deve conter a url para permitir acesso // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'projeto', // Modulo Referente
            'SubModulo'             => 'Framework',   // Submodulo Referente   // Submodulo Referente
            'Metodo'                => 'Submodulos_Edit,Submodulos_Edit2',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => 'Dev (Submodulos) - Deletar',
            'Desc'                  => '',
            'Chave'                 => 'projeto_Framework_Submodulos_Del', // CHave unica nunca repete, chave primaria
            'End'                   => 'projeto/Framework/Submodulos_Del', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'projeto', // Modulo Referente
            'SubModulo'             => 'Framework',   // Submodulo Referente
            'Metodo'                => 'Submodulos_Del',  // Metodos referentes separados por virgula
        ),
        
        
        Array(
            'Nome'                  => 'Dev (Metodos) - Listagem',
            'Desc'                  => '',
            'Chave'                 => 'projeto_Framework_Metodos',
            'End'                   => 'projeto/Framework/Metodos', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'projeto', // Modulo Referente
            'SubModulo'             => 'Framework',   // Submodulo Referente
            'Metodo'                => 'Metodos',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => 'Dev (Metodos) - Add',
            'Desc'                  => '',
            'Chave'                 => 'projeto_Framework_Metodos_Add', // CHave unica nunca repete, chave primaria
            'End'                   => 'projeto/Framework/Metodos_Add', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'projeto', // Modulo Referente
            'SubModulo'             => 'Framework',   // Submodulo Referente
            'Metodo'                => 'Metodos_Add,Metodos_Add2',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => 'Dev (Metodos) - Editar',
            'Desc'                  => '',
            'Chave'                 => 'projeto_Framework_Metodos_Edit', // CHave unica nunca repete, chave primaria
            'End'                   => 'projeto/Framework/Metodos_Edit', // Endereco que deve conter a url para permitir acesso // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'projeto', // Modulo Referente
            'SubModulo'             => 'Framework',   // Submodulo Referente   // Submodulo Referente
            'Metodo'                => 'Metodos_Edit,Metodos_Edit2',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => 'Dev (Metodos) - Deletar',
            'Desc'                  => '',
            'Chave'                 => 'projeto_Framework_Metodos_Del', // CHave unica nunca repete, chave primaria
            'End'                   => 'projeto/Framework/Metodos_Del', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'projeto', // Modulo Referente
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
