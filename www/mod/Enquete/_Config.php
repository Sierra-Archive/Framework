<?php
$config_Modulo = function (){
    return Array(
        'Nome'                      =>  'Enquete',
        'Descrição'                 =>  '',
        'System_Require'            =>  '2.21.1',
        'Version'                   =>  '0.0.1',
        'Dependencias'              =>  false,
    );
};
$config_Menu = function (){
    return Array(
        'Administrar' => Array(
            'Filhos'                => Array('Enquete'=>Array(
                'Nome'                  => 'Enquete',
                'Link'                  => 'Enquete/Enquete/Enquetes',
                'Gravidade'             => 90,
                'Img'                   => '',
                'Icon'                  => 'comments-alt',
                'Filhos'                => false,
            ),),
        ),
    );
};
$config_Permissoes = function (){
    return Array(
        Array(
            'Nome'                  => 'Enquete - Listagem',
            'Desc'                  => '',
            'Chave'                 => 'Enquete_Enquete',
            'End'                   => 'Enquete/Enquete', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Enquete', // Modulo Referente
            'SubModulo'             => 'Enquete',   // Submodulo Referente
            'Metodo'                => '*',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => 'Enquete - Add',
            'Desc'                  => '',
            'Chave'                 => 'Enquete_Enquete_Enquetes_Add', // CHave unica nunca repete, chave primaria
            'End'                   => 'Enquete/Enquete/Enquetes_Add', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Enquete', // Modulo Referente
            'SubModulo'             => 'Enquete',   // Submodulo Referente
            'Metodo'                => 'Enquetes_Add,Enquetes_Add2',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => 'Enquete - Editar',
            'Desc'                  => '',
            'Chave'                 => 'Enquete_Enquete_Enquetes_Edit', // CHave unica nunca repete, chave primaria
            'End'                   => 'Enquete/Enquete/Enquetes_Edit', // Endereco que deve conter a url para permitir acesso // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Enquete', // Modulo Referente // Modulo Referente
            'SubModulo'             => 'Enquete',   // Submodulo Referente   // Submodulo Referente
            'Metodo'                => 'Enquetes_Edit,Enquetes_Edit2',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => 'Enquete - Deletar',
            'Desc'                  => '',
            'Chave'                 => 'Enquete_Enquete_Enquetes_Del', // CHave unica nunca repete, chave primaria
            'End'                   => 'Enquete/Enquete/Enquetes_Del', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Enquete', // Modulo Referente
            'SubModulo'             => 'Enquete',   // Submodulo Referente
            'Metodo'                => 'Enquetes_Del',  // Metodos referentes separados por virgula
        ),
        
        Array(
            'Nome'                  => 'Enquete (Respostas) - Listagem',
            'Desc'                  => '',
            'Chave'                 => 'Enquete_Resposta',
            'End'                   => 'Enquete/Resposta', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Enquete', // Modulo Referente
            'SubModulo'             => 'Resposta',   // Submodulo Referente
            'Metodo'                => '*',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => 'Enquete (Respostas) - Add',
            'Desc'                  => '',
            'Chave'                 => 'Enquete_Respostas_Add', // CHave unica nunca repete, chave primaria
            'End'                   => 'Enquete/Resposta/Respostas_Add', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Enquete', // Modulo Referente
            'SubModulo'             => 'Resposta',   // Submodulo Referente
            'Metodo'                => 'Respostas_Add,Respostas_Add2',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => 'Enquete (Respostas) - Editar',
            'Desc'                  => '',
            'Chave'                 => 'Enquete_Edit', // CHave unica nunca repete, chave primaria
            'End'                   => 'Enquete/Resposta/Respostas_Edit', // Endereco que deve conter a url para permitir acesso // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Enquete', // Modulo Referente // Modulo Referente
            'SubModulo'             => 'Resposta',   // Submodulo Referente   // Submodulo Referente
            'Metodo'                => 'Respostas_Edit,Respostas_Edit2',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => 'Enquete (Respostas) - Deletar',
            'Desc'                  => '',
            'Chave'                 => 'Enquete_Del', // CHave unica nunca repete, chave primaria
            'End'                   => 'Enquete/Resposta/Respostas_Del', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Enquete', // Modulo Referente
            'SubModulo'             => 'Resposta',   // Submodulo Referente
            'Metodo'                => 'Respostas_Del',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => 'Enquete - Responder',
            'Desc'                  => '',
            'Chave'                 => 'Enquete_Show',
            'End'                   => 'Enquete/Show', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Enquete', // Modulo Referente
            'SubModulo'             => 'Show',   // Submodulo Referente
            'Metodo'                => '*',  // Metodos referentes separados por virgula
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
