<?php
$configModule = function () {
    return Array(
        'Nome'                      =>  'comercio_servicos',
        'Descrição'                 =>  '',
        'System_Require'            =>  '3.1.0',
        'Version'                   =>  '3.1.1',
        'Dependencias'              =>  Array('comercio', 'usuario'),
    );
};
$configMenu = function () {
    return Array(
        'Administrar'=>Array(
            'Filhos'                => Array(\Framework\App\Acl::Sistema_Modulos_Configs_Funcional('comercio_servicos_Titulo')=>Array(
                'Nome'                  => \Framework\App\Acl::Sistema_Modulos_Configs_Funcional('comercio_servicos_Titulo'),
                'Link'                  => 'comercio_servicos/Servico/Servico',
                'Gravidade'             => 9,
                'Img'                   => 'turboadmin/m-dashboard.png',
                'Icon'                  => 'archive',
                'Filhos'                => FALSE,
            ),'Tipos de Serviços'=>Array(
                'Nome'                  => __('Tipos de Serviços'),
                'Link'                  => 'comercio_servicos/ServicoTipo/Servico_Tipo',
                'Gravidade'             => 8,
                'Img'                   => 'turboadmin/m-dashboard.png',
                'Icon'                  => 'tags',
                'Permissao_Func'        => Array(// Permissoes NEcessarias
                    'comercio_servicos_ServicoTipo' => TRUE
                ),
                'Filhos'                => FALSE,
            ),'Btu\'s'=>Array(
                'Nome'                  => __('Btus'),
                'Link'                  => 'comercio_servicos/Instalacao/Btu',
                'Gravidade'             => 8,
                'Img'                   => 'turboadmin/m-dashboard.png',
                'Icon'                  => 'bolt',
                'Permissao_Func'        => Array(// Permissoes NEcessarias
                    'comercio_servicos_Instalacao' => TRUE
                ),
                'Filhos'                => FALSE,
            ),'Suporte'=>Array(
                'Nome'                  => __('Suporte'),
                'Link'                  => 'comercio_servicos/Instalacao/Suporte',
                'Gravidade'             => 8,
                'Img'                   => 'turboadmin/m-dashboard.png',
                'Icon'                  => 'globe',
                'Permissao_Func'        => Array(// Permissoes NEcessarias
                    'comercio_servicos_Instalacao' => TRUE
                ),
                'Filhos'                => FALSE,
            )),
        )
    );
};
$config_Permissoes = function () {
    return Array(
        
        // SERVICOS
        Array(
            'Nome'                  => __('Serviços (').\Framework\App\Acl::Sistema_Modulos_Configs_Funcional('comercio_servicos_Titulo').') - Listagem',
            'Desc'                  => '',
            'Chave'                 => 'comercio_servicos_Servico_Servico',
            'End'                   => 'comercio_servicos/Servico/Servico', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'comercio_servicos', // Modulo Referente
            'SubModulo'             => 'Servico',   // Submodulo Referente
            'Metodo'                => 'Servico',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => __('Serviços (').\Framework\App\Acl::Sistema_Modulos_Configs_Funcional('comercio_servicos_Titulo').') - Add',
            'Desc'                  => '',
            'Chave'                 => 'comercio_servicos_Servico_Servicos_Add', // CHave unica nunca repete, chave primaria
            'End'                   => 'comercio_servicos/Servico/Servicos_Add', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'comercio_servicos', // Modulo Referente
            'SubModulo'             => 'Servico',   // Submodulo Referente
            'Metodo'                => 'Servicos_Add,Servicos_Add2',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => __('Serviços (').\Framework\App\Acl::Sistema_Modulos_Configs_Funcional('comercio_servicos_Titulo').') - Editar',
            'Desc'                  => '',
            'Chave'                 => 'comercio_servicos_Servico_Servicos_Edit', // CHave unica nunca repete, chave primaria
            'End'                   => 'comercio_servicos/Servico/Servicos_Edit', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'comercio_servicos', // Modulo Referente
            'SubModulo'             => 'Servico',// Submodulo Referente
            'Metodo'                => 'Servicos_Edit,Servicos_Edit2',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => __('Serviços (').\Framework\App\Acl::Sistema_Modulos_Configs_Funcional('comercio_servicos_Titulo').') - Deletar',
            'Desc'                  => '',
            'Chave'                 => 'comercio_servicos_Servico_Servicos_Del', // CHave unica nunca repete, chave primaria
            'End'                   => 'comercio_servicos/Servico/Servicos_Del', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'comercio_servicos', // Modulo Referente
            'SubModulo'             => 'Servico',   // Submodulo Referente
            'Metodo'                => 'Servicos_Del',  // Metodos referentes separados por virgula
        ),
        
        
        
        
        // Tipos de Servicos
        Array(
            'Nome'                  => __('Serviços (Tipos) - Listagem'),
            'Desc'                  => '',
            'Chave'                 => 'comercio_servicos_ServicoTipo_Servico_Tipo',
            'End'                   => 'comercio_servicos/ServicoTipo/Servico_Tipo', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'comercio_servicos', // Modulo Referente
            'SubModulo'             => 'ServicoTipo',   // Submodulo Referente
            'Metodo'                => 'Servico_Tipo',  // Metodos referentes separados por virgula
            'Permissao_Func'        => Array(// Permissoes NEcessarias
                'comercio_servicos_ServicoTipo' => TRUE
            ),
        ),
        Array(
            'Nome'                  => __('Serviços (Tipos) - Add'),
            'Desc'                  => '',
            'Chave'                 => 'comercio_servicos_ServicoTipo_Servico_Tipo_Add', // CHave unica nunca repete, chave primaria
            'End'                   => 'comercio_servicos/ServicoTipo/Servico_Tipo_Add', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'comercio_servicos', // Modulo Referente
            'SubModulo'             => 'ServicoTipo',   // Submodulo Referente
            'Metodo'                => 'Servico_Tipo_Add,Servico_Tipo_Add2',  // Metodos referentes separados por virgula
            'Permissao_Func'        => Array(// Permissoes NEcessarias
                'comercio_servicos_ServicoTipo' => TRUE
            ),
        ),
        Array(
            'Nome'                  => __('Serviços (Tipos) - Editar'),
            'Desc'                  => '',
            'Chave'                 => 'comercio_servicos_ServicoTipo_Servico_Tipo_Edit', // CHave unica nunca repete, chave primaria
            'End'                   => 'comercio_servicos/ServicoTipo/Servico_Tipo_Edit', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'comercio_servicos', // Modulo Referente
            'SubModulo'             => 'ServicoTipo',// Submodulo Referente
            'Metodo'                => 'Servico_Tipo_Edit,Servico_Tipo_Edit2',  // Metodos referentes separados por virgula
            'Permissao_Func'        => Array(// Permissoes NEcessarias
                'comercio_servicos_ServicoTipo' => TRUE
            ),
        ),
        Array(
            'Nome'                  => __('Serviços (Tipos) - Deletar'),
            'Desc'                  => '',
            'Chave'                 => 'comercio_servicos_ServicoTipo_Servico_Tipo_Del', // CHave unica nunca repete, chave primaria
            'End'                   => 'comercio_servicos/ServicoTipo/Servico_Tipo_Del', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'comercio_servicos', // Modulo Referente
            'SubModulo'             => 'ServicoTipo',   // Submodulo Referente
            'Metodo'                => 'Servico_Tipo_Del',  // Metodos referentes separados por virgula
            'Permissao_Func'        => Array(// Permissoes NEcessarias
                'comercio_servicos_ServicoTipo' => TRUE
            ),
        ),
        
        
        // BTU
        Array(
            'Nome'                  => __('Serviços (Instalação BTU) - Listagem'),
            'Desc'                  => '',
            'Chave'                 => 'comercio_servicos_Instalacao_Btu',
            'End'                   => 'comercio_servicos/Instalacao/Btu', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'comercio_servicos', // Modulo Referente
            'SubModulo'             => 'Instalacao',   // Submodulo Referente
            'Metodo'                => 'Btu',  // Metodos referentes separados por virgula
            'Permissao_Func'        => Array(// Permissoes NEcessarias
                'comercio_servicos_Instalacao' => TRUE
            ),
        ),
        Array(
            'Nome'                  => __('Serviços (Instalação BTU) - Add'),
            'Desc'                  => '',
            'Chave'                 => 'comercio_Servicos_Instalacao_Btu_Add', // CHave unica nunca repete, chave primaria
            'End'                   => 'comercio_servicos/Instalacao/Btu_Add', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'comercio_servicos', // Modulo Referente
            'SubModulo'             => 'Instalacao',   // Submodulo Referente
            'Metodo'                => 'Btu_Add,Btu_Add2',  // Metodos referentes separados por virgula
            'Permissao_Func'        => Array(// Permissoes NEcessarias
                'comercio_servicos_Instalacao' => TRUE
            ),
        ),
        Array(
            'Nome'                  => __('Serviços (Instalação BTU) - Editar'),
            'Desc'                  => '',
            'Chave'                 => 'comercio_servicos_Instalacao_Btu_Edit', // CHave unica nunca repete, chave primaria
            'End'                   => 'comercio_servicos/Instalacao/Btu_Edit', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'comercio_servicos', // Modulo Referente
            'SubModulo'             => 'Instalacao',// Submodulo Referente
            'Metodo'                => 'Btu_Edit,Btu_Edit2',  // Metodos referentes separados por virgula
            'Permissao_Func'        => Array(// Permissoes NEcessarias
                'comercio_servicos_Instalacao' => TRUE
            ),
        ),
        Array(
            'Nome'                  => __('Serviços (Instalação BTU) - Deletar'),
            'Desc'                  => '',
            'Chave'                 => 'comercio_servicos_Instalacao_Btu_Del', // CHave unica nunca repete, chave primaria
            'End'                   => 'comercio_servicos/Instalacao/Btu_Del', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'comercio_servicos', // Modulo Referente
            'SubModulo'             => 'Instalacao',   // Submodulo Referente
            'Metodo'                => 'Btu_Del',  // Metodos referentes separados por virgula
            'Permissao_Func'        => Array(// Permissoes NEcessarias
                'comercio_servicos_Instalacao' => TRUE
            ),
        ),
        
        
        // Suporte
        Array(
            'Nome'                  => __('Serviços (Instalação Suporte) - Listagem'),
            'Desc'                  => '',
            'Chave'                 => 'comercio_servicos_Instalacao_Suporte',
            'End'                   => 'comercio_servicos/Instalacao/Suporte', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'comercio_servicos', // Modulo Referente
            'SubModulo'             => 'Instalacao',   // Submodulo Referente
            'Metodo'                => 'Suporte',  // Metodos referentes separados por virgula
            'Permissao_Func'        => Array(// Permissoes NEcessarias
                'comercio_servicos_Instalacao' => TRUE
            ),
        ),
        Array(
            'Nome'                  => __('Serviços (Instalação Suporte) - Add'),
            'Desc'                  => '',
            'Chave'                 => 'comercio_Servicos_Instalacao_Suporte_Add', // CHave unica nunca repete, chave primaria
            'End'                   => 'comercio_servicos/Instalacao/Suporte_Add', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'comercio_servicos', // Modulo Referente
            'SubModulo'             => 'Instalacao',   // Submodulo Referente
            'Metodo'                => 'Suporte_Add,Suporte_Add2',  // Metodos referentes separados por virgula
            'Permissao_Func'        => Array(// Permissoes NEcessarias
                'comercio_servicos_Instalacao' => TRUE
            ),
        ),
        Array(
            'Nome'                  => __('Serviços (Instalação Suporte) - Editar'),
            'Desc'                  => '',
            'Chave'                 => 'comercio_servicos_Instalacao_Suporte_Edit', // CHave unica nunca repete, chave primaria
            'End'                   => 'comercio_servicos/Instalacao/Suporte_Edit', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'comercio_servicos', // Modulo Referente
            'SubModulo'             => 'Instalacao',// Submodulo Referente
            'Metodo'                => 'Suporte_Edit,Suporte_Edit2',  // Metodos referentes separados por virgula
            'Permissao_Func'        => Array(// Permissoes NEcessarias
                'comercio_servicos_Instalacao' => TRUE
            ),
        ),
        Array(
            'Nome'                  => __('Serviços (Instalação Suporte) - Deletar'),
            'Desc'                  => '',
            'Chave'                 => 'comercio_servicos_Instalacao_Suporte_Del', // CHave unica nunca repete, chave primaria
            'End'                   => 'comercio_servicos/Instalacao/Suporte_Del', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'comercio_servicos', // Modulo Referente
            'SubModulo'             => 'Instalacao',   // Submodulo Referente
            'Metodo'                => 'Suporte_Del',  // Metodos referentes separados por virgula
            'Permissao_Func'        => Array(// Permissoes NEcessarias
                'comercio_servicos_Instalacao' => TRUE
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
$config_Funcional = function () {
    return Array(
        'comercio_servicos_ServicoTipo' => Array(
            'Nome'                  => 'Serviços -> Tipo',
            'Desc'                  => __('Se possui Tipo'),
            'chave'                 => 'comercio_servicos_ServicoTipo',
            'Valor'                 => TRUE,
        ),
        'comercio_servicos_nome' => Array(
            'Nome'                  => 'Serviços -> Nome',
            'Desc'                  => __('Se possue nome'),
            'chave'                 => 'comercio_servicos_nome',
            'Valor'                 => FALSE,
        ),
        'comercio_servicos_Titulo' => Array(
            'Nome'                  => 'Serviços -> Nome',
            'Desc'                  => __('Se possue nome'),
            'chave'                 => 'comercio_servicos_Titulo',
            'Valor'                 => 'Serviços',
        ),
        // Instalação
        'comercio_servicos_Instalacao'    => Array(
            'Nome'                  => __('Servico de Instalacao'),
            'Desc'                  => __('Fornece serviço de instalacao de ar, gas e linha ?'),
            'chave'                 => 'comercio_servicos_Instalacao',
            'Valor'                 => FALSE,
        ),
    );
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
