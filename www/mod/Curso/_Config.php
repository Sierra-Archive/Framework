<?php
$config_Modulo = function (){
    return Array(
        'Nome'                      =>  'Curso',
        'Descrição'                 =>  '',
        'System_Require'            =>  '3.1.0',
        'Version'                   =>  '3.1.1',
        'Dependencias'              =>  false,
    );
};
$config_Menu = function (){
    return Array(
        'Turmas Abertas' => Array(
            'Nome'                  => __('Turmas Abertas'),
            'Link'                  => 'Curso/Turma/Abertas',
            'Gravidade'             => 90,
            'Img'                   => '',
            'Icon'                  => 'hdd',
            'Filhos'                => false
        ),
        'Cursos' => Array(
            'Nome'                  => __('Cursos'),
            'Link'                  => '#',
            'Gravidade'             => 55,
            'Img'                   => '',
            'Icon'                  => 'building',
            'Filhos'                => Array('Cursos'=>Array(
                'Nome'                  => __('Cursos'),
                'Link'                  => 'Curso/Curso/Cursos',
                'Gravidade'             => 90,
                'Img'                   => '',
                'Icon'                  => 'group',
                'Filhos'                => false,
            ),'Turmas'=>Array(
                'Nome'                  => __('Turmas'),
                'Link'                  => 'Curso/Turma/Turmas',
                'Gravidade'             => 80,
                'Img'                   => '',
                'Icon'                  => 'hdd',
                'Filhos'                => false,
            )),
        ),
    );
};
$config_Permissoes = function (){
    return Array(
        // Curso
        Array(
            'Nome'                  => __('Midia (Cursos) - Listagem'),
            'Desc'                  => '',
            'Chave'                 => 'Curso_Curso_Cursos',
            'End'                   => 'Curso/Curso/Cursos', // Endereco que deve conter a url para permitir acesso // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Curso', // Modulo Referente // Modulo Referente
            'SubModulo'             => 'Curso',   // Submodulo Referente   // Submodulo Referente
            'Metodo'                => 'Cursos',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => __('Midia (Cursos) - Add'),
            'Desc'                  => '',
            'Chave'                 => 'Curso_Curso_Cursos_Add', // CHave unica nunca repete, chave primaria
            'End'                   => 'Curso/Curso/Cursos_Add', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Curso', // Modulo Referente
            'SubModulo'             => 'Curso',   // Submodulo Referente
            'Metodo'                => 'Cursos_Add,Cursos_Add2',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => __('Midia (Cursos) - Editar'),
            'Desc'                  => '',
            'Chave'                 => 'Curso_Curso_Cursos_Edit', // CHave unica nunca repete, chave primaria
            'End'                   => 'Curso/Curso/Cursos_Edit', // Endereco que deve conter a url para permitir acesso // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Curso', // Modulo Referente // Modulo Referente
            'SubModulo'             => 'Curso',   // Submodulo Referente   // Submodulo Referente
            'Metodo'                => 'Cursos_Edit,Cursos_Edit2',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => __('Midia (Cursos) - Deletar'),
            'Desc'                  => '',
            'Chave'                 => 'Curso_Curso_Cursos_Del', // CHave unica nunca repete, chave primaria
            'End'                   => 'Curso/Curso/Cursos_Del', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Curso', // Modulo Referente
            'SubModulo'             => 'Curso',   // Submodulo Referente
            'Metodo'                => 'Cursos_Del',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => __('Midia (Cursos) - Status Alterar'),
            'Desc'                  => '',
            'Chave'                 => 'Curso_Cursos_Status', // CHave unica nunca repete, chave primaria
            'End'                   => 'Curso/Cursos/Status', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Curso', // Modulo Referente
            'SubModulo'             => 'Cursos',   // Submodulo Referente
            'Metodo'                => 'Status',  // Metodos referentes separados por virgula
        ),
        
        // Turma
        Array(
            'Nome'                  => __('Midia (Turmas) - Listagem'),
            'Desc'                  => '',
            'Chave'                 => 'Curso_Turma_Turmas',
            'End'                   => 'Curso/Turma/Turmas', // Endereco que deve conter a url para permitir acesso // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Curso', // Modulo Referente // Modulo Referente
            'SubModulo'             => 'Turma',   // Submodulo Referente   // Submodulo Referente
            'Metodo'                => 'Turmas',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => __('Midia (Turmas) - Ver'),
            'Desc'                  => '',
            'Chave'                 => 'Curso_Turma_Turmas_Ver', // CHave unica nunca repete, chave primaria
            'End'                   => 'Curso/Turma/Turmas_Ver', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Curso', // Modulo Referente
            'SubModulo'             => 'Turma',   // Submodulo Referente
            'Metodo'                => 'Turmas_Ver',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => __('Midia (Turmas) - Add'),
            'Desc'                  => '',
            'Chave'                 => 'Curso_Turma_Turmas_Add', // CHave unica nunca repete, chave primaria
            'End'                   => 'Curso/Turma/Turmas_Add', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Curso', // Modulo Referente
            'SubModulo'             => 'Turma',   // Submodulo Referente
            'Metodo'                => 'Turmas_Add,Turmas_Add2',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => __('Midia (Turmas) - Editar'),
            'Desc'                  => '',
            'Chave'                 => 'Curso_Turma_Turmas_Edit', // CHave unica nunca repete, chave primaria
            'End'                   => 'Curso/Turma/Turmas_Edit', // Endereco que deve conter a url para permitir acesso // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Curso', // Modulo Referente // Modulo Referente
            'SubModulo'             => 'Turma',   // Submodulo Referente   // Submodulo Referente
            'Metodo'                => 'Turmas_Edit,Turmas_Edit2',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => __('Midia (Turmas) - Deletar'),
            'Desc'                  => '',
            'Chave'                 => 'Curso_Turma_Turmas_Del', // CHave unica nunca repete, chave primaria
            'End'                   => 'Curso/Turma/Turmas_Del', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Curso', // Modulo Referente
            'SubModulo'             => 'Turma',   // Submodulo Referente
            'Metodo'                => 'Turmas_Del',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => __('Midia (Turmas) - Status Alterar'),
            'Desc'                  => '',
            'Chave'                 => 'Curso_Turma_Status', // CHave unica nunca repete, chave primaria
            'End'                   => 'Curso/Turma/Status', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Curso', // Modulo Referente
            'SubModulo'             => 'Turma',   // Submodulo Referente
            'Metodo'                => 'Status',  // Metodos referentes separados por virgula
        ),
        
        
        
        /// Inscrições
        Array(
            'Nome'                  => __('Midia (Turmas) - Abertas para Inscrição'),
            'Desc'                  => '',
            'Chave'                 => 'Curso_Turma_Abertas',
            'End'                   => 'Curso/Turma/Abertas', // Endereco que deve conter a url para permitir acesso // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Curso', // Modulo Referente // Modulo Referente
            'SubModulo'             => 'Turma',   // Submodulo Referente   // Submodulo Referente
            'Metodo'                => 'Abertas',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => __('Midia (Inscrições) - Se Inscrever'),
            'Desc'                  => '',
            'Chave'                 => 'Curso_Turma_Inscricao_Fazer',
            'End'                   => 'Curso/Turma/Inscricao_Fazer', // Endereco que deve conter a url para permitir acesso // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Curso', // Modulo Referente // Modulo Referente
            'SubModulo'             => 'Turma',   // Submodulo Referente   // Submodulo Referente
            'Metodo'                => 'Inscricao_Fazer,Inscricao_Fazer2',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => __('Midia (Inscrições) - Mover Inscrição'),
            'Desc'                  => '',
            'Chave'                 => 'Curso_Turma_Inscricao_Mover',
            'End'                   => 'Curso/Turma/Inscricao_Mover', // Endereco que deve conter a url para permitir acesso // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Curso', // Modulo Referente // Modulo Referente
            'SubModulo'             => 'Turma',   // Submodulo Referente   // Submodulo Referente
            'Metodo'                => 'Inscricao_Mover,Inscricao_Mover2',  // Metodos referentes separados por virgula
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
