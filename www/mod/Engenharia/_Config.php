<?php
$config_Modulo = function (){
    return Array(
        'Nome'                      =>  'Engenharia',
        'Descrição'                 =>  '',
        'System_Require'            =>  '3.0.0',
        'Version'                   =>  '0.1.1',
        'Dependencias'              =>  false,
    );
};
$config_Menu = function (){
    return Array(
        'Empreendimentos' => Array(
            'Nome'                  => 'Engenharia',
            'Link'                  => '#',
            'Gravidade'             => 80,
            'Img'                   => '',
            'Icon'                  => 'building',
            'Filhos'                => Array('Retirar do Estoque'=>Array(
                'Nome'                  => 'Retirar do Estoque',
                'Link'                  => 'Engenharia/Empreendimento/Estoque_Retirar',
                'Gravidade'             => 100,
                'Img'                   => '',
                'Icon'                  => 'truck',
                'Permissao_Func'        => Array(// Permissoes NEcessarias
                    'comercio_Produto' => true
                ),
                'Filhos'                => false,
            ),'Retirar do Estoque'=>Array(
                'Nome'                  => 'Adicionar Conta a Receber',
                'Link'                  => 'Engenharia/Empreendimento/Empreendimento_Receber',
                'Gravidade'             => 95,
                'Img'                   => '',
                'Icon'                  => 'money',
                'Filhos'                => false,
            ),'Empreendimentos'=>Array(
                'Nome'                  => 'Empreendimentos',
                'Link'                  => 'Engenharia/Empreendimento/Empreendimentos',
                'Gravidade'             => 90,
                'Img'                   => '',
                'Icon'                  => 'building',
                'Filhos'                => false,
            ),'Empreendimentos'=>Array(
                'Nome'                  => 'Unidades',
                'Link'                  => 'Engenharia/Unidade/Unidades',
                'Gravidade'             => 80,
                'Img'                   => '',
                'Icon'                  => 'home',
                'Filhos'                => false,
            ),'Equipamentos'=>Array(
                'Nome'                  => 'Equipamentos',
                'Link'                  => 'Engenharia/Equipamento/Equipamentos',
                'Gravidade'             => 60,
                'Img'                   => '',
                'Icon'                  => 'laptop',
                'Filhos'                => false,
            ),),
        ),
    );
};
$config_Permissoes = function (){
    return Array(
        Array(
            'Nome'                  => 'Engenharia (Empreendimentos) - Gerenciar Estoque',
            'Desc'                  => '',
            'Chave'                 => 'Engenharia_Empreendimento_Estoque_Retirar',
            'End'                   => 'Engenharia/Empreendimento/Estoque_Retirar', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Engenharia', // Modulo Referente
            'SubModulo'             => 'Empreendimento',   // Submodulo Referente
            'Metodo'                => 'Empreendimentos_Add,Empreendimentos_Add2',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => 'Engenharia (Empreendimentos) - Financeiro',
            'Desc'                  => 'Gerenciar Contas a Receber',
            'Chave'                 => 'Engenharia_Empreendimento_Empreendimento_Receber',
            'End'                   => 'Engenharia/Empreendimento/Empreendimento_Receber', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Engenharia', // Modulo Referente
            'SubModulo'             => 'Empreendimento',   // Submodulo Referente
            'Metodo'                => 'Empreendimento_Receber',  // Metodos referentes separados por virgula
        ),
        
        // Unidades
        Array(
            'Nome'                  => 'Engenharia (Unidades) - Listagem ',
            'Desc'                  => '',
            'Chave'                 => 'Engenharia_Unidade',
            'End'                   => 'Engenharia/Unidade', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Engenharia', // Modulo Referente
            'SubModulo'             => 'Unidade',   // Submodulo Referente
            'Metodo'                => '*',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => 'Engenharia (Unidade) - Add',
            'Desc'                  => '',
            'Chave'                 => 'Engenharia_Unidade_Unidades_Add', // CHave unica nunca repete, chave primaria
            'End'                   => 'Engenharia/Unidade/Unidades_Add', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Engenharia', // Modulo Referente
            'SubModulo'             => 'Unidade',   // Submodulo Referente
            'Metodo'                => 'Unidades_Add,Unidades_Add2',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => 'Engenharia (Unidade) - Editar',
            'Desc'                  => '',
            'Chave'                 => 'Engenharia_Unidade_Unidades_Edit', // CHave unica nunca repete, chave primaria
            'End'                   => 'Engenharia/Unidade/Unidades_Edit', // Endereco que deve conter a url para permitir acesso // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Engenharia', // Modulo Referente // Modulo Referente
            'SubModulo'             => 'Unidade',   // Submodulo Referente   // Submodulo Referente
            'Metodo'                => 'Unidades_Edit,Unidades_Edit2',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => 'Engenharia (Unidade) - Deletar',
            'Desc'                  => '',
            'Chave'                 => 'Engenharia_Unidade_Unidades_Del', // CHave unica nunca repete, chave primaria
            'End'                   => 'Engenharia/Unidade/Unidades_Del', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Engenharia', // Modulo Referente
            'SubModulo'             => 'Unidade',   // Submodulo Referente
            'Metodo'                => 'Unidades_Del',  // Metodos referentes separados por virgula
        ),
        
        // Empreendimentos
        Array(
            'Nome'                  => 'Engenharia (Empreendimentos) - Listagem',
            'Desc'                  => '',
            'Chave'                 => 'Engenharia_Empreendimento_Empreendimentos',
            'End'                   => 'Engenharia/Empreendimento/Empreendimentos', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Engenharia', // Modulo Referente
            'SubModulo'             => 'Empreendimento',   // Submodulo Referente
            'Metodo'                => 'Empreendimentos',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => 'Engenharia (Empreendimento) - Add',
            'Desc'                  => '',
            'Chave'                 => 'Engenharia_Empreendimento_Empreendimentos_Add', // CHave unica nunca repete, chave primaria
            'End'                   => 'Engenharia/Empreendimento/Empreendimentos_Add', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Engenharia', // Modulo Referente
            'SubModulo'             => 'Empreendimento',   // Submodulo Referente
            'Metodo'                => 'Empreendimentos_Add,Empreendimentos_Add2',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => 'Engenharia (Empreendimento) - Editar',
            'Desc'                  => '',
            'Chave'                 => 'Engenharia_Empreendimento_Empreendimentos_Edit', // CHave unica nunca repete, chave primaria
            'End'                   => 'Engenharia/Empreendimento/Empreendimentos_Edit', // Endereco que deve conter a url para permitir acesso // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Engenharia', // Modulo Referente // Modulo Referente
            'SubModulo'             => 'Empreendimento',   // Submodulo Referente   // Submodulo Referente
            'Metodo'                => 'Empreendimentos_Edit,Empreendimentos_Edit2',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => 'Engenharia (Empreendimento) - Deletar',
            'Desc'                  => '',
            'Chave'                 => 'Engenharia_Empreendimento_Empreendimentos_Del', // CHave unica nunca repete, chave primaria
            'End'                   => 'Engenharia/Empreendimento/Empreendimentos_Del', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Engenharia', // Modulo Referente
            'SubModulo'             => 'Empreendimento',   // Submodulo Referente
            'Metodo'                => 'Empreendimentos_Del',  // Metodos referentes separados por virgula
        ),
        
        // Equipamentos
        Array(
            'Nome'                  => 'Engenharia (Equipamentos) - Listagem ',
            'Desc'                  => '',
            'Chave'                 => 'Engenharia_Equipamento',
            'End'                   => 'Engenharia/Equipamento', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Engenharia', // Modulo Referente
            'SubModulo'             => 'Equipamento',   // Submodulo Referente
            'Metodo'                => '*',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => 'Engenharia (Equipamento) - Add',
            'Desc'                  => '',
            'Chave'                 => 'Engenharia_Equipamento_Equipamentos_Add', // CHave unica nunca repete, chave primaria
            'End'                   => 'Engenharia/Equipamento/Equipamentos_Add', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Engenharia', // Modulo Referente
            'SubModulo'             => 'Equipamento',   // Submodulo Referente
            'Metodo'                => 'Equipamentos_Add,Equipamentos_Add2',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => 'Engenharia (Equipamento) - Editar',
            'Desc'                  => '',
            'Chave'                 => 'Engenharia_Equipamento_Equipamentos_Edit', // CHave unica nunca repete, chave primaria
            'End'                   => 'Engenharia/Equipamento/Equipamentos_Edit', // Endereco que deve conter a url para permitir acesso // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Engenharia', // Modulo Referente // Modulo Referente
            'SubModulo'             => 'Equipamento',   // Submodulo Referente   // Submodulo Referente
            'Metodo'                => 'Equipamentos_Edit,Equipamentos_Edit2',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => 'Engenharia (Equipamento) - Deletar',
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
$config_Funcional = function (){
    return Array();
};
?>
