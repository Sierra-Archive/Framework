<?php
$configModule = function () {
    return Array(
        'Nome'                      =>  'usuario_veiculo',
        'Descrição'                 =>  '',
        'System_Require'            =>  '3.1.0',
        'Version'                   =>  '3.1.1',
        'Dependencias'              =>  FALSE,
    );
};
$configMenu = function () {
    return Array(
        'Administrar' => Array(
            'Filhos'                => Array('Veiculos'=>Array(
                'Nome'                  => __('Veiculos'),
                'Link'                  => 'usuario_veiculo/Veiculo/Veiculos',
                'Gravidade'             => 70,
                'Img'                   => '',
                'Icon'                  => 'road',
                'Filhos'                => FALSE,
            ),'Equipamentos'=>Array(
                'Nome'                  => __('Equipamentos'),
                'Link'                  => 'usuario_veiculo/Equipamento/Equipamentos',
                'Gravidade'             => 60,
                'Img'                   => '',
                'Icon'                  => 'laptop',
                'Permissao_Func'        => Array(// Permissoes NEcessarias
                    'usuario_veiculo_Equipamento' => TRUE
                ),
                'Filhos'                => FALSE,
            ),),
        ),
    );
};
$config_Permissoes = function () {
    return Array(
        
        //Veiculos
        Array(
            'Nome'                  => __('Veiculos - Listagem'),
            'Desc'                  => '',
            'Chave'                 => 'usuario_veiculo_Veiculo_Veiculos',
            'End'                   => 'usuario_veiculo/Veiculo/Veiculos', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'usuario_veiculo', // Modulo Referente
            'SubModulo'             => 'Veiculo',   // Submodulo Referente
            'Metodo'                => 'Veiculos',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => __('Veiculos - Adicionar'),
            'Desc'                  => '',
            'Chave'                 => 'usuario_veiculo_Veiculo_Veiculos_Add',
            'End'                   => 'usuario_veiculo/Veiculo/Veiculos_Add', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'usuario_veiculo', // Modulo Referente
            'SubModulo'             => 'Veiculo',   // Submodulo Referente
            'Metodo'                => 'Veiculos_Add,Veiculos_Add2',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => __('Veiculos - Editar'),
            'Desc'                  => '',
            'Chave'                 => 'usuario_veiculo_Veiculo_Veiculos_Edit',
            'End'                   => 'usuario_veiculo/Veiculo/Veiculos_Edit', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'usuario_veiculo', // Modulo Referente
            'SubModulo'             => 'Veiculo',   // Submodulo Referente
            'Metodo'                => 'Veiculos_Edit,Veiculos_Edit2',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => __('Veiculos - Deletar'),
            'Desc'                  => '',
            'Chave'                 => 'usuario_veiculo_Veiculo_Veiculos_Del',
            'End'                   => 'usuario_veiculo/Veiculo/Veiculos_Del', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'usuario_veiculo', // Modulo Referente
            'SubModulo'             => 'Veiculo',   // Submodulo Referente
            'Metodo'                => 'Veiculos_Del',  // Metodos referentes separados por virgula
        ),
        
        //Veiculos_Comentario
        Array(
            'Nome'                  => __('Veiculos (Comentarios) - Listagem'),
            'Desc'                  => '',
            'Chave'                 => 'usuario_veiculo_Veiculo_Veiculos_Comentario',
            'End'                   => 'usuario_veiculo/Veiculo/Veiculos_Comentario', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'usuario_veiculo', // Modulo Referente
            'SubModulo'             => 'Veiculo',   // Submodulo Referente
            'Metodo'                => 'Veiculos_Comentario',  // Metodos referentes separados por virgula
            'Permissao_Func'        => Array(// Permissoes NEcessarias
                'usuario_veiculo_Comentario' => TRUE
            ),
        ),
        Array(
            'Nome'                  => __('Veiculos (Comentarios) - Adicionar'),
            'Desc'                  => '',
            'Chave'                 => 'usuario_veiculo_Veiculo_Veiculos_Comentario_Add',
            'End'                   => 'usuario_veiculo/Veiculo/Veiculos_Comentario_Add', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'usuario_veiculo', // Modulo Referente
            'SubModulo'             => 'Veiculo',   // Submodulo Referente
            'Metodo'                => 'Veiculos_Comentario_Add,Veiculos_Comentario_Add2',  // Metodos referentes separados por virgula
            'Permissao_Func'        => Array(// Permissoes NEcessarias
                'usuario_veiculo_Comentario' => TRUE
            ),
        ),
        Array(
            'Nome'                  => __('Veiculos (Comentarios) - Editar Comentarios'),
            'Desc'                  => '',
            'Chave'                 => 'usuario_veiculo_Veiculo_Veiculos_Comentario_Edit',
            'End'                   => 'usuario_veiculo/Veiculo/Veiculos_Comentario_Edit', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'usuario_veiculo', // Modulo Referente
            'SubModulo'             => 'Veiculo',   // Submodulo Referente
            'Metodo'                => 'Veiculos_Comentario_Edit,Veiculos_Comentario_Edit2',  // Metodos referentes separados por virgula
            'Permissao_Func'        => Array(// Permissoes NEcessarias
                'usuario_veiculo_Comentario' => TRUE
            ),
        ),
        Array(
            'Nome'                  => __('Veiculos (Comentarios) - Deletar Comentarios'),
            'Desc'                  => '',
            'Chave'                 => 'usuario_veiculo_Veiculo_Veiculos_Comentario_Del',
            'End'                   => 'usuario_veiculo/Veiculo/Veiculos_Comentario_Del', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'usuario_veiculo', // Modulo Referente
            'SubModulo'             => 'Veiculo',   // Submodulo Referente
            'Metodo'                => 'Veiculos_Comentario_Del',  // Metodos referentes separados por virgula
            'Permissao_Func'        => Array(// Permissoes NEcessarias
                'usuario_veiculo_Comentario' => TRUE
            ),
        ),
        
        // Equipamentos
        Array(
            'Nome'                  => __('Equipamentos - Listagem'),
            'Desc'                  => '',
            'Chave'                 => 'usuario_veiculo_Equipamento',
            'End'                   => 'usuario_veiculo/Equipamento', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'usuario_veiculo', // Modulo Referente
            'SubModulo'             => 'Equipamento',   // Submodulo Referente
            'Metodo'                => '*',  // Metodos referentes separados por virgula
            'Permissao_Func'        => Array(// Permissoes NEcessarias
                'usuario_veiculo_Equipamento' => TRUE
            ),
        ),
        Array(
            'Nome'                  => __('Equipamentos - Adicionar Equipamentos'),
            'Desc'                  => '',
            'Chave'                 => 'usuario_veiculo_Equipamento_Equipamentos_Add',
            'End'                   => 'usuario_veiculo/Equipamento/Equipamentos_Add', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'usuario_veiculo', // Modulo Referente
            'SubModulo'             => 'Equipamento',   // Submodulo Referente
            'Metodo'                => 'Equipamentos_Add,Equipamentos_Add2',  // Metodos referentes separados por virgula
            'Permissao_Func'        => Array(// Permissoes NEcessarias
                'usuario_veiculo_Equipamento' => TRUE
            ),
        ),
        Array(
            'Nome'                  => __('Equipamentos - Editar Equipamentos'),
            'Desc'                  => '',
            'Chave'                 => 'usuario_veiculo_Equipamento_Equipamentos_Edit',
            'End'                   => 'usuario_veiculo/Equipamento/Equipamentos_Edit', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'usuario_veiculo', // Modulo Referente
            'SubModulo'             => 'Equipamento',   // Submodulo Referente
            'Metodo'                => 'Equipamentos_Edit,Equipamentos_Edit2',  // Metodos referentes separados por virgula
            'Permissao_Func'        => Array(// Permissoes NEcessarias
                'usuario_veiculo_Equipamento' => TRUE
            ),
        ),
        Array(
            'Nome'                  => __('Equipamentos - Deletar Equipamentos'),
            'Desc'                  => '',
            'Chave'                 => 'usuario_veiculo_Equipamento_Equipamentos_Del',
            'End'                   => 'usuario_veiculo/Equipamento/Equipamentos_Del', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'usuario_veiculo', // Modulo Referente
            'SubModulo'             => 'Equipamento',   // Submodulo Referente
            'Metodo'                => 'Equipamentos_Del',  // Metodos referentes separados por virgula
            'Permissao_Func'        => Array(// Permissoes NEcessarias
                'usuario_veiculo_Equipamento' => TRUE
            ),
        )
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
        'usuario_veiculo_VeiculoIPVA'       => Array(
            'Nome'                  => 'Veiculos -> IPVA',
            'chave'                 => 'usuario_veiculo_VeiculoIPVA',
            'Desc'                  => __('Se existe IPVA no cadastro de Veiculo'),
            'Valor'                 => TRUE,
        ),
        'usuario_veiculo_VeiculoREVISAO'     => Array(
            'Nome'                  => 'Veiculos -> REVISAO',
            'chave'                 => 'usuario_veiculo_VeiculoREVISAO',
            'Desc'                  => __('Se existe REVISAO no cadastro de Veiculo'),
            'Valor'                 => TRUE,
        ),
        'usuario_veiculo_VeiculoVALOR'      => Array(
            'Nome'                  => 'Veiculos -> VALOR',
            'chave'                 => 'usuario_veiculo_VeiculoVALOR',
            'Desc'                  => __('Se existe VALOR no cadastro de Veiculo'),
            'Valor'                 => TRUE,
        ),
        'usuario_veiculo_VeiculoVISTORIA'      => Array(
            'Nome'                  => 'Veiculos -> VISTORIA',
            'chave'                 => 'usuario_veiculo_VeiculoVISTORIA',
            'Desc'                  => __('Se existe VISTORIA no cadastro de Veiculo'),
            'Valor'                 => FALSE,
        ),
        'usuario_veiculo_VeiculoRENAVAN'      => Array(
            'Nome'                  => 'Veiculos -> RENAVAN',
            'chave'                 => 'usuario_veiculo_VeiculoRENAVAN',
            'Desc'                  => __('Se existe RENAVAN no cadastro de Veiculo'),
            'Valor'                 => FALSE,
        ),
        'usuario_veiculo_VeiculoOBS'      => Array(
            'Nome'                  => 'Veiculos -> OBS',
            'chave'                 => 'usuario_veiculo_VeiculoOBS',
            'Desc'                  => __('Se existe OBS no cadastro de Veiculo'),
            'Valor'                 => TRUE,
        ),
        'usuario_veiculo_Comentario'       => Array(
            'Nome'                  => __('Comentário'),
            'chave'                 => 'usuario_veiculo_Comentario',
            'Desc'                  => __('Se existe Comentários'),
            'Valor'                 => TRUE,
        ),
        'usuario_veiculo_Evento'       => Array(
            'Nome'                  => __('Evento'),
            'chave'                 => 'usuario_veiculo_Evento',
            'Desc'                  => __('Se existe Evento'),
            'Valor'                 => FALSE,
        ),
        'usuario_veiculo_Equipamento'       => Array(
            'Nome'                  => __('Equipamentos'),
            'chave'                 => 'usuario_veiculo_Equipamento',
            'Desc'                  => __('Se existe Equipamentos'),
            'Valor'                 => TRUE,
        ),
        'usuario_veiculo_Status'       => Array(
            'Nome'                  => __('Status de Equipamentos'),
            'chave'                 => 'usuario_veiculo_Status',
            'Desc'                  => __('Se existe Status em Equipamentos'),
            'Valor'                 => TRUE,
        ),
        'usuario_veiculo_Equipamento_Marca' => Array(
            'Nome'                  => 'Equipamentos -> Marca e Modelo',
            'chave'                 => 'usuario_veiculo_Equipamento_Marca',
            'Desc'                  => __('Se exibe opção de marca e modelo pra equipamentos'),
            'Valor'                 => FALSE,
        ),
        'usuario_veiculo_VeiculoAVALIACAO' => Array(
            'Nome'                  => 'VEiculos -> data Avaliacao',
            'chave'                 => 'usuario_veiculo_VeiculoAVALIACAO',
            'Desc'                  => __('Se exibe opção de avaliacao para carros'),
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
