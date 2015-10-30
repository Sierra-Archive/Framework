<?php
$config_Modulo = function () {
    return Array(
        'Nome'                      =>  'Engenharia',
        'Descrição'                 =>  '',
        'System_Require'            =>  '3.1.0',
        'Version'                   =>  '0.1.1',
        'Dependencias'              =>  false,
    );
};
$config_Menu = function () {
    return Array(
        'Empreendimentos' => Array(
            'Nome'                  => __('Engenharia'),
            'Link'                  => '#',
            'Gravidade'             => 80,
            'Img'                   => '',
            'Icon'                  => 'building',
            'Filhos'                => Array('Retirar do Estoque'=>Array(
                'Nome'                  => __('Retirar do Estoque'),
                'Link'                  => 'Engenharia/Empreendimento/Estoque_Retirar',
                'Gravidade'             => 100,
                'Img'                   => '',
                'Icon'                  => 'truck',
                'Permissao_Func'        => Array(// Permissoes NEcessarias
                    'comercio_Produto' => true
                ),
                'Filhos'                => false,
            ),'Retirar do Estoque'=>Array(
                'Nome'                  => __('Adicionar Conta a Receber'),
                'Link'                  => 'Engenharia/Empreendimento/Empreendimento_Receber',
                'Gravidade'             => 95,
                'Img'                   => '',
                'Icon'                  => 'money',
                'Filhos'                => false,
            ),'Empreendimentos'=>Array(
                'Nome'                  => __('Empreendimentos'),
                'Link'                  => 'Engenharia/Empreendimento/Empreendimentos',
                'Gravidade'             => 90,
                'Img'                   => '',
                'Icon'                  => 'building',
                'Filhos'                => false,
            ),'Empreendimentos'=>Array(
                'Nome'                  => __('Unidades'),
                'Link'                  => 'Engenharia/Unidade/Unidades',
                'Gravidade'             => 80,
                'Img'                   => '',
                'Icon'                  => 'home',
                'Filhos'                => false,
            ),'Equipamentos'=>Array(
                'Nome'                  => __('Equipamentos'),
                'Link'                  => 'Engenharia/Equipamento/Equipamentos',
                'Gravidade'             => 60,
                'Img'                   => '',
                'Icon'                  => 'laptop',
                'Filhos'                => false,
            ),),
        ),
    );
};
$config_Permissoes = function () {
    return Array(
        Array(
            'Nome'                  => __('Engenharia (Empreendimentos) - Gerenciar Estoque'),
            'Desc'                  => '',
            'Chave'                 => 'Engenharia_Empreendimento_Estoque_Retirar',
            'End'                   => 'Engenharia/Empreendimento/Estoque_Retirar', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Engenharia', // Modulo Referente
            'SubModulo'             => 'Empreendimento',   // Submodulo Referente
            'Metodo'                => 'Empreendimentos_Add,Empreendimentos_Add2',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => __('Engenharia (Empreendimentos) - Financeiro'),
            'Desc'                  => __('Gerenciar Contas a Receber'),
            'Chave'                 => 'Engenharia_Empreendimento_Empreendimento_Receber',
            'End'                   => 'Engenharia/Empreendimento/Empreendimento_Receber', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Engenharia', // Modulo Referente
            'SubModulo'             => 'Empreendimento',   // Submodulo Referente
            'Metodo'                => 'Empreendimento_Receber',  // Metodos referentes separados por virgula
        ),
        
        // Unidades
        Array(
            'Nome'                  => __('Engenharia (Unidades) - Listagem '),
            'Desc'                  => '',
            'Chave'                 => 'Engenharia_Unidade',
            'End'                   => 'Engenharia/Unidade', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Engenharia', // Modulo Referente
            'SubModulo'             => 'Unidade',   // Submodulo Referente
            'Metodo'                => '*',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => __('Engenharia (Unidade) - Add'),
            'Desc'                  => '',
            'Chave'                 => 'Engenharia_Unidade_Unidades_Add', // CHave unica nunca repete, chave primaria
            'End'                   => 'Engenharia/Unidade/Unidades_Add', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Engenharia', // Modulo Referente
            'SubModulo'             => 'Unidade',   // Submodulo Referente
            'Metodo'                => 'Unidades_Add,Unidades_Add2',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => __('Engenharia (Unidade) - Editar'),
            'Desc'                  => '',
            'Chave'                 => 'Engenharia_Unidade_Unidades_Edit', // CHave unica nunca repete, chave primaria
            'End'                   => 'Engenharia/Unidade/Unidades_Edit', // Endereco que deve conter a url para permitir acesso // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Engenharia', // Modulo Referente // Modulo Referente
            'SubModulo'             => 'Unidade',   // Submodulo Referente   // Submodulo Referente
            'Metodo'                => 'Unidades_Edit,Unidades_Edit2',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => __('Engenharia (Unidade) - Deletar'),
            'Desc'                  => '',
            'Chave'                 => 'Engenharia_Unidade_Unidades_Del', // CHave unica nunca repete, chave primaria
            'End'                   => 'Engenharia/Unidade/Unidades_Del', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Engenharia', // Modulo Referente
            'SubModulo'             => 'Unidade',   // Submodulo Referente
            'Metodo'                => 'Unidades_Del',  // Metodos referentes separados por virgula
        ),
        
        // Empreendimentos
        Array(
            'Nome'                  => __('Engenharia (Empreendimentos) - Listagem'),
            'Desc'                  => '',
            'Chave'                 => 'Engenharia_Empreendimento_Empreendimentos',
            'End'                   => 'Engenharia/Empreendimento/Empreendimentos', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Engenharia', // Modulo Referente
            'SubModulo'             => 'Empreendimento',   // Submodulo Referente
            'Metodo'                => 'Empreendimentos',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => __('Engenharia (Empreendimento) - Add'),
            'Desc'                  => '',
            'Chave'                 => 'Engenharia_Empreendimento_Empreendimentos_Add', // CHave unica nunca repete, chave primaria
            'End'                   => 'Engenharia/Empreendimento/Empreendimentos_Add', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Engenharia', // Modulo Referente
            'SubModulo'             => 'Empreendimento',   // Submodulo Referente
            'Metodo'                => 'Empreendimentos_Add,Empreendimentos_Add2',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => __('Engenharia (Empreendimento) - Editar'),
            'Desc'                  => '',
            'Chave'                 => 'Engenharia_Empreendimento_Empreendimentos_Edit', // CHave unica nunca repete, chave primaria
            'End'                   => 'Engenharia/Empreendimento/Empreendimentos_Edit', // Endereco que deve conter a url para permitir acesso // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Engenharia', // Modulo Referente // Modulo Referente
            'SubModulo'             => 'Empreendimento',   // Submodulo Referente   // Submodulo Referente
            'Metodo'                => 'Empreendimentos_Edit,Empreendimentos_Edit2',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => __('Engenharia (Empreendimento) - Deletar'),
            'Desc'                  => '',
            'Chave'                 => 'Engenharia_Empreendimento_Empreendimentos_Del', // CHave unica nunca repete, chave primaria
            'End'                   => 'Engenharia/Empreendimento/Empreendimentos_Del', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Engenharia', // Modulo Referente
            'SubModulo'             => 'Empreendimento',   // Submodulo Referente
            'Metodo'                => 'Empreendimentos_Del',  // Metodos referentes separados por virgula
        ),
        
        // Equipamentos
        Array(
            'Nome'                  => __('Engenharia (Equipamentos) - Listagem '),
            'Desc'                  => '',
            'Chave'                 => 'Engenharia_Equipamento',
            'End'                   => 'Engenharia/Equipamento', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Engenharia', // Modulo Referente
            'SubModulo'             => 'Equipamento',   // Submodulo Referente
            'Metodo'                => '*',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => __('Engenharia (Equipamento) - Add'),
            'Desc'                  => '',
            'Chave'                 => 'Engenharia_Equipamento_Equipamentos_Add', // CHave unica nunca repete, chave primaria
            'End'                   => 'Engenharia/Equipamento/Equipamentos_Add', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Engenharia', // Modulo Referente
            'SubModulo'             => 'Equipamento',   // Submodulo Referente
            'Metodo'                => 'Equipamentos_Add,Equipamentos_Add2',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => __('Engenharia (Equipamento) - Editar'),
            'Desc'                  => '',
            'Chave'                 => 'Engenharia_Equipamento_Equipamentos_Edit', // CHave unica nunca repete, chave primaria
            'End'                   => 'Engenharia/Equipamento/Equipamentos_Edit', // Endereco que deve conter a url para permitir acesso // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Engenharia', // Modulo Referente // Modulo Referente
            'SubModulo'             => 'Equipamento',   // Submodulo Referente   // Submodulo Referente
            'Metodo'                => 'Equipamentos_Edit,Equipamentos_Edit2',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => __('Engenharia (Equipamento) - Deletar'),
            'Desc'                  => '',
            'Chave'                 => 'Engenharia_Equipamento_Equipamentos_Del', // CHave unica nunca repete, chave primaria
            'End'                   => 'Engenharia/Equipamento/Equipamentos_Del', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Engenharia', // Modulo Referente
            'SubModulo'             => 'Equipamento',   // Submodulo Referente
            'Metodo'                => 'Equipamentos_Del',  // Metodos referentes separados por virgula
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
