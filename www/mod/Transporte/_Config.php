<?php
$config_Modulo = function (){
    return Array(
        'Nome'                      =>  'Transporte',
        'Descrição'                 =>  '',
        'System_Require'            =>  '3.1.0',
        'Version'                   =>  '3.1.1',
        'Dependencias'              =>  false,
    );
};
$config_Menu = function (){
    return Array(
        'Fornecedores'=>Array(
            'Nome'                  => __('Fornecedores'),
            'Link'                  => 'Transporte/Fornecedor/Fornecedores',
            'Gravidade'             => 75,
            'Img'                   => 'turboadmin/m-dashboard.png',
            'Icon'                  => 'tags',
            'Filhos'                => false,
        ),
        'Transportadoras'=>Array(
            'Nome'                  => __('Transportadoras'),
            'Link'                  => 'Transporte/Transportadora/Transportadoras',
            'Gravidade'             => 75,
            'Img'                   => 'turboadmin/m-dashboard.png',
            'Icon'                  => 'road',
            'Filhos'                => false,
        ),
        'Armazens'=>Array(
            'Nome'                  => __('Armazens'),
            'Link'                  => 'Transporte/Armazem/Armazens',
            'Gravidade'             => 75,
            'Img'                   => 'turboadmin/m-dashboard.png',
            'Icon'                  => 'archive',
            'Filhos'                => false,
        ),
        'Autonômos'=>Array(
            'Nome'                  => __('Autonômos'),
            'Link'                  => 'Transporte/Caminhoneiro/Caminhoneiros',
            'Gravidade'             => 70,
            'Img'                   => 'turboadmin/m-dashboard.png',
            'Icon'                  => 'truck',
            'Filhos'                => false,
        ),'Administrar'=>Array(
            'Filhos'                => Array('Dicas de Estradas'=>Array(
                'Nome'                  => __('Dicas de Estradas'),
                'Link'                  => 'Transporte/Estrada/Estradas',
                'Gravidade'             => 75,
                'Img'                   => 'turboadmin/m-dashboard.png',
                'Icon'                  => 'warning-sign',
                'Filhos'                => false,
            ),),
        ),'Pedido de Trans.'=>Array(
            'Nome'                  => __('Pedido de Trans.'),
            'Link'                  => '#',
            'Gravidade'             => 80,
            'Img'                   => '',
            'Icon'                  => 'road',
            'Filhos'                => Array('Propostas Fechadas'=>Array(
                'Nome'                  => __('Propostas Fechadas'),
                'Link'                  => 'Transporte/Pedido/Trans_Ped_Aceitas',
                'Gravidade'             => 80,
                'Img'                   => 'turboadmin/m-dashboard.png',
                'Icon'                  => 'road',
                'Filhos'                => false,
            ),'Meus Pedidos'=>Array(
                'Nome'                  => __('Meus Pedidos'),
                'Link'                  => 'Transporte/Pedido/Trans_Ped_Minhas',
                'Gravidade'             => 70,
                'Img'                   => 'turboadmin/m-dashboard.png',
                'Icon'                  => 'road',
                'Filhos'                => false,
            ),'Propostas Novas'=>Array(
                'Nome'                  => __('Propostas Novas'),
                'Link'                  => 'Transporte/Pedido/Trans_Ped_Novas',
                'Gravidade'             => 60,
                'Img'                   => 'turboadmin/m-dashboard.png',
                'Icon'                  => 'road',
                'Filhos'                => false,
            ),'Adicionar Pedido'=>Array(
                'Nome'                  => __('Adicionar Pedido'),
                'Link'                  => 'Transporte/Pedido/Trans_Ped_Add',
                'Gravidade'             => 50,
                'Img'                   => 'turboadmin/m-dashboard.png',
                'Icon'                  => 'road',
                'Filhos'                => false,
            ),'Propostas Aceitas'=>Array(
                'Nome'                  => __('Propostas Aceitas'),
                'Link'                  => 'Transporte/Pedido/Trans_Sol_PedAceitos',
                'Gravidade'             => 40,
                'Img'                   => 'turboadmin/m-dashboard.png',
                'Icon'                  => 'road',
                'Filhos'                => false,
            ),'Propostas Pendentes'=>Array(
                'Nome'                  => __('Propostas Pendentes'),
                'Link'                  => 'Transporte/Pedido/Trans_Sol_PedPendente',
                'Gravidade'             => 30,
                'Img'                   => 'turboadmin/m-dashboard.png',
                'Icon'                  => 'road',
                'Filhos'                => false,
            ),'Propostas Recusadas'=>Array(
                'Nome'                  => __('Propostas Recusadas'),
                'Link'                  => 'Transporte/Pedido/Trans_Sol_PedRecusados',
                'Gravidade'             => 20,
                'Img'                   => 'turboadmin/m-dashboard.png',
                'Icon'                  => 'road',
                'Filhos'                => false,
            ),'Ver Novos Pedidos'=>Array(
                'Nome'                  => __('Ver Novos Pedidos'),
                'Link'                  => 'Transporte/Pedido/Trans_Sol_Solicitacoes',
                'Gravidade'             => 10,
                'Img'                   => 'turboadmin/m-dashboard.png',
                'Icon'                  => 'road',
                'Filhos'                => false,
            )),
        ),'Pedido de Auto.'=>Array(
            'Nome'                  => __('Pedido de Auto.'),
            'Link'                  => '#',
            'Gravidade'             => 80,
            'Img'                   => '',
            'Icon'                  => 'truck',
            'Filhos'                => Array('Propostas Fechadas'=>Array(
                'Nome'                  => __('Propostas Fechadas'),
                'Link'                  => 'Transporte/Pedido/Caminho_Ped_Aceitas',
                'Gravidade'             => 80,
                'Img'                   => 'turboadmin/m-dashboard.png',
                'Icon'                  => 'truck',
                'Filhos'                => false,
            ),'Meus Pedidos'=>Array(
                'Nome'                  => __('Meus Pedidos'),
                'Link'                  => 'Transporte/Pedido/Caminho_Ped_Minhas',
                'Gravidade'             => 70,
                'Img'                   => 'turboadmin/m-dashboard.png',
                'Icon'                  => 'truck',
                'Filhos'                => false,
            ),'Propostas Novas'=>Array(
                'Nome'                  => __('Propostas Novas'),
                'Link'                  => 'Transporte/Pedido/Caminho_Ped_Novas',
                'Gravidade'             => 60,
                'Img'                   => 'turboadmin/m-dashboard.png',
                'Icon'                  => 'truck',
                'Filhos'                => false,
            ),'Adicionar Pedido'=>Array(
                'Nome'                  => __('Adicionar Pedido'),
                'Link'                  => 'Transporte/Pedido/Caminho_Ped_Add',
                'Gravidade'             => 50,
                'Img'                   => 'turboadmin/m-dashboard.png',
                'Icon'                  => 'truck',
                'Filhos'                => false,
            ),'Propostas Aceitas'=>Array(
                'Nome'                  => __('Propostas Aceitas'),
                'Link'                  => 'Transporte/Pedido/Caminho_Sol_PedAceitos',
                'Gravidade'             => 40,
                'Img'                   => 'turboadmin/m-dashboard.png',
                'Icon'                  => 'truck',
                'Filhos'                => false,
            ),'Propostas Pendentes'=>Array(
                'Nome'                  => __('Propostas Pendentes'),
                'Link'                  => 'Transporte/Pedido/Caminho_Sol_PedPendente',
                'Gravidade'             => 30,
                'Img'                   => 'turboadmin/m-dashboard.png',
                'Icon'                  => 'truck',
                'Filhos'                => false,
            ),'Propostas Recusadas'=>Array(
                'Nome'                  => __('Propostas Recusadas'),
                'Link'                  => 'Transporte/Pedido/Caminho_Sol_PedRecusados',
                'Gravidade'             => 20,
                'Img'                   => 'turboadmin/m-dashboard.png',
                'Icon'                  => 'truck',
                'Filhos'                => false,
            ),'Ver Novos Pedidos'=>Array(
                'Nome'                  => __('Ver Novos Pedidos'),
                'Link'                  => 'Transporte/Pedido/Caminho_Sol_Solicitacoes',
                'Gravidade'             => 10,
                'Img'                   => 'turboadmin/m-dashboard.png',
                'Icon'                  => 'truck',
                'Filhos'                => false,
            )),
        ),'Pedido de Arma.'=>Array(
            'Nome'                  => __('Pedido de Arma.'),
            'Link'                  => '#',
            'Gravidade'             => 80,
            'Img'                   => '',
            'Icon'                  => 'archive',
            'Filhos'                => Array('Propostas Fechadas'=>Array(
                'Nome'                  => __('Propostas Fechadas'),
                'Link'                  => 'Transporte/Pedido/Arma_Ped_Aceitas',
                'Gravidade'             => 80,
                'Img'                   => 'turboadmin/m-dashboard.png',
                'Icon'                  => 'archive',
                'Filhos'                => false,
            ),'Meus Pedidos'=>Array(
                'Nome'                  => __('Meus Pedidos'),
                'Link'                  => 'Transporte/Pedido/Arma_Ped_Minhas',
                'Gravidade'             => 70,
                'Img'                   => 'turboadmin/m-dashboard.png',
                'Icon'                  => 'archive',
                'Filhos'                => false,
            ),'Propostas Novas'=>Array(
                'Nome'                  => __('Propostas Novas'),
                'Link'                  => 'Transporte/Pedido/Arma_Ped_Novas',
                'Gravidade'             => 60,
                'Img'                   => 'turboadmin/m-dashboard.png',
                'Icon'                  => 'archive',
                'Filhos'                => false,
            ),'Adicionar Pedido'=>Array(
                'Nome'                  => __('Adicionar Pedido'),
                'Link'                  => 'Transporte/Pedido/Arma_Ped_Add',
                'Gravidade'             => 50,
                'Img'                   => 'turboadmin/m-dashboard.png',
                'Icon'                  => 'archive',
                'Filhos'                => false,
            ),'Propostas Aceitas'=>Array(
                'Nome'                  => __('Propostas Aceitas'),
                'Link'                  => 'Transporte/Pedido/Arma_Sol_PedAceitos',
                'Gravidade'             => 40,
                'Img'                   => 'turboadmin/m-dashboard.png',
                'Icon'                  => 'archive',
                'Filhos'                => false,
            ),'Propostas Pendentes'=>Array(
                'Nome'                  => __('Propostas Pendentes'),
                'Link'                  => 'Transporte/Pedido/Arma_Sol_PedPendente',
                'Gravidade'             => 30,
                'Img'                   => 'turboadmin/m-dashboard.png',
                'Icon'                  => 'archive',
                'Filhos'                => false,
            ),'Propostas Recusadas'=>Array(
                'Nome'                  => __('Propostas Recusadas'),
                'Link'                  => 'Transporte/Pedido/Arma_Sol_PedRecusados',
                'Gravidade'             => 20,
                'Img'                   => 'turboadmin/m-dashboard.png',
                'Icon'                  => 'archive',
                'Filhos'                => false,
            ),'Ver Novos Pedidos'=>Array(
                'Nome'                  => __('Ver Novos Pedidos'),
                'Link'                  => 'Transporte/Pedido/Arma_Sol_Solicitacoes',
                'Gravidade'             => 10,
                'Img'                   => 'turboadmin/m-dashboard.png',
                'Icon'                  => 'archive',
                'Filhos'                => false,
            )),
        ),
    );
};
$config_Permissoes = function (){
    return Array(
        Array(
            'Nome'                  => __('Transporte - Transportadora (Painel)'),
            'Desc'                  => '',
            'Chave'                 => 'Transporte_Transportadora_Painel',
            'End'                   => 'Transporte/Transportadora/Painel', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Transporte', // Modulo Referente
            'SubModulo'             => 'Transportadora',   // Submodulo Referente
            'Metodo'                => 'Painel',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => __('Transporte - Transportadora (Listagens)'),
            'Desc'                  => '',
            'Chave'                 => 'Transporte_Transportadora_Transportadoras',
            'End'                   => 'Transporte/Transportadora/Transportadoras', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Transporte', // Modulo Referente
            'SubModulo'             => 'Transportadora',   // Submodulo Referente
            'Metodo'                => 'Transportadoras',  // Metodos referentes separados por virgula
        ),Array(
            'Nome'                  => __('Transporte - Fornecedor (Painel)'),
            'Desc'                  => '',
            'Chave'                 => 'Transporte_Fornecedor_Painel',
            'End'                   => 'Transporte/Fornecedor/Painel', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Transporte', // Modulo Referente
            'SubModulo'             => 'Fornecedor',   // Submodulo Referente
            'Metodo'                => 'Painel',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => __('Transporte - Fornecedor (Listagens)'),
            'Desc'                  => '',
            'Chave'                 => 'Transporte_Fornecedor_Fornecedores',
            'End'                   => 'Transporte/Fornecedor/Fornecedores', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Transporte', // Modulo Referente
            'SubModulo'             => 'Fornecedor',   // Submodulo Referente
            'Metodo'                => 'Fornecedores',  // Metodos referentes separados por virgula
        ),Array(
            'Nome'                  => __('Transporte - Armazem (Painel)'),
            'Desc'                  => '',
            'Chave'                 => 'Transporte_Armazem_Painel',
            'End'                   => 'Transporte/Armazem/Painel', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Transporte', // Modulo Referente
            'SubModulo'             => 'Armazem',   // Submodulo Referente
            'Metodo'                => 'Painel',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => __('Transporte - Armazem (Listagens)'),
            'Desc'                  => '',
            'Chave'                 => 'Transporte_Armazem_Armazens',
            'End'                   => 'Transporte/Armazem/Armazens', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Transporte', // Modulo Referente
            'SubModulo'             => 'Armazem',   // Submodulo Referente
            'Metodo'                => 'Armazens',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => __('Transporte - Autonômo (Painel)'),
            'Desc'                  => '',
            'Chave'                 => 'Transporte_Caminhoneiro_Painel',
            'End'                   => 'Transporte/Caminhoneiro/Painel', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Transporte', // Modulo Referente
            'SubModulo'             => 'Caminhoneiro',   // Submodulo Referente
            'Metodo'                => 'Painel',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => __('Transporte - Autonômo (Listagens)'),
            'Desc'                  => '',
            'Chave'                 => 'Transporte_Caminhoneiro_Caminhoneiros',
            'End'                   => 'Transporte/Caminhoneiro/Caminhoneiros', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Transporte', // Modulo Referente
            'SubModulo'             => 'Caminhoneiro',   // Submodulo Referente
            'Metodo'                => 'Caminhoneiros',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => __('Transporte - Administrar Dicas de Estradas'),
            'Desc'                  => '',
            'Chave'                 => 'Transporte_Estrada_Estradas',
            'End'                   => 'Transporte/Estrada/Estradas', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Transporte', // Modulo Referente
            'SubModulo'             => 'Admin',   // Submodulo Referente
            'Metodo'                => '*',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => __('Transporte - Dicas de Estradas (Add)'),
            'Desc'                  => '',
            'Chave'                 => 'Transporte_Estrada_Estradas_Add', // CHave unica nunca repete, chave primaria
            'End'                   => 'Transporte/Estrada/Estradas_Add', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Transporte', // Modulo Referente
            'SubModulo'             => 'Estrada',   // Submodulo Referente
            'Metodo'                => 'Estradas_Add,Estradas_Add2',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => __('Transporte - Dicas de Estradas (Editar)'),
            'Desc'                  => '',
            'Chave'                 => 'Transporte_Estrada_Estradas_Edit', // CHave unica nunca repete, chave primaria
            'End'                   => 'Transporte/Estrada/Estradas_Edit', // Endereco que deve conter a url para permitir acesso // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Transporte', // Modulo Referente // Modulo Referente
            'SubModulo'             => 'Estrada',   // Submodulo Referente   // Submodulo Referente
            'Metodo'                => 'Estradas_Edit,Estradas_Edit2',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => __('Transporte - Dicas de Estradas (Deletar)'),
            'Desc'                  => '',
            'Chave'                 => 'Transporte_Estrada_Estradas_Del', // CHave unica nunca repete, chave primaria
            'End'                   => 'Transporte/Estrada/Estradas_Del', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Transporte', // Modulo Referente
            'SubModulo'             => 'Estrada',   // Submodulo Referente
            'Metodo'                => 'Estradas_Del',  // Metodos referentes separados por virgula
        ),
        
        
        // PEdidos Transportadora
        Array(
            'Nome'                  => 'Transporte - Pedido Transportadora - Propostas Aceitas (->)',
            'Desc'                  => '',
            'Chave'                 => 'Transporte_Pedido_Trans_Ped_Aceitas', // CHave unica nunca repete, chave primaria
            'End'                   => 'Transporte/Pedido/Trans_Ped_Aceitas', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Transporte', // Modulo Referente
            'SubModulo'             => 'Pedido',   // Submodulo Referente
            'Metodo'                => 'Trans_Ped_Aceitas',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => 'Transporte - Pedido Transportadora - Propostas Novas (->)',
            'Desc'                  => '',
            'Chave'                 => 'Transporte_Pedido_Trans_Ped_Novas', // CHave unica nunca repete, chave primaria
            'End'                   => 'Transporte/Pedido/Trans_Ped_Novas', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Transporte', // Modulo Referente
            'SubModulo'             => 'Pedido',   // Submodulo Referente
            'Metodo'                => 'Trans_Ped_Novas',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => 'Transporte - Pedido Transportadora - Meus Pedidos (->)',
            'Desc'                  => '',
            'Chave'                 => 'Transporte_Pedido_Trans_Ped_Minhas', // CHave unica nunca repete, chave primaria
            'End'                   => 'Transporte/Pedido/Trans_Ped_Minhas', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Transporte', // Modulo Referente
            'SubModulo'             => 'Pedido',   // Submodulo Referente
            'Metodo'                => 'Trans_Ped_Minhas',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => 'Transporte - Pedido Transportadora - Aceitar Proposta (->)',
            'Desc'                  => '',
            'Chave'                 => 'Transporte_Pedido_Trans_Ped_Novas_Aceitar', // CHave unica nunca repete, chave primaria
            'End'                   => 'Transporte/Pedido/Trans_Ped_Novas_Aceitar', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Transporte', // Modulo Referente
            'SubModulo'             => 'Pedido',   // Submodulo Referente
            'Metodo'                => 'Trans_Ped_Novas_Aceitar',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => 'Transporte - Pedido Transportadora - Adicionar Pedido (->)',
            'Desc'                  => '',
            'Chave'                 => 'Transporte_Pedido_Trans_Ped_Add', // CHave unica nunca repete, chave primaria
            'End'                   => 'Transporte/Pedido/Trans_Ped_Add', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Transporte', // Modulo Referente
            'SubModulo'             => 'Pedido',   // Submodulo Referente
            'Metodo'                => 'Trans_Ped_Add,Trans_Ped_Add2',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => 'Transporte - Pedido Transportadora - Cancelar Pedido (->)',
            'Desc'                  => '',
            'Chave'                 => 'Transporte_Pedido_Trans_Ped_Del', // CHave unica nunca repete, chave primaria
            'End'                   => 'Transporte/Pedido/Trans_Ped_Del', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Transporte', // Modulo Referente
            'SubModulo'             => 'Pedido',   // Submodulo Referente
            'Metodo'                => 'Trans_Ped_Del',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => 'Transporte - Pedido Transportadora - Cancelar Solicitação (->)',
            'Desc'                  => '',
            'Chave'                 => 'Transporte_Pedido_Trans_Sol_Del', // CHave unica nunca repete, chave primaria
            'End'                   => 'Transporte/Pedido/Trans_Sol_Del', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Transporte', // Modulo Referente
            'SubModulo'             => 'Pedido',   // Submodulo Referente
            'Metodo'                => 'Trans_Sol_Del',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => 'Transporte - Pedido Transportadora - Adicionar Solicitação (<-)',
            'Desc'                  => '',
            'Chave'                 => 'Transporte_Pedido_Trans_Sol_Add', // CHave unica nunca repete, chave primaria
            'End'                   => 'Transporte/Pedido/Trans_Sol_Add', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Transporte', // Modulo Referente
            'SubModulo'             => 'Pedido',   // Submodulo Referente
            'Metodo'                => 'Trans_Sol_Add,Trans_Sol_Add2',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => 'Transporte - Pedido Transportadora - Propostas Aceitas (<-)',
            'Desc'                  => '',
            'Chave'                 => 'Transporte_Pedido_Trans_Sol_PedAceitos', // CHave unica nunca repete, chave primaria
            'End'                   => 'Transporte/Pedido/Trans_Sol_PedAceitos', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Transporte', // Modulo Referente
            'SubModulo'             => 'Pedido',   // Submodulo Referente
            'Metodo'                => 'Trans_Sol_PedAceitos',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => 'Transporte - Pedido Transportadora - Propostas Pendentes (<-)',
            'Desc'                  => '',
            'Chave'                 => 'Transporte_Pedido_Trans_Sol_PedPendente', // CHave unica nunca repete, chave primaria
            'End'                   => 'Transporte/Pedido/Trans_Sol_PedPendente', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Transporte', // Modulo Referente
            'SubModulo'             => 'Pedido',   // Submodulo Referente
            'Metodo'                => 'Trans_Sol_PedPendente',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => 'Transporte - Pedido Transportadora - Propostas Recusadas (<-)',
            'Desc'                  => '',
            'Chave'                 => 'Transporte_Pedido_Trans_Sol_PedRecusados', // CHave unica nunca repete, chave primaria
            'End'                   => 'Transporte/Pedido/Trans_Sol_PedRecusados', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Transporte', // Modulo Referente
            'SubModulo'             => 'Pedido',   // Submodulo Referente
            'Metodo'                => 'Trans_Sol_PedRecusados',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => 'Transporte - Pedido Transportadora - Ver Novos Pedidos (<-)',
            'Desc'                  => '',
            'Chave'                 => 'Transporte_Pedido_Trans_Sol_Solicitacoes', // CHave unica nunca repete, chave primaria
            'End'                   => 'Transporte/Pedido/Trans_Sol_Solicitacoes', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Transporte', // Modulo Referente
            'SubModulo'             => 'Pedido',   // Submodulo Referente
            'Metodo'                => 'Trans_Sol_Solicitacoes',  // Metodos referentes separados por virgula
        ),
        
        // PEdidos Autonômos
        Array(
            'Nome'                  => 'Transporte - Pedido Autonômo - Propostas Aceitas (->)',
            'Desc'                  => '',
            'Chave'                 => 'Transporte_Pedido_Caminho_Ped_Aceitas', // CHave unica nunca repete, chave primaria
            'End'                   => 'Transporte/Pedido/Caminho_Ped_Aceitas', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Transporte', // Modulo Referente
            'SubModulo'             => 'Pedido',   // Submodulo Referente
            'Metodo'                => 'Caminho_Ped_Aceitas',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => 'Transporte - Pedido Autonômo - Propostas Novas (->)',
            'Desc'                  => '',
            'Chave'                 => 'Transporte_Pedido_Caminho_Ped_Novas', // CHave unica nunca repete, chave primaria
            'End'                   => 'Transporte/Pedido/Caminho_Ped_Novas', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Transporte', // Modulo Referente
            'SubModulo'             => 'Pedido',   // Submodulo Referente
            'Metodo'                => 'Caminho_Ped_Novas',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => 'Transporte - Pedido Autonômo - Meus Pedidos (->)',
            'Desc'                  => '',
            'Chave'                 => 'Transporte_Pedido_Caminho_Ped_Minhas', // CHave unica nunca repete, chave primaria
            'End'                   => 'Transporte/Pedido/Caminho_Ped_Minhas', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Transporte', // Modulo Referente
            'SubModulo'             => 'Pedido',   // Submodulo Referente
            'Metodo'                => 'Caminho_Ped_Minhas',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => 'Transporte - Pedido Autonômo - Aceitar Proposta (->)',
            'Desc'                  => '',
            'Chave'                 => 'Transporte_Pedido_Caminho_Ped_Novas_Aceitar', // CHave unica nunca repete, chave primaria
            'End'                   => 'Transporte/Pedido/Caminho_Ped_Novas_Aceitar', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Transporte', // Modulo Referente
            'SubModulo'             => 'Pedido',   // Submodulo Referente
            'Metodo'                => 'Caminho_Ped_Novas_Aceitar',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => 'Transporte - Pedido Autonômo - Adicionar Pedido (->)',
            'Desc'                  => '',
            'Chave'                 => 'Transporte_Pedido_Caminho_Ped_Add', // CHave unica nunca repete, chave primaria
            'End'                   => 'Transporte/Pedido/Caminho_Ped_Add', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Transporte', // Modulo Referente
            'SubModulo'             => 'Pedido',   // Submodulo Referente
            'Metodo'                => 'Caminho_Ped_Add,Caminho_Ped_Add2',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => 'Transporte - Pedido Autonômo - Cancelar Pedido (->)',
            'Desc'                  => '',
            'Chave'                 => 'Transporte_Pedido_Caminho_Ped_Del', // CHave unica nunca repete, chave primaria
            'End'                   => 'Transporte/Pedido/Caminho_Ped_Del', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Transporte', // Modulo Referente
            'SubModulo'             => 'Pedido',   // Submodulo Referente
            'Metodo'                => 'Caminho_Ped_Del',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => 'Transporte - Pedido Autonômo - Cancelar Solicitação (->)',
            'Desc'                  => '',
            'Chave'                 => 'Transporte_Pedido_Caminho_Sol_Del', // CHave unica nunca repete, chave primaria
            'End'                   => 'Transporte/Pedido/Caminho_Sol_Del', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Transporte', // Modulo Referente
            'SubModulo'             => 'Pedido',   // Submodulo Referente
            'Metodo'                => 'Caminho_Sol_Del',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => 'Transporte - Pedido Autonômo - Adicionar Solicitação (<-)',
            'Desc'                  => '',
            'Chave'                 => 'Transporte_Pedido_Caminho_Sol_Add', // CHave unica nunca repete, chave primaria
            'End'                   => 'Transporte/Pedido/Caminho_Sol_Add', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Transporte', // Modulo Referente
            'SubModulo'             => 'Pedido',   // Submodulo Referente
            'Metodo'                => 'Caminho_Sol_Add,Caminho_Sol_Add2',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => 'Transporte - Pedido Autonômo - Propostas Aceitas (<-)',
            'Desc'                  => '',
            'Chave'                 => 'Transporte_Pedido_Caminho_Sol_PedAceitos', // CHave unica nunca repete, chave primaria
            'End'                   => 'Transporte/Pedido/Caminho_Sol_PedAceitos', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Transporte', // Modulo Referente
            'SubModulo'             => 'Pedido',   // Submodulo Referente
            'Metodo'                => 'Caminho_Sol_PedAceitos',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => 'Transporte - Pedido Autonômo - Propostas Pendentes (<-)',
            'Desc'                  => '',
            'Chave'                 => 'Transporte_Pedido_Caminho_Sol_PedPendente', // CHave unica nunca repete, chave primaria
            'End'                   => 'Transporte/Pedido/Caminho_Sol_PedPendente', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Transporte', // Modulo Referente
            'SubModulo'             => 'Pedido',   // Submodulo Referente
            'Metodo'                => 'Caminho_Sol_PedPendente',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => 'Transporte - Pedido Autonômo - Propostas Recusadas (<-)',
            'Desc'                  => '',
            'Chave'                 => 'Transporte_Pedido_Caminho_Sol_PedRecusados', // CHave unica nunca repete, chave primaria
            'End'                   => 'Transporte/Pedido/Caminho_Sol_PedRecusados', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Transporte', // Modulo Referente
            'SubModulo'             => 'Pedido',   // Submodulo Referente
            'Metodo'                => 'Caminho_Sol_PedRecusados',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => 'Transporte - Pedido Autonômo - Ver Novos Pedidos (<-)',
            'Desc'                  => '',
            'Chave'                 => 'Transporte_Pedido_Caminho_Sol_Solicitacoes', // CHave unica nunca repete, chave primaria
            'End'                   => 'Transporte/Pedido/Caminho_Sol_Solicitacoes', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Transporte', // Modulo Referente
            'SubModulo'             => 'Pedido',   // Submodulo Referente
            'Metodo'                => 'Caminho_Sol_Solicitacoes',  // Metodos referentes separados por virgula
        ),
        
        // PEdidos Armazém
        Array(
            'Nome'                  => 'Transporte - Pedido Armazém - Propostas Aceitas (->)',
            'Desc'                  => '',
            'Chave'                 => 'Transporte_Pedido_Arma_Ped_Aceitas', // CHave unica nunca repete, chave primaria
            'End'                   => 'Transporte/Pedido/Arma_Ped_Aceitas', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Transporte', // Modulo Referente
            'SubModulo'             => 'Pedido',   // Submodulo Referente
            'Metodo'                => 'Arma_Ped_Aceitas',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => 'Transporte - Pedido Armazém - Propostas Novas (->)',
            'Desc'                  => '',
            'Chave'                 => 'Transporte_Pedido_Arma_Ped_Novas', // CHave unica nunca repete, chave primaria
            'End'                   => 'Transporte/Pedido/Arma_Ped_Novas', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Transporte', // Modulo Referente
            'SubModulo'             => 'Pedido',   // Submodulo Referente
            'Metodo'                => 'Arma_Ped_Novas',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => 'Transporte - Pedido Armazém - Meus Pedidos (->)',
            'Desc'                  => '',
            'Chave'                 => 'Transporte_Pedido_Arma_Ped_Minhas', // CHave unica nunca repete, chave primaria
            'End'                   => 'Transporte/Pedido/Arma_Ped_Minhas', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Transporte', // Modulo Referente
            'SubModulo'             => 'Pedido',   // Submodulo Referente
            'Metodo'                => 'Arma_Ped_Minhas',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => 'Transporte - Pedido Armazém - Aceitar Proposta (->)',
            'Desc'                  => '',
            'Chave'                 => 'Transporte_Pedido_Arma_Ped_Novas_Aceitar', // CHave unica nunca repete, chave primaria
            'End'                   => 'Transporte/Pedido/Arma_Ped_Novas_Aceitar', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Transporte', // Modulo Referente
            'SubModulo'             => 'Pedido',   // Submodulo Referente
            'Metodo'                => 'Arma_Ped_Novas_Aceitar',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => 'Transporte - Pedido Armazém - Adicionar Pedido (->)',
            'Desc'                  => '',
            'Chave'                 => 'Transporte_Pedido_Arma_Ped_Add', // CHave unica nunca repete, chave primaria
            'End'                   => 'Transporte/Pedido/Arma_Ped_Add', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Transporte', // Modulo Referente
            'SubModulo'             => 'Pedido',   // Submodulo Referente
            'Metodo'                => 'Arma_Ped_Add,Arma_Ped_Add2',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => 'Transporte - Pedido Armazém - Cancelar Pedido (->)',
            'Desc'                  => '',
            'Chave'                 => 'Transporte_Pedido_Arma_Ped_Del', // CHave unica nunca repete, chave primaria
            'End'                   => 'Transporte/Pedido/Arma_Ped_Del', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Transporte', // Modulo Referente
            'SubModulo'             => 'Pedido',   // Submodulo Referente
            'Metodo'                => 'Arma_Ped_Del',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => 'Transporte - Pedido Armazém - Cancelar Solicitação (->)',
            'Desc'                  => '',
            'Chave'                 => 'Transporte_Pedido_Arma_Sol_Del', // CHave unica nunca repete, chave primaria
            'End'                   => 'Transporte/Pedido/Arma_Sol_Del', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Transporte', // Modulo Referente
            'SubModulo'             => 'Pedido',   // Submodulo Referente
            'Metodo'                => 'Arma_Sol_Del',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => 'Transporte - Pedido Armazém - Adicionar Solicitação (<-)',
            'Desc'                  => '',
            'Chave'                 => 'Transporte_Pedido_Arma_Sol_Add', // CHave unica nunca repete, chave primaria
            'End'                   => 'Transporte/Pedido/Arma_Sol_Add', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Transporte', // Modulo Referente
            'SubModulo'             => 'Pedido',   // Submodulo Referente
            'Metodo'                => 'Arma_Sol_Add,Arma_Sol_Add2',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => 'Transporte - Pedido Armazém - Propostas Aceitas (<-)',
            'Desc'                  => '',
            'Chave'                 => 'Transporte_Pedido_Arma_Sol_PedAceitos', // CHave unica nunca repete, chave primaria
            'End'                   => 'Transporte/Pedido/Arma_Sol_PedAceitos', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Transporte', // Modulo Referente
            'SubModulo'             => 'Pedido',   // Submodulo Referente
            'Metodo'                => 'Arma_Sol_PedAceitos',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => 'Transporte - Pedido Armazém - Propostas Pendentes (<-)',
            'Desc'                  => '',
            'Chave'                 => 'Transporte_Pedido_Arma_Sol_PedPendente', // CHave unica nunca repete, chave primaria
            'End'                   => 'Transporte/Pedido/Arma_Sol_PedPendente', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Transporte', // Modulo Referente
            'SubModulo'             => 'Pedido',   // Submodulo Referente
            'Metodo'                => 'Arma_Sol_PedPendente',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => 'Transporte - Pedido Armazém - Propostas Recusadas (<-)',
            'Desc'                  => '',
            'Chave'                 => 'Transporte_Pedido_Arma_Sol_PedRecusados', // CHave unica nunca repete, chave primaria
            'End'                   => 'Transporte/Pedido/Arma_Sol_PedRecusados', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Transporte', // Modulo Referente
            'SubModulo'             => 'Pedido',   // Submodulo Referente
            'Metodo'                => 'Arma_Sol_PedRecusados',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => 'Transporte - Pedido Armazém - Ver Novos Pedidos (<-)',
            'Desc'                  => '',
            'Chave'                 => 'Transporte_Pedido_Arma_Sol_Solicitacoes', // CHave unica nunca repete, chave primaria
            'End'                   => 'Transporte/Pedido/Arma_Sol_Solicitacoes', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Transporte', // Modulo Referente
            'SubModulo'             => 'Pedido',   // Submodulo Referente
            'Metodo'                => 'Arma_Sol_Solicitacoes',  // Metodos referentes separados por virgula
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
