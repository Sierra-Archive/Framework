<?php
$config_Modulo = function (){
    return Array(
        'Nome'                      =>  'comercio_certificado',
        'Descrição'                 =>  '',
        'System_Require'            =>  '2.21.1',
        'Version'                   =>  '0.0.1',
        'Dependencias'              =>  Array('comercio','usuario'),
    );
};
$config_Menu = function (){
    return Array(
        'Administração'=>Array(
            'Filhos'                => Array('Tipos de Produtos'=>Array(
                'Nome'                  => 'Tipos de Produtos',
                'Link'                  => 'comercio_certificado/Produto/Main',
                'Gravidade'             => 10,
                'Img'                   => 'turboadmin/m-dashboard.png',
                'Icon'                  => 'tags',
                'Filhos'                => false,
            ),'Clientes'=>Array(
                'Nome'                  => 'Clientes',
                'Link'                  => 'usuario/Admin/Main',
                'Gravidade'             => 9,
                'Img'                   => 'turboadmin/m-dashboard.png',
                'Icon'                  => 'user',
                'Filhos'                => false,
            ),'Auditorias'=>Array(
                'Nome'                  => 'Auditorias',
                'Link'                  => 'usuario/Admin/Main',
                'Gravidade'             => 8,
                'Img'                   => 'turboadmin/m-dashboard.png',
                'Icon'                  => 'briefcase',
                'Filhos'                => false,
            ),'Relatórios'=>Array(
                'Nome'                  => 'Relatórios',
                'Link'                  => 'usuario/Admin/Main',
                'Gravidade'             => 7,
                'Img'                   => 'turboadmin/m-dashboard.png',
                'Icon'                  => 'bar-chart',
                'Filhos'                => false,
            ),),
        ),'Faturamento'=>Array(
            'Nome'                  => 'Faturamento',
            'Link'                  => '#',
            'Gravidade'             => 9,
            'Img'                   => 'turboadmin/m-dashboard.png',
            'Icon'                  => 'money',
            'Filhos'                => Array('Faturar'=>Array(
                'Nome'                  => 'Faturar',
                'Link'                  => '#',
                'Gravidade'             => 10,
                'Img'                   => 'turboadmin/m-dashboard.png',
                'Icon'                  => 'money',
                'Filhos'                => false,
            ),'Cliente'=>Array(
                'Nome'                  => 'Cliente',
                'Link'                  => '#',
                'Gravidade'             => 9,
                'Img'                   => 'turboadmin/m-dashboard.png',
                'Icon'                  => 'user',
                'Filhos'                => false,
            ),'Baixa Banco'=>Array(
                'Nome'                  => 'Baixa Banco',
                'Link'                  => 'usuario/Admin/Main',
                'Gravidade'             => 8,
                'Img'                   => 'turboadmin/m-dashboard.png',
                'Icon'                  => 'usd',
                'Filhos'                => false,
            ),'Relatórios'=>Array(
                'Nome'                  => 'Relatórios',
                'Link'                  => '#',
                'Gravidade'             => 7,
                'Img'                   => 'turboadmin/m-dashboard.png',
                'Icon'                  => 'bar-chart',
                'Filhos'                => false,
            ),'Documentos'=>Array(
                'Nome'                  => 'Documentos',
                'Link'                  => '#',
                'Gravidade'             => 6,
                'Img'                   => 'turboadmin/m-dashboard.png',
                'Icon'                  => 'briefcase',
                'Filhos'                => false,
            ),'Produto'=>Array(
                'Nome'                  => 'Produto',
                'Link'                  => '#',
                'Gravidade'             => 5,
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
            'Nome'                  => 'Certificações (Produtos) - Listagem',
            'Desc'                  => '',
            'Chave'                 => 'comercio_certificado_Produto',
            'End'                   => 'comercio_certificado/Produto', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'comercio_certificado', // Modulo Referente
            'SubModulo'             => 'Produto',   // Submodulo Referente
            'Metodo'                => '*',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => 'Certificações (Produtos) - Add',
            'Desc'                  => '',
            'Chave'                 => 'comercio_Produtos_Add', // CHave unica nunca repete, chave primaria
            'End'                   => 'comercio_certificado/Produto/Produtos_Add', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'comercio_certificado', // Modulo Referente
            'SubModulo'             => 'Produto',   // Submodulo Referente
            'Metodo'                => 'Produtos_Add,Produtos_Add2',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => 'Certificações (Produtos) - Editar',
            'Desc'                  => '',
            'Chave'                 => 'comercio_Edit', // CHave unica nunca repete, chave primaria
            'End'                   => 'comercio_certificado/Produto/Produtos_Edit', // Endereco que deve conter a url para permitir acesso // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'comercio_certificado', // Modulo Referente // Modulo Referente
            'SubModulo'             => 'Produto',   // Submodulo Referente   // Submodulo Referente
            'Metodo'                => 'Produtos_Edit,Produtos_Edit2',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => 'Certificações (Produtos) - Deletar',
            'Desc'                  => '',
            'Chave'                 => 'comercio_Del', // CHave unica nunca repete, chave primaria
            'End'                   => 'comercio_certificado/Produto/Produtos_del', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'comercio_certificado', // Modulo Referente
            'SubModulo'             => 'Produto',   // Submodulo Referente
            'Metodo'                => 'Produtos_del',  // Metodos referentes separados por virgula
        ),
        
        // Propostas
        Array(
            'Nome'                  => 'Certificações (Propostas/Clientes) - Listagem ',
            'Desc'                  => '',
            'Chave'                 => 'comercio_certificado_Proposta',
            'End'                   => 'comercio_certificado/Proposta', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'comercio_certificado', // Modulo Referente
            'SubModulo'             => 'Proposta',   // Submodulo Referente
            'Metodo'                => '*',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => 'Certificações (Propostas) - Add',
            'Desc'                  => '',
            'Chave'                 => 'comercio_Propostas_Add', // CHave unica nunca repete, chave primaria
            'End'                   => 'comercio_certificado/Proposta/Propostas_Add', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'comercio_certificado', // Modulo Referente
            'SubModulo'             => 'Proposta',   // Submodulo Referente
            'Metodo'                => 'Propostas_Add,Propostas_Add2',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => 'Certificações (Propostas) - Editar',
            'Desc'                  => '',
            'Chave'                 => 'comercio_Edit', // CHave unica nunca repete, chave primaria
            'End'                   => 'comercio_certificado/Proposta/Propostas_Edit', // Endereco que deve conter a url para permitir acesso // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'comercio_certificado', // Modulo Referente // Modulo Referente
            'SubModulo'             => 'Proposta',   // Submodulo Referente   // Submodulo Referente
            'Metodo'                => 'Propostas_Edit,Propostas_Edit2',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => 'Certificações (Propostas) - Deletar',
            'Desc'                  => '',
            'Chave'                 => 'comercio_Del', // CHave unica nunca repete, chave primaria
            'End'                   => 'comercio_certificado/Proposta/Propostas_Del', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'comercio_certificado', // Modulo Referente
            'SubModulo'             => 'Proposta',   // Submodulo Referente
            'Metodo'                => 'Propostas_Del',  // Metodos referentes separados por virgula
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
