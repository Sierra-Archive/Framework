<?php
$config_Modulo = function () {
    return Array(
        'Nome'                      =>  'comercio_certificado',
        'Descrição'                 =>  '',
        'System_Require'            =>  '3.1.0',
        'Version'                   =>  '3.1.1',
        'Dependencias'              =>  Array('comercio','usuario'),
    );
};
$config_Menu = function () {
    return Array(
        'Administração'=>Array(
            'Filhos'                => Array('Tipos de Produtos'=>Array(
                'Nome'                  => __('Tipos de Produtos'),
                'Link'                  => 'comercio_certificado/Produto/Main',
                'Gravidade'             => 10,
                'Img'                   => 'turboadmin/m-dashboard.png',
                'Icon'                  => 'tags',
                'Filhos'                => FALSE,
            ),'Clientes'=>Array(
                'Nome'                  => __('Clientes'),
                'Link'                  => 'usuario/Admin/Main',
                'Gravidade'             => 9,
                'Img'                   => 'turboadmin/m-dashboard.png',
                'Icon'                  => 'user',
                'Filhos'                => FALSE,
            ),'Auditorias'=>Array(
                'Nome'                  => __('Auditorias'),
                'Link'                  => 'usuario/Admin/Main',
                'Gravidade'             => 8,
                'Img'                   => 'turboadmin/m-dashboard.png',
                'Icon'                  => 'briefcase',
                'Filhos'                => FALSE,
            ),'Relatório'=>Array(
                'Nome'                  => __('Relatório'),
                'Link'                  => 'usuario/Admin/Main',
                'Gravidade'             => 7,
                'Img'                   => 'turboadmin/m-dashboard.png',
                'Icon'                  => 'bar-chart',
                'Filhos'                => FALSE,
            ),),
        ),'Faturamento'=>Array(
            'Nome'                  => __('Faturamento'),
            'Link'                  => '#',
            'Gravidade'             => 9,
            'Img'                   => 'turboadmin/m-dashboard.png',
            'Icon'                  => 'money',
            'Filhos'                => Array('Faturar'=>Array(
                'Nome'                  => __('Faturar'),
                'Link'                  => '#',
                'Gravidade'             => 10,
                'Img'                   => 'turboadmin/m-dashboard.png',
                'Icon'                  => 'money',
                'Filhos'                => FALSE,
            ),'Cliente'=>Array(
                'Nome'                  => __('Cliente'),
                'Link'                  => '#',
                'Gravidade'             => 9,
                'Img'                   => 'turboadmin/m-dashboard.png',
                'Icon'                  => 'user',
                'Filhos'                => FALSE,
            ),'Baixa Banco'=>Array(
                'Nome'                  => __('Baixa Banco'),
                'Link'                  => 'usuario/Admin/Main',
                'Gravidade'             => 8,
                'Img'                   => 'turboadmin/m-dashboard.png',
                'Icon'                  => 'usd',
                'Filhos'                => FALSE,
            ),'Relatório'=>Array(
                'Nome'                  => __('Relatório'),
                'Link'                  => '#',
                'Gravidade'             => 7,
                'Img'                   => 'turboadmin/m-dashboard.png',
                'Icon'                  => 'bar-chart',
                'Filhos'                => FALSE,
            ),'Documentos'=>Array(
                'Nome'                  => __('Documentos'),
                'Link'                  => '#',
                'Gravidade'             => 6,
                'Img'                   => 'turboadmin/m-dashboard.png',
                'Icon'                  => 'briefcase',
                'Filhos'                => FALSE,
            ),'Produto'=>Array(
                'Nome'                  => __('Produto'),
                'Link'                  => '#',
                'Gravidade'             => 5,
                'Img'                   => 'turboadmin/m-dashboard.png',
                'Icon'                  => 'shopping-cart',
                'Filhos'                => FALSE,
            ),),
        ),
    );
};
$config_Permissoes = function () {
    return Array(
        Array(
            'Nome'                  => __('Certificações (Produtos) - Listagem'),
            'Desc'                  => '',
            'Chave'                 => 'comercio_certificado_Produto',
            'End'                   => 'comercio_certificado/Produto', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'comercio_certificado', // Modulo Referente
            'SubModulo'             => 'Produto',   // Submodulo Referente
            'Metodo'                => '*',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => __('Certificações (Produtos) - Add'),
            'Desc'                  => '',
            'Chave'                 => 'comercio_Produtos_Add', // CHave unica nunca repete, chave primaria
            'End'                   => 'comercio_certificado/Produto/Produtos_Add', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'comercio_certificado', // Modulo Referente
            'SubModulo'             => 'Produto',   // Submodulo Referente
            'Metodo'                => 'Produtos_Add,Produtos_Add2',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => __('Certificações (Produtos) - Editar'),
            'Desc'                  => '',
            'Chave'                 => 'comercio_Edit', // CHave unica nunca repete, chave primaria
            'End'                   => 'comercio_certificado/Produto/Produtos_Edit', // Endereco que deve conter a url para permitir acesso // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'comercio_certificado', // Modulo Referente // Modulo Referente
            'SubModulo'             => 'Produto',   // Submodulo Referente   // Submodulo Referente
            'Metodo'                => 'Produtos_Edit,Produtos_Edit2',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => __('Certificações (Produtos) - Deletar'),
            'Desc'                  => '',
            'Chave'                 => 'comercio_Del', // CHave unica nunca repete, chave primaria
            'End'                   => 'comercio_certificado/Produto/Produtos_Del', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'comercio_certificado', // Modulo Referente
            'SubModulo'             => 'Produto',   // Submodulo Referente
            'Metodo'                => 'Produtos_Del',  // Metodos referentes separados por virgula
        ),
        
        // Propostas
        Array(
            'Nome'                  => __('Certificações (Propostas/Clientes) - Listagem '),
            'Desc'                  => '',
            'Chave'                 => 'comercio_certificado_Proposta',
            'End'                   => 'comercio_certificado/Proposta', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'comercio_certificado', // Modulo Referente
            'SubModulo'             => 'Proposta',   // Submodulo Referente
            'Metodo'                => '*',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => __('Certificações (Propostas) - Add'),
            'Desc'                  => '',
            'Chave'                 => 'comercio_Propostas_Add', // CHave unica nunca repete, chave primaria
            'End'                   => 'comercio_certificado/Proposta/Propostas_Add', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'comercio_certificado', // Modulo Referente
            'SubModulo'             => 'Proposta',   // Submodulo Referente
            'Metodo'                => 'Propostas_Add,Propostas_Add2',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => __('Certificações (Propostas) - Editar'),
            'Desc'                  => '',
            'Chave'                 => 'comercio_Edit', // CHave unica nunca repete, chave primaria
            'End'                   => 'comercio_certificado/Proposta/Propostas_Edit', // Endereco que deve conter a url para permitir acesso // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'comercio_certificado', // Modulo Referente // Modulo Referente
            'SubModulo'             => 'Proposta',   // Submodulo Referente   // Submodulo Referente
            'Metodo'                => 'Propostas_Edit,Propostas_Edit2',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => __('Certificações (Propostas) - Deletar'),
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
$config_Funcional = function () {
    return Array();
};
/**
 * Configurações que podem ser Alteradas por Admin ou outros usuarios do Sistema (Parametros Opcionais: Mascara e Max
 * @return type
 * 
 * @author Ricardo Sierra <web@ricardosierra.com.br>
 */
$config_Publico = function () {
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
