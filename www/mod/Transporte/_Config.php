<?php
$config_Modulo = function (){
    return Array(
        'Nome'                      =>  'Transporte',
        'Descrição'                 =>  '',
        'System_Require'            =>  '2.21.1',
        'Version'                   =>  '0.0.1',
        'Dependencias'              =>  false,
    );
};
$config_Menu = function (){
    return Array(
        'Armazens'=>Array(
            'Nome'                  => 'Armazens',
            'Link'                  => 'Transporte/Armazem/Armazens',
            'Gravidade'             => 75,
            'Img'                   => 'turboadmin/m-dashboard.png',
            'Icon'                  => 'truck',
            'Filhos'                => false,
        ),
        'Caminhoneiros'=>Array(
            'Nome'                  => 'Caminhoneiros',
            'Link'                  => 'Transporte/Caminhoneiro/Caminhoneiros',
            'Gravidade'             => 70,
            'Img'                   => 'turboadmin/m-dashboard.png',
            'Icon'                  => 'truck',
            'Filhos'                => false,
        ),'Administrar'=>Array(
            'Filhos'                => Array('Leilão de Trans.'=>Array(
                'Nome'                  => 'Leilão de Trans.',
                'Link'                  => 'Transporte/Carga/Leilao_Transportadora',
                'Gravidade'             => 90,
                'Img'                   => 'turboadmin/m-dashboard.png',
                'Icon'                  => 'rss',
                'Filhos'                => false,
            ),'Leilão de Caminhoneiro'=>Array(
                'Nome'                  => 'Leilão de Caminhoneiro',
                'Link'                  => 'Transporte/Carga/Leilao_Caminhoneiro',
                'Gravidade'             => 80,
                'Img'                   => 'turboadmin/m-dashboard.png',
                'Icon'                  => 'rss',
                'Filhos'                => false,
            ),'Dicas de Estradas'=>Array(
                'Nome'                  => 'Dicas de Estradas',
                'Link'                  => 'Transporte/Estrada/Estradas',
                'Gravidade'             => 75,
                'Img'                   => 'turboadmin/m-dashboard.png',
                'Icon'                  => 'rss',
                'Filhos'                => false,
            ),'Minhas Cargas'=>Array(
                'Nome'                  => 'Minhas Cargas',
                'Link'                  => 'Transporte/Carga/Cargas',
                'Gravidade'             => 70,
                'Img'                   => 'turboadmin/m-dashboard.png',
                'Icon'                  => 'truck',
                'Filhos'                => false,
            ),),
        ),
    );
};
$config_Permissoes = function (){
    return Array(
        Array(
            'Nome'                  => 'Transporte - Armazem (Painel)',
            'Desc'                  => '',
            'Chave'                 => 'Transporte_Armazem_Painel',
            'End'                   => 'Transporte/Armazem/Painel', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Transporte', // Modulo Referente
            'SubModulo'             => 'Armazem',   // Submodulo Referente
            'Metodo'                => 'Painel',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => 'Transporte - Armazem (Listagens)',
            'Desc'                  => '',
            'Chave'                 => 'Transporte_Armazem_Armazens',
            'End'                   => 'Transporte/Armazem/Armazens', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Transporte', // Modulo Referente
            'SubModulo'             => 'Armazem',   // Submodulo Referente
            'Metodo'                => 'Armazens',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => 'Transporte - Caminhoneiro (Painel)',
            'Desc'                  => '',
            'Chave'                 => 'Transporte_Caminhoneiro_Painel',
            'End'                   => 'Transporte/Caminhoneiro/Painel', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Transporte', // Modulo Referente
            'SubModulo'             => 'Caminhoneiro',   // Submodulo Referente
            'Metodo'                => 'Painel',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => 'Transporte - Caminhoneiro (Leilão)',
            'Desc'                  => '',
            'Chave'                 => 'Transporte_Carga_Leilao_Caminhoneiro',
            'End'                   => 'Transporte/Carga/Leilao_Caminhoneiro', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Transporte', // Modulo Referente
            'SubModulo'             => 'Carga',   // Submodulo Referente
            'Metodo'                => 'Leilao_Caminhoneiro',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => 'Transporte - Caminhoneiro (Listagens)',
            'Desc'                  => '',
            'Chave'                 => 'Transporte_Caminhoneiro_Caminhoneiros',
            'End'                   => 'Transporte/Caminhoneiro/Caminhoneiros', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Transporte', // Modulo Referente
            'SubModulo'             => 'Caminhoneiro',   // Submodulo Referente
            'Metodo'                => 'Caminhoneiros',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => 'Transporte - Administrar Dicas de Estradas',
            'Desc'                  => '',
            'Chave'                 => 'Transporte_Estrada_Estradas',
            'End'                   => 'Transporte/Estrada/Estradas', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Transporte', // Modulo Referente
            'SubModulo'             => 'Admin',   // Submodulo Referente
            'Metodo'                => '*',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => 'Transporte - Dicas de Estradas (Add)',
            'Desc'                  => '',
            'Chave'                 => 'Transporte_Estrada_Estradas_Add', // CHave unica nunca repete, chave primaria
            'End'                   => 'Transporte/Estrada/Estradas_Add', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Transporte', // Modulo Referente
            'SubModulo'             => 'Estrada',   // Submodulo Referente
            'Metodo'                => 'Estradas_Add,Estradas_Add2',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => 'Transporte - Dicas de Estradas (Editar)',
            'Desc'                  => '',
            'Chave'                 => 'Transporte_Estrada_Estradas_Edit', // CHave unica nunca repete, chave primaria
            'End'                   => 'Transporte/Estrada/Estradas_Edit', // Endereco que deve conter a url para permitir acesso // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Transporte', // Modulo Referente // Modulo Referente
            'SubModulo'             => 'Estrada',   // Submodulo Referente   // Submodulo Referente
            'Metodo'                => 'Estradas_Edit,Estradas_Edit2',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => 'Transporte - Dicas de Estradas (Deletar)',
            'Desc'                  => '',
            'Chave'                 => 'Transporte_Estrada_Estradas_Del', // CHave unica nunca repete, chave primaria
            'End'                   => 'Transporte/Estrada/Estradas_Del', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Transporte', // Modulo Referente
            'SubModulo'             => 'Estrada',   // Submodulo Referente
            'Metodo'                => 'Estradas_Del',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => 'Transporte - Minhas Cargas (Listagem)',
            'Desc'                  => '',
            'Chave'                 => 'Transporte_Carga_Cargas',
            'End'                   => 'Transporte/Carga/Cargas', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Transporte', // Modulo Referente
            'SubModulo'             => 'Carga',   // Submodulo Referente
            'Metodo'                => 'Cargas',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => 'Transporte - Minhas Cargas (Add)',
            'Desc'                  => '',
            'Chave'                 => 'Transporte_Carga_Cargas_Add', // CHave unica nunca repete, chave primaria
            'End'                   => 'Transporte/Carga/Cargas_Add', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Transporte', // Modulo Referente
            'SubModulo'             => 'Carga',   // Submodulo Referente
            'Metodo'                => 'Cargas_Add,Cargas_Add2',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => 'Transporte - Minhas Cargas (Editar)',
            'Desc'                  => '',
            'Chave'                 => 'Transporte_Carga_Cargas_Edit', // CHave unica nunca repete, chave primaria
            'End'                   => 'Transporte/Carga/Cargas_Edit', // Endereco que deve conter a url para permitir acesso // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Transporte', // Modulo Referente // Modulo Referente
            'SubModulo'             => 'Carga',   // Submodulo Referente   // Submodulo Referente
            'Metodo'                => 'Cargas_Edit,Cargas_Edit2',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => 'Transporte - Minhas Cargas (Deletar)',
            'Desc'                  => '',
            'Chave'                 => 'Transporte_Carga_Cargas_Del', // CHave unica nunca repete, chave primaria
            'End'                   => 'Transporte/Carga/Cargas_Del', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Transporte', // Modulo Referente
            'SubModulo'             => 'Carga',   // Submodulo Referente
            'Metodo'                => 'Cargas_Del',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => 'Transporte - Transportadora (Leilão)',
            'Desc'                  => '',
            'Chave'                 => 'Transporte_Carga_Leilao_Transportadora',
            'End'                   => 'Transporte/Carga/Leilao_Transportadora', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Transporte', // Modulo Referente
            'SubModulo'             => 'Carga',   // Submodulo Referente
            'Metodo'                => 'Leilao_Transportadora',  // Metodos referentes separados por virgula
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
