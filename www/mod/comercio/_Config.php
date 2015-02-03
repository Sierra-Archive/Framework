<?php
$config_Modulo = function (){
    return Array(
        'Nome'                      =>  'comercio',
        'Descrição'                 =>  '',
        'System_Require'            =>  '2.21.1',
        'Version'                   =>  '0.0.1',
        'Dependencias'              =>  false,
    );
};
$config_Menu = function (){
    return Array(
        'Administrar' => Array(
            'Nome'                  => 'Administrar',
            'Link'                  => '#',
            'Gravidade'             => 2,
            'Img'                   => 'turboadmin/m-dashboard.png',
            'Icon'                  => 'cog',
            'Filhos'                => Array('Fornecedores'=>Array(
                'Nome'                  => 'Fornecedores',
                'Link'                  => 'comercio/Fornecedor/Fornecedores',
                'Gravidade'             => 65,
                'Img'                   => 'turboadmin/m-dashboard.png',
                'Icon'                  => 'truck',
                'Permissao_Func'        => Array(// Permissoes NEcessarias
                    'comercio_Fornecedor' => true
                ),
                'Filhos'                => false,
            ),'Checklists'=>Array(
                'Nome'                  => 'Checklists',
                'Link'                  => 'comercio/Proposta/Checklists',
                'Gravidade'             => 63,
                'Img'                   => 'turboadmin/m-dashboard.png',
                'Icon'                  => 'archive',
                'Permissao_Func'        => Array(// Permissoes NEcessarias
                    'comercio_Proposta_Checklist' => true
                ),
                'Filhos'                => false,
            ),),
        ),
        'Comercial' => Array(
            'Nome'                  => 'Comercial',
            'Link'                  => '#',
            'Gravidade'             => 9999,
            'Img'                   => 'turboadmin/m-dashboard.png',
            'Icon'                  => 'tag',
            'Filhos'                => Array('Agenda de Visitas'=>Array(
                'Nome'                  => 'Agenda de Visitas',
                'Link'                  => 'comercio/Proposta/Visitas',
                'Gravidade'             => 80,
                'Img'                   => 'turboadmin/m-dashboard.png',
                'Icon'                  => 'archive',
                'Permissao_Func'        => Array(// Permissoes NEcessarias
                    'comercio_Visitas' => true
                ),
                'Filhos'                => false,
            ),'Entrada de NFE'=>Array(
                'Nome'                  => 'Entrada de NFE',
                'Link'                  => 'comercio/Estoque/Material_Entrada',
                'Gravidade'             => 65,
                'Img'                   => 'turboadmin/m-dashboard.png',
                'Icon'                  => 'truck',
                'Permissao_Func'        => Array(// Permissoes NEcessarias
                    'comercio_Fornecedor' => true
                ),
                'Filhos'                => false,
            ),'Propostas'=>Array(
                'Nome'                  => 'Propostas',
                'Link'                  => 'comercio/Proposta/Propostas/Propostas',
                'Gravidade'             => 64,
                'Img'                   => 'turboadmin/m-dashboard.png',
                'Icon'                  => 'archive',
                'Permissao_Func'        => Array(// Permissoes NEcessarias
                    'comercio_Propostas' => true
                ),
                'Filhos'                => false,
            ),CFG_TXT_COMERCIO_OS=>Array(
                'Nome'                  => CFG_TXT_COMERCIO_OS,
                'Link'                  => 'comercio/Proposta/Propostas/Os',
                'Gravidade'             => 63,
                'Img'                   => 'turboadmin/m-dashboard.png',
                'Icon'                  => 'archive',
                'Permissao_Func'        => Array(// Permissoes NEcessarias
                    'comercio_Propostas' => true
                ),
                'Filhos'                => false,
            ),),
        ),
        'Produtos' => Array(
            'Nome'                  => 'Produtos',
            'Link'                  => '#',
            'Gravidade'             => 12,
            'Img'                   => 'turboadmin/m-dashboard.png',
            'Icon'                  => 'briefcase',
            'Filhos'                => Array('Marcas'=>Array(
                'Nome'                  => 'Marcas',
                'Link'                  => 'comercio/Marca/Marcas',
                'Gravidade'             => 66,
                'Img'                   => 'turboadmin/m-dashboard.png',
                'Icon'                  => 'tag',
                'Filhos'                => false,
                'Permissao_Func'        => Array(// Permissoes NEcessarias
                    'comercio_Produto' => true,
                    'comercio_Marca' => true
                ),
            ),'Linhas'=>Array(
                'Nome'                  => 'Linhas',
                'Link'                  => 'comercio/Linha/Linhas',
                'Gravidade'             => 65,
                'Img'                   => 'turboadmin/m-dashboard.png',
                'Icon'                  => 'tags',
                'Permissao_Func'        => Array(// Permissoes NEcessarias
                    'comercio_Produto' => true,
                    'comercio_Marca' => true,
                    'comercio_Produto_Familia' => 'Marca'
                ),
                'Filhos'                => false,
            ),'Familias'=>Array(
                'Nome'                  => 'Familias',
                'Link'                  => 'comercio/Familia/Familias',
                'Gravidade'             => 64,
                'Img'                   => 'turboadmin/m-dashboard.png',
                'Icon'                  => 'tags',
                'Permissao_Func'        => Array(// Permissoes NEcessarias
                    'comercio_Produto' => true,
                    'comercio_Produto_Familia' => 'Familia'
                ),
                'Filhos'                => false,
            ),'Produtos'=>Array(
                'Nome'                  => 'Produtos',
                'Link'                  => 'comercio/Produto/Produtos',
                'Gravidade'             => 62,
                'Img'                   => 'turboadmin/m-dashboard.png',
                'Icon'                  => 'shopping-cart',
                'Permissao_Func'        => Array(// Permissoes NEcessarias
                    'comercio_Produto' => true
                ),
                'Filhos'                => false,
            ),),
        ),
        'Relatório' => Array(
            'Nome'                  => 'Relatório',
            'Filhos'                => Array('Estoque'=>Array(
                'Nome'                  => 'Estoque',
                'Link'                  => 'comercio/Estoque/Estoques',
                'Gravidade'             => 63,
                'Img'                   => 'turboadmin/m-dashboard.png',
                'Icon'                  => 'barcode',
                'Permissao_Func'        => Array(// Permissoes NEcessarias
                    'comercio_Produto' => true,
                    'comercio_Estoque' => true
                ),
                'Filhos'                => false,
            ),),
        ),
    );
};                    
                    
