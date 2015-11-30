<?php
$config_Modulo = function (){
    return Array(
        'Nome'                      =>  'usuario_veiculo',
        'Descrição'                 =>  '',
        'System_Require'            =>  '2.21.1',
        'Version'                   =>  '0.0.1',
        'Dependencias'              =>  false,
    );
};
$config_Menu = function (){
    return Array(
        'Administrar' => Array(
            'Filhos'                => Array('Veiculos'=>Array(
                'Nome'                  => 'Veiculos',
                'Link'                  => 'usuario_veiculo/Veiculo/Veiculos',
                'Gravidade'             => 70,
                'Img'                   => '',
                'Icon'                  => 'road',
                'Filhos'                => false,
            ),'Equipamentos'=>Array(
                'Nome'                  => 'Equipamentos',
                'Link'                  => 'usuario_veiculo/Equipamento/Equipamentos',
                'Gravidade'             => 60,
                'Img'                   => '',
                'Icon'                  => 'laptop',
                'Permissao_Func'        => Array(// Permissoes NEcessarias
                    'usuario_veiculo_Equipamento' => true
                ),
                'Filhos'                => false,
            ),),
        ),
    );
};
$config_Permissoes = function (){
    return Array(
        
        //Veiculos
        Array(
            'Nome'                  => 'Veiculos - Listagem',
            'Desc'                  => '',
            'Chave'                 => 'usuario_veiculo_Veiculo_Veiculos',
            'End'                   => 'usuario_veiculo/Veiculo/Veiculos', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'usuario_veiculo', // Modulo Referente
            'SubModulo'             => 'Veiculo',   // Submodulo Referente
            'Metodo'                => 'Veiculos',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => 'Veiculos - Adicionar',
            'Desc'                  => '',
            'Chave'                 => 'usuario_veiculo_Veiculo_Veiculos_Add',
            'End'                   => 'usuario_veiculo/Veiculo/Veiculos_Add', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'usuario_veiculo', // Modulo Referente
            'SubModulo'             => 'Veiculo',   // Submodulo Referente
            'Metodo'                => 'Veiculos_Add,Veiculos_Add2',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => 'Veiculos - Editar',
            'Desc'                  => '',
            'Chave'                 => 'usuario_veiculo_Veiculo_Veiculos_Edit',
            'End'                   => 'usuario_veiculo/Veiculo/Veiculos_Edit', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'usuario_veiculo', // Modulo Referente
            'SubModulo'             => 'Veiculo',   // Submodulo Referente
            'Metodo'                => 'Veiculos_Edit,Veiculos_Edit2',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => 'Veiculos - Deletar',
            'Desc'                  => '',
            'Chave'                 => 'usuario_veiculo_Veiculo_Veiculos_Del',
            'End'                   => 'usuario_veiculo/Veiculo/Veiculos_Del', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'usuario_veiculo', // Modulo Referente
            'SubModulo'             => 'Veiculo',   // Submodulo Referente
            'Metodo'                => 'Veiculos_Del',  // Metodos referentes separados por virgula
        ),
        
        //Veiculos_Comentario
        Array(
            'Nome'                  => 'Veiculos (Comentarios) - Listagem',
            'Desc'                  => '',
            'Chave'                 => 'usuario_veiculo_Veiculo_Veiculos_Comentario',
            'End'                   => 'usuario_veiculo/Veiculo/Veiculos_Comentario', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'usuario_veiculo', // Modulo Referente
            'SubModulo'             => 'Veiculo',   // Submodulo Referente
            'Metodo'                => 'Veiculos_Comentario',  // Metodos referentes separados por virgula
            'Permissao_Func'        => Array(// Permissoes NEcessarias
                'usuario_veiculo_Comentario' => true
            ),
        ),
        Array(
            'Nome'                  => 'Veiculos (Comentarios) - Adicionar',
            'Desc'                  => '',
            'Chave'                 => 'usuario_veiculo_Veiculo_Veiculos_Comentario_Add',
            'End'                   => 'usuario_veiculo/Veiculo/Veiculos_Comentario_Add', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'usuario_veiculo', // Modulo Referente
            'SubModulo'             => 'Veiculo',   // Submodulo Referente
            'Metodo'                => 'Veiculos_Comentario_Add,Veiculos_Comentario_Add2',  // Metodos referentes separados por virgula
            'Permissao_Func'        => Array(// Permissoes NEcessarias
                'usuario_veiculo_Comentario' => true
            ),
        ),
        Array(
            'Nome'                  => 'Veiculos (Comentarios) - Editar Comentarios',
            'Desc'                  => '',
            'Chave'                 => 'usuario_veiculo_Veiculo_Veiculos_Comentario_Edit',
            'End'                   => 'usuario_veiculo/Veiculo/Veiculos_Comentario_Edit', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'usuario_veiculo', // Modulo Referente
            'SubModulo'             => 'Veiculo',   // Submodulo Referente
            'Metodo'                => 'Veiculos_Comentario_Edit,Veiculos_Comentario_Edit2',  // Metodos referentes separados por virgula
            'Permissao_Func'        => Array(// Permissoes NEcessarias
                'usuario_veiculo_Comentario' => true
            ),
        ),
        Array(
            'Nome'                  => 'Veiculos (Comentarios) - Deletar Comentarios',
            'Desc'                  => '',
            'Chave'                 => 'usuario_veiculo_Veiculo_Veiculos_Comentario_Del',
            'End'                   => 'usuario_veiculo/Veiculo/Veiculos_Comentario_Del', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'usuario_veiculo', // Modulo Referente
            'SubModulo'             => 'Veiculo',   // Submodulo Referente
            'Metodo'                => 'Veiculos_Comentario_Del',  // Metodos referentes separados por virgula
            'Permissao_Func'        => Array(// Permissoes NEcessarias
                'usuario_veiculo_Comentario' => true
            ),
        ),
        
        // Equipamentos
        Array(
            'Nome'                  => 'Equipamentos - Listagem',
            'Desc'                  => '',
            'Chave'                 => 'usuario_veiculo_Equipamento',
            'End'                   => 'usuario_veiculo/Equipamento', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'usuario_veiculo', // Modulo Referente
            'SubModulo'             => 'Equipamento',   // Submodulo Referente
            'Metodo'                => '*',  // Metodos referentes separados por virgula
            'Permissao_Func'        => Array(// Permissoes NEcessarias
                'usuario_veiculo_Equipamento' => true
            ),
        ),
        Array(
            'Nome'                  => 'Equipamentos - Adicionar Equipamentos',
            'Desc'                  => '',
            'Chave'                 => 'usuario_veiculo_Equipamento_Equipamentos_Add',
            'End'                   => 'usuario_veiculo/Equipamento/Equipamentos_Add', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'usuario_veiculo', // Modulo Referente
            'SubModulo'             => 'Equipamento',   // Submodulo Referente
            'Metodo'                => 'Equipamentos_Add,Equipamentos_Add2',  // Metodos referentes separados por virgula
            'Permissao_Func'        => Array(// Permissoes NEcessarias
                'usuario_veiculo_Equipamento' => true
            ),
        ),
        Array(
            'Nome'                  => 'Equipamentos - Editar Equipamentos',
            'Desc'                  => '',
            'Chave'                 => 'usuario_veiculo_Equipamento_Equipamentos_Edit',
            'End'                   => 'usuario_veiculo/Equipamento/Equipamentos_Edit', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'usuario_veiculo', // Modulo Referente
            'SubModulo'             => 'Equipamento',   // Submodulo Referente
            'Metodo'                => 'Equipamentos_Edit,Equipamentos_Edit2',  // Metodos referentes separados por virgula
            'Permissao_Func'        => Array(// Permissoes NEcessarias
                'usuario_veiculo_Equipamento' => true
            ),
        ),
        Array(
            'Nome'                  => 'Equipamentos - Deletar Equipamentos',
            'Desc'                  => '',
            'Chave'                 => 'usuario_veiculo_Equipamento_Equipamentos_Del',
            'End'                   => 'usuario_veiculo/Equipamento/Equipamentos_Del', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'usuario_veiculo', // Modulo Referente
            'SubModulo'             => 'Equipamento',   // Submodulo Referente
            'Metodo'                => 'Equipamentos_Del',  // Metodos referentes separados por virgula
            'Permissao_Func'        => Array(// Permissoes NEcessarias
                'usuario_veiculo_Equipamento' => true
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
$config_Funcional = function (){
    return Array(
        'usuario_veiculo_VeiculoIPVA'       => Array(
            'Nome'                  => 'Veiculos -> IPVA',
            'chave'                 => 'usuario_veiculo_VeiculoIPVA',
            'Desc'                  => 'Se existe IPVA no cadastro de Veiculo',
            'Valor'                 => true,
        ),
        'usuario_veiculo_VeiculoREVISAO'     => Array(
            'Nome'                  => 'Veiculos -> REVISAO',
            'chave'                 => 'usuario_veiculo_VeiculoREVISAO',
            'Desc'                  => 'Se existe REVISAO no cadastro de Veiculo',
            'Valor'                 => true,
        ),
        'usuario_veiculo_VeiculoVALOR'      => Array(
            'Nome'                  => 'Veiculos -> VALOR',
            'chave'                 => 'usuario_veiculo_VeiculoVALOR',
            'Desc'                  => 'Se existe VALOR no cadastro de Veiculo',
            'Valor'                 => true,
        ),
        'usuario_veiculo_VeiculoVISTORIA'      => Array(
            'Nome'                  => 'Veiculos -> VISTORIA',
            'chave'                 => 'usuario_veiculo_VeiculoVISTORIA',
            'Desc'                  => 'Se existe VISTORIA no cadastro de Veiculo',
            'Valor'                 => false,
        ),
        'usuario_veiculo_VeiculoRENAVAN'      => Array(
            'Nome'                  => 'Veiculos -> RENAVAN',
            'chave'                 => 'usuario_veiculo_VeiculoRENAVAN',
            'Desc'                  => 'Se existe RENAVAN no cadastro de Veiculo',
            'Valor'                 => false,
        ),
        'usuario_veiculo_VeiculoOBS'      => Array(
            'Nome'                  => 'Veiculos -> OBS',
            'chave'                 => 'usuario_veiculo_VeiculoOBS',
            'Desc'                  => 'Se existe OBS no cadastro de Veiculo',
            'Valor'                 => true,
        ),
        'usuario_veiculo_Comentario'       => Array(
            'Nome'                  => 'Comentário',
            'chave'                 => 'usuario_veiculo_Comentario',
            'Desc'                  => 'Se existe Comentários',
            'Valor'                 => true,
        ),
        'usuario_veiculo_Evento'       => Array(
            'Nome'                  => 'Evento',
            'chave'                 => 'usuario_veiculo_Evento',
            'Desc'                  => 'Se existe Evento',
            'Valor'                 => false,
        ),
        'usuario_veiculo_Equipamento'       => Array(
            'Nome'                  => 'Equipamentos',
            'chave'                 => 'usuario_veiculo_Equipamento',
            'Desc'                  => 'Se existe Equipamentos',
            'Valor'                 => true,
        ),
        'usuario_veiculo_Status'       => Array(
            'Nome'                  => 'Status de Equipamentos',
            'chave'                 => 'usuario_veiculo_Status',
            'Desc'                  => 'Se existe Status em Equipamentos',
            'Valor'                 => true,
        ),
        'usuario_veiculo_Equipamento_Marca' => Array(
            'Nome'                  => 'Equipamentos -> Marca e Modelo',
            'chave'                 => 'usuario_veiculo_Equipamento_Marca',
            'Desc'                  => 'Se exibe opção de marca e modelo pra equipamentos',
            'Valor'                 => false,
        ),
        'usuario_veiculo_VeiculoAVALIACAO' => Array(
            'Nome'                  => 'VEiculos -> data Avaliacao',
            'chave'                 => 'usuario_veiculo_VeiculoAVALIACAO',
            'Desc'                  => 'Se exibe opção de avaliacao para carros',
            'Valor'                 => false,
        ),
    );
};
?>
