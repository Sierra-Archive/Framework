<?php
$config_Modulo = function (){
    return Array(
        'Nome'                      =>  'Simulador',
        'Descrição'                 =>  '',
        'System_Require'            =>  '3.1.0',
        'Version'                   =>  '3.1.1',
        'Dependencias'              =>  false,
    );
};
$config_Menu = function (){
    return Array(
        'Simuladores'=>Array(
            'Nome'                  => __('Simuladores'),
            'Link'                  => '#',
            'Gravidade'             => 90,
            'Img'                   => '',
            'Icon'                  => 'folder-open',
            'Filhos'                => Array(
                'Simuladores'=>Array(
                    'Nome'                  => __('Simuladores'),
                    'Link'                  => 'Simulador/Simulador/Simuladores',
                    'Gravidade'             => 90,
                    'Img'                   => '',
                    'Icon'                  => 'folder-open',
                    'Filhos'                => false,
                ),'Perguntas'=>Array(
                    'Nome'                  => __('Perguntas'),
                    'Link'                  => 'Simulador/Pergunta/Perguntas',
                    'Gravidade'             => 80,
                    'Img'                   => '',
                    'Icon'                  => 'folder-open',
                    'Filhos'                => false,
                ),'Respostas'=>Array(
                    'Nome'                  => __('Respostas'),
                    'Link'                  => 'Simulador/Resposta/Respostas',
                    'Gravidade'             => 70,
                    'Img'                   => '',
                    'Icon'                  => 'folder-open',
                    'Filhos'                => false,
                ),'Caracteristica'=>Array(
                    'Nome'                  => __('Caracteristica'),
                    'Link'                  => 'Simulador/Tag/Tags',
                    'Gravidade'             => 60,
                    'Img'                   => '',
                    'Icon'                  => 'folder-open',
                    'Filhos'                => false,
                ),
            ),
        ),
    );
};
$config_Permissoes = function (){
    return Array(
        Array(
            'Nome'                  => __('Caracteristica - Listagem'),
            'Desc'                  => '',
            'Chave'                 => 'Simulador_Tag_Tags',
            'End'                   => 'Simulador/Tag/Tags', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Simulador', // Modulo Referente
            'SubModulo'             => 'Simulador',   // Submodulo Referente
            'Metodo'                => 'Tags',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => __('Caracteristica - Add'),
            'Desc'                  => '',
            'Chave'                 => 'Simulador_Tag_Tags_Add', // CHave unica nunca repete, chave primaria
            'End'                   => 'Simulador/Tag/Tags_Add', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Simulador', // Modulo Referente
            'SubModulo'             => 'Tag',   // Submodulo Referente
            'Metodo'                => 'Tags_Add,Tags_Add2',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => __('Caracteristica - Editar'),
            'Desc'                  => '',
            'Chave'                 => 'Simulador_Tag_Tags_Edit', // CHave unica nunca repete, chave primaria
            'End'                   => 'Simulador/Tag/Tags_Edit', // Endereco que deve conter a url para permitir acesso // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Simulador', // Modulo Referente // Modulo Referente
            'SubModulo'             => 'Tag',   // Submodulo Referente   // Submodulo Referente
            'Metodo'                => 'Tags_Edit,Tags_Edit2',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => __('Caracteristica - Deletar'),
            'Desc'                  => '',
            'Chave'                 => 'Simulador_Tag_Tags_Del', // CHave unica nunca repete, chave primaria
            'End'                   => 'Simulador/Tag/Tags_Del', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Simulador', // Modulo Referente
            'SubModulo'             => 'Tag',   // Submodulo Referente
            'Metodo'                => 'Tags_Del',  // Metodos referentes separados por virgula
        ),
        
        
        //Simuladores
        Array(
            'Nome'                  => __('Simulador - Listagem'),
            'Desc'                  => '',
            'Chave'                 => 'Simulador_Simulador_Simuladores',
            'End'                   => 'Simulador/Simulador/Simuladores', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Simulador', // Modulo Referente
            'SubModulo'             => 'Simulador',   // Submodulo Referente
            'Metodo'                => 'Simuladores',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => __('Simulador - Add'),
            'Desc'                  => '',
            'Chave'                 => 'Simulador_Simulador_Simuladores_Add', // CHave unica nunca repete, chave primaria
            'End'                   => 'Simulador/Simulador/Simuladores_Add', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Simulador', // Modulo Referente
            'SubModulo'             => 'Simulador',   // Submodulo Referente
            'Metodo'                => 'Simuladores_Add,Simuladores_Add2',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => __('Simulador - Editar'),
            'Desc'                  => '',
            'Chave'                 => 'Simulador_Simulador_Simuladores_Edit', // CHave unica nunca repete, chave primaria
            'End'                   => 'Simulador/Simulador/Simuladores_Edit', // Endereco que deve conter a url para permitir acesso // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Simulador', // Modulo Referente // Modulo Referente
            'SubModulo'             => 'Simulador',   // Submodulo Referente   // Submodulo Referente
            'Metodo'                => 'Simuladores_Edit,Simuladores_Edit2',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => __('Simulador - Deletar'),
            'Desc'                  => '',
            'Chave'                 => 'Simulador_Simulador_Simuladores_Del', // CHave unica nunca repete, chave primaria
            'End'                   => 'Simulador/Simulador/Simuladores_Del', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Simulador', // Modulo Referente
            'SubModulo'             => 'Simulador',   // Submodulo Referente
            'Metodo'                => 'Simuladores_Del',  // Metodos referentes separados por virgula
        ),
        
        //Perguntas
        Array(
            'Nome'                  => __('Pergunta - Listagem'),
            'Desc'                  => '',
            'Chave'                 => 'Simulador_Pergunta_Perguntas',
            'End'                   => 'Simulador/Pergunta/Perguntas', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Simulador', // Modulo Referente
            'SubModulo'             => 'Simulador',   // Submodulo Referente
            'Metodo'                => 'Perguntas',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => __('Pergunta - Add'),
            'Desc'                  => '',
            'Chave'                 => 'Simulador_Pergunta_Perguntas_Add', // CHave unica nunca repete, chave primaria
            'End'                   => 'Simulador/Pergunta/Perguntas_Add', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Simulador', // Modulo Referente
            'SubModulo'             => 'Pergunta',   // Submodulo Referente
            'Metodo'                => 'Perguntas_Add,Perguntas_Add2',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => __('Pergunta - Editar'),
            'Desc'                  => '',
            'Chave'                 => 'Simulador_Pergunta_Perguntas_Edit', // CHave unica nunca repete, chave primaria
            'End'                   => 'Simulador/Pergunta/Perguntas_Edit', // Endereco que deve conter a url para permitir acesso // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Simulador', // Modulo Referente // Modulo Referente
            'SubModulo'             => 'Pergunta',   // Submodulo Referente   // Submodulo Referente
            'Metodo'                => 'Perguntas_Edit,Perguntas_Edit2',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => __('Pergunta - Deletar'),
            'Desc'                  => '',
            'Chave'                 => 'Simulador_Pergunta_Perguntas_Del', // CHave unica nunca repete, chave primaria
            'End'                   => 'Simulador/Pergunta/Perguntas_Del', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Simulador', // Modulo Referente
            'SubModulo'             => 'Pergunta',   // Submodulo Referente
            'Metodo'                => 'Perguntas_Del',  // Metodos referentes separados por virgula
        ),
        
        //Respostas
        Array(
            'Nome'                  => __('Resposta - Listagem'),
            'Desc'                  => '',
            'Chave'                 => 'Simulador_Resposta_Respostas',
            'End'                   => 'Simulador/Resposta/Respostas', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Simulador', // Modulo Referente
            'SubModulo'             => 'Simulador',   // Submodulo Referente
            'Metodo'                => 'Respostas',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => __('Resposta - Add'),
            'Desc'                  => '',
            'Chave'                 => 'Simulador_Resposta_Respostas_Add', // CHave unica nunca repete, chave primaria
            'End'                   => 'Simulador/Resposta/Respostas_Add', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Simulador', // Modulo Referente
            'SubModulo'             => 'Resposta',   // Submodulo Referente
            'Metodo'                => 'Respostas_Add,Respostas_Add2',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => __('Resposta - Editar'),
            'Desc'                  => '',
            'Chave'                 => 'Simulador_Resposta_Respostas_Edit', // CHave unica nunca repete, chave primaria
            'End'                   => 'Simulador/Resposta/Respostas_Edit', // Endereco que deve conter a url para permitir acesso // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Simulador', // Modulo Referente // Modulo Referente
            'SubModulo'             => 'Resposta',   // Submodulo Referente   // Submodulo Referente
            'Metodo'                => 'Respostas_Edit,Respostas_Edit2',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => __('Resposta - Deletar'),
            'Desc'                  => '',
            'Chave'                 => 'Simulador_Resposta_Respostas_Del', // CHave unica nunca repete, chave primaria
            'End'                   => 'Simulador/Resposta/Respostas_Del', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Simulador', // Modulo Referente
            'SubModulo'             => 'Resposta',   // Submodulo Referente
            'Metodo'                => 'Respostas_Del',  // Metodos referentes separados por virgula
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
            'Chave'                 => '{chave}',
            'Valor'                 => 'valor_padrao'
        )*/
    );
};
?>