$config_Permissoes = function (){
    return Array(
        
        
        // FOLHAS DE VISITA
        Array(
            'Nome'                  => 'Comercio (Agenda de Visita) - Listagem',
            'Desc'                  => '',
            'Chave'                 => 'comercio_Proposta_Visitas',
            'End'                   => 'comercio/Proposta/Visitas',
            'Modulo'                => 'comercio', // Modulo Referente
            'SubModulo'             => 'Proposta',   // Submodulo Referente
            'Metodo'                => 'Visitas',  // Metodos referentes separados por virgula // Endereco que deve conter a url para permitir acesso
            'Permissao_Func'        => Array(// Permissoes NEcessarias
                'comercio_Visitas' => true
            ),
        ),
        Array(
            'Nome'                  => 'Comercio (Agenda de Visita) - Adicionar',
            'Desc'                  => '',
            'Chave'                 => 'comercio_Proposta_Visitas_Add',
            'End'                   => 'comercio/Proposta/Visitas_Add',
            'Modulo'                => 'comercio', // Modulo Referente
            'SubModulo'             => 'Proposta',   // Submodulo Referente
            'Metodo'                => 'Visitas_Add,Visitas_Add2',  // Metodos referentes separados por virgula // Endereco que deve conter a url para permitir acesso
            'Permissao_Func'        => Array(// Permissoes NEcessarias
                'comercio_Visitas' => true
            ),
        ),
        Array(
            'Nome'                  => 'Comercio (Agenda de Visita) - Editar',
            'Desc'                  => '',
            'Chave'                 => 'comercio_Proposta_Visitas_Edit',
            'End'                   => 'comercio/Proposta/Visitas_Edit',
            'Modulo'                => 'comercio', // Modulo Referente
            'SubModulo'             => 'Proposta',   // Submodulo Referente
            'Metodo'                => 'Visitas_Edit,Visitas_Edit2',  // Metodos referentes separados por virgula // Endereco que deve conter a url para permitir acesso
            'Permissao_Func'        => Array(// Permissoes NEcessarias
                'comercio_Visitas' => true
            ),
        ),
        Array(
            'Nome'                  => 'Comercio (Agenda de Visita) - Deletar',
            'Desc'                  => '',
            'Chave'                 => 'comercio_Proposta_Visitas_Del',
            'End'                   => 'comercio/Proposta/Visitas_Del',
            'Modulo'                => 'comercio', // Modulo Referente
            'SubModulo'             => 'Proposta',   // Submodulo Referente
            'Metodo'                => 'Visitas_Del',  // Metodos referentes separados por virgula // Endereco que deve conter a url para permitir acesso
            'Permissao_Func'        => Array(// Permissoes NEcessarias
                'comercio_Visitas' => true
            ),
        ),
        Array(
            'Nome'                  => 'Comercio (Agenda de Visita) - Histórico',
            'Desc'                  => '',
            'Chave'                 => 'comercio_Proposta_Visitas_Comentario',
            'End'                   => 'comercio/Proposta/Visitas_Comentario',
            'Modulo'                => 'comercio', // Modulo Referente
            'SubModulo'             => 'Proposta',   // Submodulo Referente
            'Metodo'                => 'Visitas_Comentario,,Visitas_Comentario_Add2,Visitas_Comentario_Edit,Visitas_Comentario_Edit,Visitas_Comentario_Del',  // Metodos referentes separados por virgula // Endereco que deve conter a url para permitir acesso
            'Permissao_Func'        => Array(// Permissoes NEcessarias
                'comercio_Visitas' => true
            ),
        ),
        Array(
            'Nome'                  => 'Comercio (Agenda de Visita) - Histórico Add',
            'Desc'                  => '',
            'Chave'                 => 'comercio_Proposta_Visitas_Comentario_Add', // CHave unica nunca repete, chave primaria
            'End'                   => 'comercio/Proposta/Visitas_Comentario_Add', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'comercio', // Modulo Referente
            'SubModulo'             => 'Proposta',   // Submodulo Referente
            'Metodo'                => 'Visitas_Comentario_Add,Visitas_Comentario_Add2',  // Metodos referentes separados por virgula
            'Permissao_Func'        => Array(// Permissoes NEcessarias
                'comercio_Visitas' => true
            ),
        ),
        Array(
            'Nome'                  => 'Comercio (Agenda de Visita) - Histórico Editar',
            'Desc'                  => '',
            'Chave'                 => 'comercio_Proposta_Visitas_Comentario_Edit', // CHave unica nunca repete, chave primaria
            'End'                   => 'comercio/Proposta/Visitas_Comentario_Edit', // Endereco que deve conter a url para permitir acesso // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'comercio', // Modulo Referente // Modulo Referente
            'SubModulo'             => 'Proposta',   // Submodulo Referente   // Submodulo Referente
            'Metodo'                => 'Visitas_Comentario_Edit,Visitas_Comentario_Edit2',  // Metodos referentes separados por virgula
            'Permissao_Func'        => Array(// Permissoes NEcessarias
                'comercio_Visitas' => true
            ),
        ),
        Array(
            'Nome'                  => 'Comercio (Agenda de Visita) - Histórico Deletar',
            'Desc'                  => '',
            'Chave'                 => 'comercio_Proposta_Visitas_Comentario_Del', // CHave unica nunca repete, chave primaria
            'End'                   => 'comercio/Proposta/Visitas_Comentario_Del', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'comercio', // Modulo Referente
            'SubModulo'             => 'Proposta',   // Submodulo Referente
            'Metodo'                => 'Visitas_Comentario_Del',  // Metodos referentes separados por virgula
            'Permissao_Func'        => Array(// Permissoes NEcessarias
                'comercio_Visitas' => true
            ),
        ),
        
        // Checklist
        Array(
            'Nome'                  => 'Comercio (Checklists) - Listagem',
            'Desc'                  => '',
            'Chave'                 => 'comercio_Proposta_Checklists',
            'End'                   => 'comercio/Proposta/Checklists',
            'Modulo'                => 'comercio', // Modulo Referente
            'SubModulo'             => 'Proposta',   // Submodulo Referente
            'Metodo'                => 'Checklists',  // Metodos referentes separados por virgula // Endereco que deve conter a url para permitir acesso
            'Permissao_Func'        => Array(// Permissoes NEcessarias
                'comercio_Proposta_Checklist' => true
            ),
        ),
        Array(
            'Nome'                  => 'Comercio (Checklists) - Adicionar',
            'Desc'                  => '',
            'Chave'                 => 'comercio_Proposta_Checklists_Add',
            'End'                   => 'comercio/Proposta/Checklists_Add',
            'Modulo'                => 'comercio', // Modulo Referente
            'SubModulo'             => 'Proposta',   // Submodulo Referente
            'Metodo'                => 'Checklists_Add,Checklists_Add2',  // Metodos referentes separados por virgula // Endereco que deve conter a url para permitir acesso
            'Permissao_Func'        => Array(// Permissoes NEcessarias
                'comercio_Proposta_Checklist' => true
            ),
        ),
        Array(
            'Nome'                  => 'Comercio (Checklists) - Editar',
            'Desc'                  => '',
            'Chave'                 => 'comercio_Proposta_Checklists_Edit',
            'End'                   => 'comercio/Proposta/Checklists_Edit',
            'Modulo'                => 'comercio', // Modulo Referente
            'SubModulo'             => 'Proposta',   // Submodulo Referente
            'Metodo'                => 'Checklists_Edit,Checklists_Edit2',  // Metodos referentes separados por virgula // Endereco que deve conter a url para permitir acesso
            'Permissao_Func'        => Array(// Permissoes NEcessarias
                'comercio_Proposta_Checklist' => true
            ),
        ),
        Array(
            'Nome'                  => 'Comercio (Checklists) - Deletar',
            'Desc'                  => '',
            'Chave'                 => 'comercio_Proposta_Checklists_Del',
            'End'                   => 'comercio/Proposta/Checklists_Del',
            'Modulo'                => 'comercio', // Modulo Referente
            'SubModulo'             => 'Proposta',   // Submodulo Referente
            'Metodo'                => 'Checklists_Del',  // Metodos referentes separados por virgula // Endereco que deve conter a url para permitir acesso
            'Permissao_Func'        => Array(// Permissoes NEcessarias
                'comercio_Proposta_Checklist' => true
            ),
        ),
        Array(
            'Nome'                  => 'Comercio (Checklists) - Status',
            'Desc'                  => '',
            'Chave'                 => 'comercio_Proposta_StatusChecklists',
            'End'                   => 'comercio/Proposta/StatusChecklists',
            'Modulo'                => 'comercio', // Modulo Referente
            'SubModulo'             => 'Proposta',   // Submodulo Referente
            'Metodo'                => 'StatusChecklists',  // Metodos referentes separados por virgula // Endereco que deve conter a url para permitir acesso
            'Permissao_Func'        => Array(// Permissoes NEcessarias
                'comercio_Proposta_Checklist' => true
            ),
        ),
        
        
        // PROPOSTAS
        Array(
            'Nome'                  => 'Comercio (Proposta) - Listagem',
            'Desc'                  => '',
            'Chave'                 => 'comercio_Proposta_Propostas_Propostas',
            'End'                   => 'comercio/Proposta/Propostas/Propostas',
            'Modulo'                => 'Proposta', // Modulo Referente
            'SubModulo'             => 'Marca',   // Submodulo Referente
            'Metodo'                => 'Propostas',  // Metodos referentes separados por virgula // Endereco que deve conter a url para permitir acesso
            'Permissao_Func'        => Array(// Permissoes NEcessarias
                'comercio_Propostas' => true
            ),
        ),
        Array(
            'Nome'                  => 'Comercio (Proposta) - Adicionar',
            'Desc'                  => '',
            'Chave'                 => 'comercio_Proposta_Propostas_Add',
            'End'                   => 'comercio/Proposta/Propostas_Add',
            'Modulo'                => 'Proposta', // Modulo Referente
            'SubModulo'             => 'Proposta',   // Submodulo Referente
            'Metodo'                => 'Propostas_Add',  // Metodos referentes separados por virgula // Endereco que deve conter a url para permitir acesso
            'Permissao_Func'        => Array(// Permissoes NEcessarias
                'comercio_Propostas' => true
            ),
        ),
        Array(
            'Nome'                  => 'Comercio ('.CFG_TXT_COMERCIO_OS.') - Listagem',
            'Desc'                  => '',
            'Chave'                 => 'comercio_Proposta_Propostas_Os',
            'End'                   => 'comercio/Proposta/Propostas/Os', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'comercio', // Modulo Referente
            'SubModulo'             => 'Proposta',   // Submodulo Referente
            'Metodo'                => 'Propostas',  // Metodos referentes separados por virgula
            'Permissao_Func'        => Array(// Permissoes NEcessarias
                'comercio_Propostas' => true
            ),
        ),
        Array(
            'Nome'                  => 'Comercio ('.CFG_TXT_COMERCIO_OS.') - Visualizar',
            'Desc'                  => '',
            'Chave'                 => 'comercio_Proposta_Propostas_View',
            'End'                   => 'comercio/Proposta/Propostas_View', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'comercio', // Modulo Referente
            'SubModulo'             => 'Proposta',   // Submodulo Referente
            'Metodo'                => 'Propostas_View',  // Metodos referentes separados por virgula
            'Permissao_Func'        => Array(// Permissoes NEcessarias
                'comercio_Propostas' => true
            ),
        ),
        Array(
            'Nome'                  => 'Comercio ('.CFG_TXT_COMERCIO_OS.'/Proposta) - Editar',
            'Desc'                  => '',
            'Chave'                 => 'comercio_Proposta_Propostas_Edit',
            'End'                   => 'comercio/Proposta/Propostas_Edit',
            'Modulo'                => 'Proposta', // Modulo Referente
            'SubModulo'             => 'Proposta',   // Submodulo Referente
            'Metodo'                => 'Propostas_Edit,Propostas_Edit2',  // Metodos referentes separados por virgula // Endereco que deve conter a url para permitir acesso
            'Permissao_Func'        => Array(// Permissoes NEcessarias
                'comercio_Propostas' => true
            ),
        ),
        Array(
            'Nome'                  => 'Comercio ('.CFG_TXT_COMERCIO_OS.'/Proposta) - Deletar',
            'Desc'                  => '',
            'Chave'                 => 'comercio_Proposta_Propostas_Del',
            'End'                   => 'comercio/Proposta/Propostas_Del',
            'Modulo'                => 'Proposta', // Modulo Referente
            'SubModulo'             => 'Proposta',   // Submodulo Referente
            'Metodo'                => 'Propostas_Del',  // Metodos referentes separados por virgula // Endereco que deve conter a url para permitir acesso
            'Permissao_Func'        => Array(// Permissoes NEcessarias
                'comercio_Propostas' => true
            ),
        ),
        Array(
            'Nome'                  => 'Comercio ('.CFG_TXT_COMERCIO_OS.'/Proposta) - Status',
            'Desc'                  => '',
            'Chave'                 => 'comercio_Proposta_StatusPropostas',
            'End'                   => 'comercio/Proposta/StatusPropostas',
            'Modulo'                => 'comercio', // Modulo Referente
            'SubModulo'             => 'Proposta',   // Submodulo Referente
            'Metodo'                => 'StatusPropostas',  // Metodos referentes separados por virgula // Endereco que deve conter a url para permitir acesso
            'Permissao_Func'        => Array(// Permissoes NEcessarias
                'comercio_Propostas' => true
            ),
        ),
        
        //Historico
        Array(
            'Nome'                  => 'Comercio ('.CFG_TXT_COMERCIO_OS.'/Proposta) - Histórico',
            'Desc'                  => '',
            'Chave'                 => 'comercio_Proposta_Propostas_Comentario',
            'End'                   => 'comercio/Proposta/Propostas_Comentario', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'comercio', // Modulo Referente
            'SubModulo'             => 'Proposta',   // Submodulo Referente
            'Metodo'                => 'Propostas_Comentario',  // Metodos referentes separados por virgula
            'Permissao_Func'        => Array(// Permissoes NEcessarias
                'comercio_Propostas' => true
            ),
        ),
        Array(
            'Nome'                  => 'Comercio ('.CFG_TXT_COMERCIO_OS.'/Proposta) - Histórico Add',
            'Desc'                  => '',
            'Chave'                 => 'comercio_Proposta_Propostas_Comentario_Add', // CHave unica nunca repete, chave primaria
            'End'                   => 'comercio/Proposta/Propostas_Comentario_Add', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'comercio', // Modulo Referente
            'SubModulo'             => 'Proposta',   // Submodulo Referente
            'Metodo'                => 'Propostas_Comentario_Add,Propostas_Comentario_Add2',  // Metodos referentes separados por virgula
            'Permissao_Func'        => Array(// Permissoes NEcessarias
                'comercio_Propostas' => true
            ),
        ),
        Array(
            'Nome'                  => 'Comercio ('.CFG_TXT_COMERCIO_OS.'/Proposta) - Histórico Editar',
            'Desc'                  => '',
            'Chave'                 => 'comercio_Proposta_Propostas_Comentario_Edit', // CHave unica nunca repete, chave primaria
            'End'                   => 'comercio/Proposta/Propostas_Comentario_Edit', // Endereco que deve conter a url para permitir acesso // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'comercio', // Modulo Referente // Modulo Referente
            'SubModulo'             => 'Proposta',   // Submodulo Referente   // Submodulo Referente
            'Metodo'                => 'Propostas_Comentario_Edit,Propostas_Comentario_Edit2',  // Metodos referentes separados por virgula
            'Permissao_Func'        => Array(// Permissoes NEcessarias
                'comercio_Propostas' => true
            ),
        ),
        Array(
            'Nome'                  => 'Comercio ('.CFG_TXT_COMERCIO_OS.'/Proposta) - Histórico Deletar',
            'Desc'                  => '',
            'Chave'                 => 'comercio_Proposta_Propostas_Comentario_Del', // CHave unica nunca repete, chave primaria
            'End'                   => 'comercio/Proposta/Propostas_Comentario_Del', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'comercio', // Modulo Referente
            'SubModulo'             => 'Proposta',   // Submodulo Referente
            'Metodo'                => 'Propostas_Comentario_Del',  // Metodos referentes separados por virgula
            'Permissao_Func'        => Array(// Permissoes NEcessarias
                'comercio_Propostas' => true
            ),
        ),
        
        //Sub
        Array(
            'Nome'                  => 'Comercio ('.CFG_TXT_COMERCIO_OS.'/Proposta) - Sub',
            'Desc'                  => '',
            'Chave'                 => 'comercio_Proposta_Propostas_Sub',
            'End'                   => 'comercio/Proposta/Propostas_Sub', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'comercio', // Modulo Referente
            'SubModulo'             => 'Proposta',   // Submodulo Referente
            'Metodo'                => 'Propostas_Sub',  // Metodos referentes separados por virgula
            'Permissao_Func'        => Array(// Permissoes NEcessarias
                'comercio_Propostas'        => true,
                'comercio_Propostas_Sub'    => true
            ),
        ),
        Array(
            'Nome'                  => 'Comercio ('.CFG_TXT_COMERCIO_OS.'/Proposta) - Sub Add',
            'Desc'                  => '',
            'Chave'                 => 'comercio_Proposta_Propostas_Sub_Add', // CHave unica nunca repete, chave primaria
            'End'                   => 'comercio/Proposta/Propostas_Sub_Add', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'comercio', // Modulo Referente
            'SubModulo'             => 'Proposta',   // Submodulo Referente
            'Metodo'                => 'Propostas_Sub_Add,Propostas_Sub_Add2',  // Metodos referentes separados por virgula
            'Permissao_Func'        => Array(// Permissoes NEcessarias
                'comercio_Propostas'        => true,
                'comercio_Propostas_Sub'    => true
            ),
        ),
        Array(
            'Nome'                  => 'Comercio ('.CFG_TXT_COMERCIO_OS.'/Proposta) - Sub Editar',
            'Desc'                  => '',
            'Chave'                 => 'comercio_Proposta_Propostas_Sub_Edit', // CHave unica nunca repete, chave primaria
            'End'                   => 'comercio/Proposta/Propostas_Sub_Edit', // Endereco que deve conter a url para permitir acesso // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'comercio', // Modulo Referente // Modulo Referente
            'SubModulo'             => 'Proposta',   // Submodulo Referente   // Submodulo Referente
            'Metodo'                => 'Propostas_Sub_Edit,Propostas_Sub_Edit2',  // Metodos referentes separados por virgula
            'Permissao_Func'        => Array(// Permissoes NEcessarias
                'comercio_Propostas'        => true,
                'comercio_Propostas_Sub'    => true
            ),
        ),
        Array(
            'Nome'                  => 'Comercio ('.CFG_TXT_COMERCIO_OS.'/Proposta) - Sub Deletar',
            'Desc'                  => '',
            'Chave'                 => 'comercio_Proposta_Propostas_Sub_Del', // CHave unica nunca repete, chave primaria
            'End'                   => 'comercio/Proposta/Propostas_Sub_Del', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'comercio', // Modulo Referente
            'SubModulo'             => 'Proposta',   // Submodulo Referente
            'Metodo'                => 'Propostas_Sub_Del',  // Metodos referentes separados por virgula
            'Permissao_Func'        => Array(// Permissoes NEcessarias
                'comercio_Propostas'        => true,
                'comercio_Propostas_Sub'    => true
            ),
        ),
        
        
        
        // CONTROLE DE MATERIAL
        Array(
            'Nome'                  => 'Comercio (Estoque) - Visualizar',
            'Desc'                  => '',
            'Chave'                 => 'comercio_Estoque_Estoques',
            'End'                   => 'comercio/Estoque/Estoques',
            'Modulo'                => 'comercio', // Modulo Referente
            'SubModulo'             => 'Estoque',   // Submodulo Referente
            'Metodo'                => 'Estoques',  // Metodos referentes separados por virgula // Endereco que deve conter a url para permitir acesso
            'Permissao_Func'        => Array(// Permissoes NEcessarias
                'comercio_Estoque' => true
            ),
        ),
        Array(
            'Nome'                  => 'Comercio (Entrada de Material) - Listagem',
            'Desc'                  => '',
            'Chave'                 => 'comercio_Estoque_Material_Entrada',
            'End'                   => 'comercio/Estoque/Material_Entrada',
            'Modulo'                => 'comercio', // Modulo Referente
            'SubModulo'             => 'Estoque',   // Submodulo Referente
            'Metodo'                => 'Material_Entrada',  // Metodos referentes separados por virgula // Endereco que deve conter a url para permitir acesso
            'Permissao_Func'        => Array(// Permissoes NEcessarias
                'comercio_Fornecedor' => true
            ),
        ),
        Array(
            'Nome'                  => 'Comercio (Entrada de Material) - Adicionar',
            'Desc'                  => '',
            'Chave'                 => 'comercio_Estoque_Material_Entrada_Add',
            'End'                   => 'comercio/Estoque/Material_Entrada_Add',
            'Modulo'                => 'comercio', // Modulo Referente
            'SubModulo'             => 'Estoque',   // Submodulo Referente
            'Metodo'                => 'Material_Entrada_Add',  // Metodos referentes separados por virgula // Endereco que deve conter a url para permitir acesso
            'Permissao_Func'        => Array(// Permissoes NEcessarias
                'comercio_Fornecedor' => true
            ),
        ),
        Array(
            'Nome'                  => 'Comercio (Entrada de Material) - Editar',
            'Desc'                  => '',
            'Chave'                 => 'comercio_Estoque_Material_Entrada_Edit',
            'End'                   => 'comercio/Estoque/Material_Entrada_Edit',
            'Modulo'                => 'comercio', // Modulo Referente
            'SubModulo'             => 'Estoque',   // Submodulo Referente
            'Metodo'                => 'Material_Entrada_Edit,Material_Entrada_Edit2',  // Metodos referentes separados por virgula // Endereco que deve conter a url para permitir acesso
            'Permissao_Func'        => Array(// Permissoes NEcessarias
                'comercio_Fornecedor' => true
            ),
        ),
        Array(
            'Nome'                  => 'Comercio (Entrada de Material) - Deletar',
            'Desc'                  => '',
            'Chave'                 => 'comercio_Estoque_Material_Entrada_Del',
            'End'                   => 'comercio/Estoque/Material_Entrada_Del',
            'Modulo'                => 'comercio', // Modulo Referente
            'SubModulo'             => 'Estoque',   // Submodulo Referente
            'Metodo'                => 'Material_Entrada_Del',  // Metodos referentes separados por virgula // Endereco que deve conter a url para permitir acesso
            'Permissao_Func'        => Array(// Permissoes NEcessarias
                'comercio_Fornecedor' => true
            ),
        ),
        
        
        // MARCAS
        Array(
            'Nome'                  => 'Comercio (Marcas) - Listagem',
            'Desc'                  => '',
            'Chave'                 => 'comercio_Marca',
            'End'                   => 'comercio/Marca',
            'Modulo'                => 'comercio', // Modulo Referente
            'SubModulo'             => 'Marca',   // Submodulo Referente
            'Metodo'                => '*',  // Metodos referentes separados por virgula // Endereco que deve conter a url para permitir acesso
            'Permissao_Func'        => Array(// Permissoes NEcessarias
                'comercio_Produto'      => true,
                'comercio_Marca'        => true
            ),
        ),
        Array(
            'Nome'                  => 'Comercio (Marcas) - Add',
            'Desc'                  => '',
            'Chave'                 => 'comercio_Marca_Marcas_Add', // CHave unica nunca repete, chave primaria
            'End'                   => 'comercio/Marca/Marcas_Add', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'comercio', // Modulo Referente
            'SubModulo'             => 'Marca',   // Submodulo Referente
            'Metodo'                => 'Marcas_Add,Marcas_Add2',  // Metodos referentes separados por virgula
            'Permissao_Func'        => Array(// Permissoes NEcessarias
                'comercio_Produto'      => true,
                'comercio_Marca'        => true
            ),
        ),
        Array(
            'Nome'                  => 'Comercio (Marcas) - Editar',
            'Desc'                  => '',
            'Chave'                 => 'comercio_Marca_Marcas_Edit', // CHave unica nunca repete, chave primaria
            'End'                   => 'comercio/Marca/Marcas_Edit', // Endereco que deve conter a url para permitir acesso // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'comercio', // Modulo Referente // Modulo Referente
            'SubModulo'             => 'Marca',   // Submodulo Referente   // Submodulo Referente
            'Metodo'                => 'Marcas_Edit,Marcas_Edit2',  // Metodos referentes separados por virgula
            'Permissao_Func'        => Array(// Permissoes NEcessarias
                'comercio_Produto'      => true,
                'comercio_Marca'        => true
            ),
        ),
        Array(
            'Nome'                  => 'Comercio (Marcas) - Deletar',
            'Desc'                  => '',
            'Chave'                 => 'comercio_Marca_Marcas_Del', // CHave unica nunca repete, chave primaria
            'End'                   => 'comercio/Marca/Marcas_Del', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'comercio', // Modulo Referente
            'SubModulo'             => 'Marca',   // Submodulo Referente
            'Metodo'                => 'Marcas_Del',  // Metodos referentes separados por virgula
            'Permissao_Func'        => Array(// Permissoes NEcessarias
                'comercio_Produto'      => true,
                'comercio_Marca'        => true
            ),
        ),
        
        
        
        // LINHAS
        Array(
            'Nome'                  => 'Comercio (Linhas) - Listagem',
            'Desc'                  => '',
            'Chave'                 => 'comercio_Linha',
            'End'                   => 'comercio/Linha', 
            'Modulo'                => 'comercio', // Modulo Referente
            'SubModulo'             => 'Linha',   // Submodulo Referente
            'Metodo'                => '*',
            'Permissao_Func'        => Array(// Permissoes NEcessarias
                'comercio_Produto'          => true,
                'comercio_Marca'            => true,
                'comercio_Produto_Familia'  => 'Marca'
            ),
        ),
        Array(
            'Nome'                  => 'Comercio (Linhas) - Add',
            'Desc'                  => '',
            'Chave'                 => 'comercio_Admin_Linhas_Add', // CHave unica nunca repete, chave primaria
            'End'                   => 'comercio/Linha/Linhas_Add', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'comercio', // Modulo Referente
            'SubModulo'             => 'Linha',   // Submodulo Referente
            'Metodo'                => 'Linhas_Add,Linhas_Add2',  // Metodos referentes separados por virgula
            'Permissao_Func'        => Array(// Permissoes NEcessarias
                'comercio_Produto'          => true,
                'comercio_Marca'            => true,
                'comercio_Produto_Familia'  => 'Marca'
            ),
        ),
        Array(
            'Nome'                  => 'Comercio (Linhas) - Editar',
            'Desc'                  => '',
            'Chave'                 => 'comercio_Admin_Linhas_Edit', // CHave unica nunca repete, chave primaria
            'End'                   => 'comercio/Admin/Linhas_Edit', // Endereco que deve conter a url para permitir acesso // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'comercio', // Modulo Referente // Modulo Referente
            'SubModulo'             => 'Linha',   // Submodulo Referente   // Submodulo Referente
            'Metodo'                => 'Linhas_Edit,Linhas_Edit2',  // Metodos referentes separados por virgula
            'Permissao_Func'        => Array(// Permissoes NEcessarias
                'comercio_Produto'          => true,
                'comercio_Marca'            => true,
                'comercio_Produto_Familia'  => 'Marca'
            ),
        ),
        Array(
            'Nome'                  => 'Comercio (Linhas) - Deletar',
            'Desc'                  => '',
            'Chave'                 => 'comercio_Admin_Linhas_Del', // CHave unica nunca repete, chave primaria
            'End'                   => 'comercio/Admin/Linhas_Del', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'comercio', // Modulo Referente
            'SubModulo'             => 'Admin',   // Submodulo Referente
            'Metodo'                => 'Linhas_Del',  // Metodos re// Endereco que deve conter a url para permitir acesso
            'Permissao_Func'        => Array(// Permissoes NEcessarias
                'comercio_Produto'          => true,
                'comercio_Marca'            => true,
                'comercio_Produto_Familia'  => 'Marca'
            ),
        ),
        
        
        
        // FAMILIA
        Array(
            'Nome'                  => 'Comercio (Familia) - Listagem',
            'Desc'                  => '',
            'Chave'                 => 'comercio_Familia',
            'End'                   => 'comercio/Familia',
            'Modulo'                => 'comercio', // Modulo Referente
            'SubModulo'             => 'Familia',   // Submodulo Referente
            'Metodo'                => '*',// Endereco que deve conter a url para permitir acesso
            'Permissao_Func'        => Array(// Permissoes NEcessarias
                'comercio_Produto'          => true,
                'comercio_Produto_Familia' => 'Familia'
            ),
        ),
        Array(
            'Nome'                  => 'Comercio (Familia) - Add',
            'Desc'                  => '',
            'Chave'                 => 'comercio_Familia_Familias_Add', // CHave unica nunca repete, chave primaria
            'End'                   => 'comercio/Familia/Familias_Add', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'comercio', // Modulo Referente
            'SubModulo'             => 'Familia',   // Submodulo Referente
            'Metodo'                => 'Familias_Add,Familias_Add2',  // Metodos referentes separados por virgula
            'Permissao_Func'        => Array(// Permissoes NEcessarias
                'comercio_Produto'          => true,
                'comercio_Produto_Familia' => 'Familia'
            ),
        ),
        Array(
            'Nome'                  => 'Comercio (Familia) - Editar',
            'Desc'                  => '',
            'Chave'                 => 'comercio_Familia_Familias_Edit', // CHave unica nunca repete, chave primaria
            'End'                   => 'comercio/Familia/Familias_Edit', // Endereco que deve conter a url para permitir acesso // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'comercio', // Modulo Referente // Modulo Referente
            'SubModulo'             => 'Familia',   // Submodulo Referente   // Submodulo Referente
            'Metodo'                => 'Familias_Edit,Familias_Edit2',  // Metodos referentes separados por virgula
            'Permissao_Func'        => Array(// Permissoes NEcessarias
                'comercio_Produto'          => true,
                'comercio_Produto_Familia' => 'Familia'
            ),
        ),
        Array(
            'Nome'                  => 'Comercio (Familia) - Deletar',
            'Desc'                  => '',
            'Chave'                 => 'comercio_Familia_Familias_Del', // CHave unica nunca repete, chave primaria
            'End'                   => 'comercio/Familia/Familias_Del', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'comercio', // Modulo Referente
            'SubModulo'             => 'Familia',   // Submodulo Referente
            'Metodo'                => 'Familias_Del',  // Metodos referentes separados por virgula
            'Permissao_Func'        => Array(// Permissoes NEcessarias
                'comercio_Produto'          => true,
                'comercio_Produto_Familia' => 'Familia'
            ),
        ),
        
        
        // PRODUTOS
        Array(
            'Nome'                  => 'Comercio (Produtos) - Listagem',
            'Desc'                  => '',
            'Chave'                 => 'comercio_Produto',
            'End'                   => 'comercio/Produto',
            'Modulo'                => 'comercio', // Modulo Referente
            'SubModulo'             => 'Produto',   // Submodulo Referente
            'Metodo'                => '*',// Endereco que deve conter a url para permitir acesso
            'Permissao_Func'        => Array(// Permissoes NEcessarias
                'comercio_Produto' => true
            ),
        ),       
        Array(
            'Nome'                  => 'Comercio (Produtos) - Add',
            'Desc'                  => '',
            'Chave'                 => 'comercio_Produto_Produtos_Add', // CHave unica nunca repete, chave primaria
            'End'                   => 'comercio/Produto/Produtos_Add', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'comercio', // Modulo Referente
            'SubModulo'             => 'Produto',   // Submodulo Referente
            'Metodo'                => 'Produtos_Add,Produtos_Add2',  // Metodos referentes separados por virgula
            'Permissao_Func'        => Array(// Permissoes NEcessarias
                'comercio_Produto' => true
            ),
        ),
        Array(
            'Nome'                  => 'Comercio (Produtos) - Editar',
            'Desc'                  => '',
            'Chave'                 => 'comercio_Produto_Produtos_Edit', // CHave unica nunca repete, chave primaria
            'End'                   => 'comercio/Produto/Produtos_Edit', // Endereco que deve conter a url para permitir acesso // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'comercio', // Modulo Referente // Modulo Referente
            'SubModulo'             => 'Produto',   // Submodulo Referente   // Submodulo Referente
            'Metodo'                => 'Produtos_Edit,Produtos_Edit2',  // Metodos referentes separados por virgula
            'Permissao_Func'        => Array(// Permissoes NEcessarias
                'comercio_Produto' => true
            ),
        ),
        Array(
            'Nome'                  => 'Comercio (Produtos) - Deletar',
            'Desc'                  => '',
            'Chave'                 => 'comercio_Produto_Produtos_Del', // CHave unica nunca repete, chave primaria
            'End'                   => 'comercio/Produto/Produtos_Del', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'comercio', // Modulo Referente
            'SubModulo'             => 'Produto',   // Submodulo Referente
            'Metodo'                => 'Produtos_Del',  // Metodos referentes separados por virgula
            'Permissao_Func'        => Array(// Permissoes NEcessarias
                'comercio_Produto' => true
            ),
        ),
        
        
        // FORNECEDORES
        Array(
            'Nome'                  => 'Comercio (Fornecedores) - Listagem',
            'Desc'                  => '',
            'Chave'                 => 'comercio_Fornecedor',
            'End'                   => 'comercio/Fornecedor',
            'Modulo'                => 'comercio', // Modulo Referente
            'SubModulo'             => 'Fornecedor',   // Submodulo Referente
            'Metodo'                => '*',// Endereco que deve conter a url para permitir acesso
            'Permissao_Func'        => Array(// Permissoes NEcessarias
                'comercio_Fornecedor' => true
            ),
        ),       
        Array(
            'Nome'                  => 'Comercio (Fornecedores) - Add',
            'Desc'                  => '',
            'Chave'                 => 'comercio_Fornecedor_Fornecedores_Add', // CHave unica nunca repete, chave primaria
            'End'                   => 'comercio/Fornecedor/Fornecedores_Add', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'comercio', // Modulo Referente
            'SubModulo'             => 'Fornecedor',   // Submodulo Referente
            'Metodo'                => 'Fornecedors_Add,Fornecedors_Add2',  // Metodos referentes separados por virgula
            'Permissao_Func'        => Array(// Permissoes NEcessarias
                'comercio_Fornecedor' => true
            ),
        ),
        Array(
            'Nome'                  => 'Comercio (Fornecedores) - Editar',
            'Desc'                  => '',
            'Chave'                 => 'comercio_Fornecedor_Fornecedores_Edit', // CHave unica nunca repete, chave primaria
            'End'                   => 'comercio/Fornecedor/Fornecedores_Edit', // Endereco que deve conter a url para permitir acesso // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'comercio', // Modulo Referente // Modulo Referente
            'SubModulo'             => 'Fornecedor',   // Submodulo Referente   // Submodulo Referente
            'Metodo'                => 'Fornecedors_Edit,Fornecedors_Edit2',  // Metodos referentes separados por virgula
            'Permissao_Func'        => Array(// Permissoes NEcessarias
                'comercio_Fornecedor' => true
            ),
        ),
        Array(
            'Nome'                  => 'Comercio (Fornecedores) - Deletar',
            'Desc'                  => '',
            'Chave'                 => 'comercio_Fornecedor_Fornecedores_Del', // CHave unica nunca repete, chave primaria
            'End'                   => 'comercio/Fornecedor/Fornecedores_Del', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'comercio', // Modulo Referente
            'SubModulo'             => 'Fornecedor',   // Submodulo Referente
            'Metodo'                => 'Fornecedores_Del',  // Metodos referentes separados por virgula
            'Permissao_Func'        => Array(// Permissoes NEcessarias
                'comercio_Fornecedor' => true
            ),
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
    return Array(
        'comercio_Produto_Obs'  => Array(
            'Nome'                  => 'Observação?',
            'Desc'                  => 'Se  produtos vao ter campo observacao',
            'chave'                 => 'comercio_Produto_Obs',
            'Valor'                 => false
        ),
        'comercio_Produto_Cod'  => Array(
            'Nome'                  => 'Cod?',
            'Desc'                  => 'Se produtos vao ter campo Codigo',
            'chave'                 => 'comercio_Produto_Cod',
            'Valor'                 => false
        ),
        'comercio_Produto'  => Array(
            'Nome'                  => 'Se Produtos estao ativados ou nao.',
            'Desc'                  => 'Se esta ativado os produtos ou nao no sistema',
            'chave'                 => 'comercio_Produto',
            'Valor'                 => true,
        ),
        'comercio_Vendas'  => Array(
            'Nome'                  => 'Se Produtos estao sendo vendidos.',
            'Desc'                  => 'Se Produtos estao sendo vendidos',
            'chave'                 => 'comercio_Vendas',
            'Valor'                 => false,
        ),
        'comercio_Marca'    => Array(
            'Nome'                  => 'Marca',
            'Desc'                  => 'Possui cadastro de Marcas em Produtos ?',
            'chave'                 => 'comercio_Marca',
            'Valor'                 => true,
        ),
        'comercio_Produto_Familia'  => Array(
            'Nome'                  => 'Marca com LInha ou Familia?',
            'Desc'                  => 'Se exibe Marca e Linha ou vai ter Familia',
            'chave'                 => 'comercio_Produto_Familia',
            'Valor'                 => 'Marca', // Marca OU Familia
        ),
        'comercio_Unidade'  => Array(
            'Nome'                  => 'Unidade?',
            'Desc'                  => 'Se vai ter Unidades',
            'chave'                 => 'comercio_Unidade',
            'Valor'                 => false
        ),
        'comercio_Estoque'  => Array(
            'Nome'                  => 'Estoque',
            'Desc'                  => 'Ativado ou não sistema de Estoque.',
            'chave'                 => 'comercio_Estoque',
            'Valor'                 => false,
        ),
        'comercio_Estoque_EntradaCategoria'  => Array(
            'Nome'                  => 'EntradaCategoria',
            'Desc'                  => 'Ativado ou não centro de custo em entrada de Nota Fiscal.',
            'chave'                 => 'comercio_Fornecedor',
            'Valor'                 => true,
        ),
        
        'comercio_Linha_Widget'  => Array(
            'Nome'                  => 'Widget de Linhas',
            'Desc'                  => 'Widget na Home',
            'chave'                 => 'comercio_Linha_Widget',
            'Valor'                 => true,
        ),
        'comercio_Fornecedor'  => Array(
            'Nome'                  => 'Fornecedor',
            'Desc'                  => 'Ativado ou não sistema modulo de Fornecedores.',
            'chave'                 => 'comercio_Fornecedor',
            'Valor'                 => true,
        ),
        'comercio_Fornecedor_Categoria'  => Array(
            'Nome'                  => 'Tipo de Fornecedor',
            'Desc'                  => 'Ativado ou não tipo de Fornecedores.',
            'chave'                 => 'comercio_Fornecedor_Categoria',
            'Valor'                 => true,
        ),
        
        
        // Propostas
        'comercio_Propostas'  => Array(
            'Nome'                  => 'Se possui Propostas',
            'Desc'                  => 'Se possui Propostas',
            'chave'                 => 'comercio_Propostas',
            'Valor'                 => true,
        ),
        'comercio_Propostas_Sub'  => Array(
            'Nome'                  => 'Se possui SubPropostas',
            'Desc'                  => 'Se possui SubPropostas',
            'chave'                 => 'comercio_Propostas_Sub',
            'Valor'                 => false,
        ),
        'comercio_Propostas_Biblioteca'  => Array(
            'Nome'                  => 'Se possui Biblioteca em Propostas',
            'Desc'                  => 'Se possui Biblioteca em Propostas',
            'chave'                 => 'comercio_Propostas_Biblioteca',
            'Valor'                 => false,
        ),
        'comercio_Propostas_Biblioteca_Automatico'  => Array(
            'Nome'                  => 'Se cria Biblioteca automaticamente em Propostas',
            'Desc'                  => 'Se cria Biblioteca automaticamente  em Propostas',
            'chave'                 => 'comercio_Propostas_Biblioteca_Automatico',
            'Valor'                 => false,
        ),
        /**
         * Se Carrega Com Si Custo de Mao de Obra
         */
        'comercio_Propostas_MaodeObra'  => Array(
            'Nome'                  => 'Se possui Mao de Obra em Propostas',
            'Desc'                  => 'Se possui Mao de Obra em Propostas',
            'chave'                 => 'comercio_Propostas_MaodeObra',
            'Valor'                 => false,
        ),
        'comercio_Propostas_Imposto'  => Array(
            'Nome'                  => 'Proposta -> Imposto',
            'Desc'                  => 'Se possui Imposto em Proposta',
            'chave'                 => 'comercio_Propostas_Imposto',
            'Valor'                 => false,
        ),
        /* 
         * Caso Verdadeiro, Usuario Escreve o Valor Final do Sistema 
         * Isso pode afetar lucro e desconto
         */
        'comercio_Proposta_ValorFinal'  => Array(
            'Nome'                  => 'Propostas -> Valor Final',
            'Desc'                  => 'Se possui Valor Final',
            'chave'                 => 'comercio_Proposta_ValorFinal',
            'Valor'                 => false,
        ),
        'comercio_Proposta_ValorExtra'  => Array(
            'Nome'                  => 'Propostas -> Se possui Valor Extra a ser somado ao custo',
            'Desc'                  => 'Se possui Valor Extra a ser somado ao custo',
            'chave'                 => 'comercio_Proposta_ValorExtra',
            'Valor'                 => false,
        ),
        'comercio_Proposta_Comissao'  => Array(
            'Nome'                  => 'Propostas -> Se possui Comissao Extra',
            'Desc'                  => 'Se possui Comissao Extra',
            'chave'                 => 'comercio_Proposta_Comissao',
            'Valor'                 => false,
        ),
        'comercio_Proposta_Lucro'  => Array(
            'Nome'                  => 'Propostas -> % de Lucro',
            'Desc'                  => 'Se possui Percentual de Lucro.',
            'chave'                 => 'comercio_Proposta_Lucro',
            'Valor'                 => true,
        ),
        'comercio_Proposta_Desconto'  => Array(
            'Nome'                  => 'Propostas -> % de Desconto',
            'Desc'                  => 'Se possui Percentual de Desconto.',
            'chave'                 => 'comercio_Proposta_Desconto',
            'Valor'                 => true,
        ),
        'comercio_Proposta_Referencia'  => Array(
            'Nome'                  => 'Propostas -> Campo Referencia',
            'Desc'                  => 'Se possui campo referencia em Propostas.',
            'chave'                 => 'comercio_Proposta_Referencia',
            'Valor'                 => false,
        ),
        'comercio_Proposta_Telefone'  => Array(
            'Nome'                  => 'Propostas -> Campo Telefone',
            'Desc'                  => 'Se possui campo Telefone em Propostas',
            'chave'                 => 'comercio_Proposta_Telefone',
            'Valor'                 => false,
        ),
        'comercio_Proposta_Checklist'  => Array(
            'Nome'                  => 'Propostas -> Campo Checklist',
            'Desc'                  => 'Se possui campo Checklist em Propostas',
            'chave'                 => 'comercio_Proposta_Checklist',
            'Valor'                 => false,
        ),
        
        // VISITAS
        'comercio_Visitas'  => Array(
            'Nome'                  => 'Se possui Folha de Visitas',
            'Desc'                  => 'Se possui Folha de Visitas',
            'chave'                 => 'comercio_Visitas',
            'Valor'                 => true,
        ),
    );
};
?>
