<?php
$configModule = function () {
    return Array(
        'Nome'                      =>  'Financeiro',
        'Descrição'                 =>  'Permite o controle de um banco '.
                                        'interno do sistema capaz de trocar dinheiro entre os usuarios e uma '.
                                        'Administração que permite inserir dinheiro aos usuarios, assim como uma opção de saque.',
        'System_Require'            =>  '3.1.0',
        'Version'                   =>  '3.1.1',
        'Dependencias'              =>  false,
    );
};
$configMenu = function () {
    return Array(
        'Relatório' => Array(
            'Filhos'                => Array(__('Financeiro')=>Array(
                'Nome'                  => __('Financeiro'),
                'Link'                  => 'Financeiro/Relatorio/Relatorio',
                'Gravidade'             => 3,
                'Img'                   => 'money',
                'Icon'                  => 'money',
                'Filhos'                => false,
            ),),
        ),
        'Gráfico' => Array(
            'Filhos'                => Array(__('Financeiro')=>Array(
                'Nome'                  => __('Financeiro'),
                'Link'                  => 'Financeiro/Relatorio/Grafico_Relatorio',
                'Gravidade'             => 2,
                'Img'                   => 'money',
                'Icon'                  => 'money',
                'Filhos'                => false,
            ),),
        ),
        'Financeiro' => Array(
            'Nome'                  => __('Financeiro'),
            'Link'                  => '#',
            'Gravidade'             => 20,
            'Img'                   => 'money',
            'Icon'                  => 'money',
            'Filhos'                => Array(
                'Formas de Pagamento'=>Array(
                    'Nome'                  => __('Formas de Pagamento'),
                    'Link'                  => 'Financeiro/Pagamento/Formas',
                    'Gravidade'             => 2,
                    'Img'                   => 'money',
                    'Icon'                  => 'money',
                    'Filhos'                => false,
                ),'Condições de Pagamento'=>Array(
                    'Nome'                  => __('Condições de Pagamento'),
                    'Link'                  => 'Financeiro/Pagamento/Condicoes',
                    'Gravidade'             => 1,
                    'Img'                   => 'money',
                    'Icon'                  => 'money',
                    'Filhos'                => false,
                ),'Contas à Pagar'=>Array(
                    'Nome'                  => __('Contas à Pagar'),
                    'Link'                  => 'Financeiro/Pagamento/Pagar',
                    'Gravidade'             => 10,
                    'Img'                   => 'money',
                    'Icon'                  => 'money',
                    'Filhos'                => false,
                ),'Contas Pagas'=>Array(
                    'Nome'                  => __('Contas Pagas'),
                    'Link'                  => 'Financeiro/Pagamento/Pago',
                    'Gravidade'             => 9,
                    'Img'                   => 'money',
                    'Icon'                  => 'money',
                    'Filhos'                => false,
                ),'Contas à Receber'=>Array(
                    'Nome'                  => __('Contas à Receber'),
                    'Link'                  => 'Financeiro/Pagamento/Receber',
                    'Gravidade'             => 8,
                    'Img'                   => 'money',
                    'Icon'                  => 'money',
                    'Filhos'                => false,
                ),'Contas Recebidas'=>Array(
                    'Nome'                  => __('Contas Recebidas'),
                    'Link'                  => 'Financeiro/Pagamento/Recebido',
                    'Gravidade'             => 7,
                    'Img'                   => 'money',
                    'Icon'                  => 'money',
                    'Filhos'                => false,
                ),'Finanças'=>Array(
                    'Nome'                  => __('Finanças'),
                    'Link'                  => 'Financeiro/Financa/Financas',
                    'Gravidade'             => 6,
                    'Img'                   => 'money',
                    'Icon'                  => 'money',
                    'Permissao_Func'        => Array(// Permissoes NEcessarias
                        'Financeiro_Financa' => true
                    ),
                    'Filhos'                => false,
                ),

                //Contas de Usuarios
                'Minhas Contas à Pagar'=>Array(
                    'Nome'                  => __('Minhas Contas à Pagar'),
                    'Link'                  => 'Financeiro/Usuario/Pagar',
                    'Gravidade'             => 20,
                    'Img'                   => 'money',
                    'Icon'                  => 'money',
                    'Permissao_Func'        => Array(// Permissoes NEcessarias
                        'Financeiro_User_Saldo' => true
                    ),
                    'Filhos'                => false,
                ),'Minhas Contas Pagas'=>Array(
                    'Nome'                  => __('Minhas Contas Pagas'),
                    'Link'                  => 'Financeiro/Usuario/Pago',
                    'Gravidade'             => 19,
                    'Img'                   => 'money',
                    'Icon'                  => 'money',
                    'Permissao_Func'        => Array(// Permissoes NEcessarias
                        'Financeiro_User_Saldo' => true
                    ),
                    'Filhos'                => false,
                ),'Minhas Contas à Receber'=>Array(
                    'Nome'                  => __('Minhas Contas à Receber'),
                    'Link'                  => 'Financeiro/Usuario/Receber',
                    'Gravidade'             => 18,
                    'Img'                   => 'money',
                    'Icon'                  => 'money',
                    'Permissao_Func'        => Array(// Permissoes NEcessarias
                        'Financeiro_User_Saldo' => true
                    ),
                    'Filhos'                => false,
                ),'Minhas Contas Recebidas'=>Array(
                    'Nome'                  => __('Minhas Contas Recebidas'),
                    'Link'                  => 'Financeiro/Usuario/Recebido',
                    'Gravidade'             => 17,
                    'Img'                   => 'money',
                    'Icon'                  => 'money',
                    'Permissao_Func'        => Array(// Permissoes NEcessarias
                        'Financeiro_User_Saldo' => true
                    ),
                    'Filhos'                => false,
                )
            ),
        ),
    );
};
$config_Permissoes = function () {
    return Array(
        /*Array(
            'Nome'                  => __('Visualizar Financeiro'),
            'Desc'                  => __('Financeiro De cada Usuario, Tambem se tiver em Funcional'),
            'Chave'                 => 'Financeiro_Listar',
            'End'                   => 'Financeiro/Listar', // Endereco da url de permissão
            'Modulo'                => 'Financeiro', // Modulo Referente
            'SubModulo'             => 'Listar',   // Submodulo Referente
            'Metodo'                => '*',  // Metodos referentes separados por virgula
        ),*/
        
        // Condições de Pagamento
        Array(
            'Nome'                  => __('Financeiro (Condições de Pagamento) - Listagem'),
            'Desc'                  => '',
            'Chave'                 => 'Financeiro_Pagamento_Condicoes',
            'End'                   => 'Financeiro/Pagamento/Condicoes', // Endereco da url de permissão
            'Modulo'                => 'Financeiro', // Modulo Referente
            'SubModulo'             => 'Pagamento',   // Submodulo Referente
            'Metodo'                => 'Condicoes',  // Metodos referentes separados por virgula // Endereco da url de permissão
        ),
        Array(
            'Nome'                  => __('Financeiro (Condições de Pagamento) - Add'),
            'Desc'                  => '',
            'Chave'                 => 'Financeiro_Pagamento_Condicoes_Add', // CHave unica nunca repete, chave primaria
            'End'                   => 'Financeiro/Pagamento/Condicoes_Add', // Endereco da url de permissão
            'Modulo'                => 'Financeiro', // Modulo Referente
            'SubModulo'             => 'Pagamento',   // Submodulo Referente
            'Metodo'                => 'Condicoes_Add,Condicoes_Add2',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => __('Financeiro (Condições de Pagamento) - Editar'),
            'Desc'                  => '',
            'Chave'                 => 'Financeiro_Pagamento_Condicoes_Edit', // CHave unica nunca repete, chave primaria
            'End'                   => 'Financeiro/Pagamento/Condicoes_Edit', // Endereco da url de permissão
            'Modulo'                => 'Financeiro', // Modulo Referente
            'SubModulo'             => 'Pagamento',// Submodulo Referente
            'Metodo'                => 'Condicoes_Edit,Condicoes_Edit2',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => __('Financeiro (Condições de Pagamento) - Deletar'),
            'Desc'                  => '',
            'Chave'                 => 'Financeiro_Pagamento_Condicoes_Del', // CHave unica nunca repete, chave primaria
            'End'                   => 'Financeiro/Pagamento/Condicoes_Del', // Endereco da url de permissão
            'Modulo'                => 'Financeiro', // Modulo Referente
            'SubModulo'             => 'Pagamento',   // Submodulo Referente
            'Metodo'                => 'Condicoes_Del',  // Metodos referentes separados por virgula
        ),
        
        
        // Formas de Pagamento
        Array(
            'Nome'                  => __('Financeiro (Formas de Pagamento) - Listagem'),
            'Desc'                  => '',
            'Chave'                 => 'Financeiro_Pagamento_Formas',
            'End'                   => 'Financeiro/Pagamento/Formas', // Endereco da url de permissão
            'Modulo'                => 'Financeiro', // Modulo Referente
            'SubModulo'             => 'Pagamento',   // Submodulo Referente
            'Metodo'                => 'Formas',  // Metodos referentes separados por virgula // Endereco da url de permissão
        ),
        Array(
            'Nome'                  => __('Financeiro (Formas de Pagamento) - Add'),
            'Desc'                  => '',
            'Chave'                 => 'FFinanceiro_Pagamento_Formas_Add', // CHave unica nunca repete, chave primaria
            'End'                   => 'Financeiro/Pagamento/Formas_Add', // Endereco da url de permissão
            'Modulo'                => 'Financeiro', // Modulo Referente
            'SubModulo'             => 'Pagamento',   // Submodulo Referente
            'Metodo'                => 'Formas_Add,Formas_Add2',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => __('Financeiro (Formas de Pagamento) - Editar'),
            'Desc'                  => '',
            'Chave'                 => 'Financeiro_Pagamento_Formas_Edit', // CHave unica nunca repete, chave primaria
            'End'                   => 'Financeiro/Pagamento/Formas_Edit', // Endereco da url de permissão
            'Modulo'                => 'Financeiro', // Modulo Referente
            'SubModulo'             => 'Pagamento',// Submodulo Referente
            'Metodo'                => 'Formas_Edit,Formas_Edit2',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => __('Financeiro (Formas de Pagamento) - Deletar'),
            'Desc'                  => '',
            'Chave'                 => 'Financeiro_Pagamento_Formas_Del', // CHave unica nunca repete, chave primaria
            'End'                   => 'Financeiro/Pagamento/Formas_Del', // Endereco da url de permissão
            'Modulo'                => 'Financeiro', // Modulo Referente
            'SubModulo'             => 'Pagamento',   // Submodulo Referente
            'Metodo'                => 'Formas_Del',  // Metodos referentes separados por virgula
        ),
        
        
        
        // COntas a Receber e Recebida
        Array(
            'Nome'                  => __('Financeiro (Contas a Receber) - Listagem'),
            'Desc'                  => '',
            'Chave'                 => 'Financeiro_Pagamento_Receber',
            'End'                   => 'Financeiro/Pagamento/Receber', // Endereco da url de permissão
            'Modulo'                => 'Financeiro', // Modulo Referente
            'SubModulo'             => 'Pagamento',   // Submodulo Referente
            'Metodo'                => 'Receber',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => __('Financeiro (Contas Recebidas) - Listagem'),
            'Desc'                  => '',
            'Chave'                 => 'Financeiro_Pagamento_Recebido',
            'End'                   => 'Financeiro/Pagamento/Recebido', // Endereco da url de permissão
            'Modulo'                => 'Financeiro', // Modulo Referente
            'SubModulo'             => 'Pagamento',   // Submodulo Referente
            'Metodo'                => 'Recebido',  // Metodos referentes separados por virgula
        ),
        
        // Contas a Pagar e Pagas
        Array(
            'Nome'                  => __('Financeiro (Contas a Pagar) - Listagem'),
            'Desc'                  => '',
            'Chave'                 => 'Financeiro_Pagamento_Pagar',
            'End'                   => 'Financeiro/Pagamento/Pagar', // Endereco da url de permissão
            'Modulo'                => 'Financeiro', // Modulo Referente
            'SubModulo'             => 'Pagamento',   // Submodulo Referente
            'Metodo'                => 'Pagar',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => __('Financeiro (Contas Pagas) - Listagem'),
            'Desc'                  => '',
            'Chave'                 => 'Financeiro_Pagamento_Pago',
            'End'                   => 'Financeiro/Pagamento/Pago', // Endereco da url de permissão
            'Modulo'                => 'Financeiro', // Modulo Referente
            'SubModulo'             => 'Pagamento',   // Submodulo Referente
            'Metodo'                => 'Pago',  // Metodos referentes separados por virgula
        ),
        
        // Pagar Receber
        Array(
            'Nome'                  => __('Financeiro (Contas a Receber/a Pagar) - Declarar Pago'),
            'Desc'                  => '',
            'Chave'                 => 'Financeiro_Pagamento_Financeiros_Pagar',
            'End'                   => 'Financeiro/Pagamento/Financeiros_Pagar', // Endereco da url de permissão
            'Modulo'                => 'Financeiro', // Modulo Referente
            'SubModulo'             => 'Pagamento',   // Submodulo Referente
            'Metodo'                => 'Financeiros_Pagar',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => __('Financeiro (Contas a Receber/a Pagar) - Alterar Vencimento'),
            'Desc'                  => '',
            'Chave'                 => 'Financeiro_Pagamento_Financeiros_VencimentoEdit',
            'End'                   => 'Financeiro/Pagamento/Financeiros_VencimentoEdit', // Endereco da url de permissão
            'Modulo'                => 'Financeiro', // Modulo Referente
            'SubModulo'             => 'Pagamento',   // Submodulo Referente
            'Metodo'                => 'Financeiros_VencimentoEdit',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => __('Financeiro (Contas Recebidas/Pagas) - Desfazer Pagamento'),
            'Desc'                  => '',
            'Chave'                 => 'Financeiro_Pagamento_Financeiros_NaoPagar',
            'End'                   => 'Financeiro/Pagamento/Financeiros_NaoPagar', // Endereco da url de permissão
            'Modulo'                => 'Financeiro', // Modulo Referente
            'SubModulo'             => 'Pagamento',   // Submodulo Referente
            'Metodo'                => 'Financeiros_NaoPagar',  // Metodos referentes separados por virgula
        ),
        
        // Relatorios
        Array(
            'Nome'                  => __('Financeiro (Relatório) -  Visualizar'),
            'Desc'                  => '',
            'Chave'                 => 'Financeiro_Relatorio_Relatorio',
            'End'                   => 'Financeiro/Relatorio/Relatorio', // Endereco da url de permissão
            'Modulo'                => 'Financeiro', // Modulo Referente
            'SubModulo'             => 'Relatorio',   // Submodulo Referente
            'Metodo'                => 'Relatorio',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => __('Financeiro (Gráfico) -  Visualizar'),
            'Desc'                  => '',
            'Chave'                 => 'Financeiro_Relatorio_Grafico_Relatorio',
            'End'                   => 'Financeiro/Relatorio/Grafico_Relatorio', // Endereco da url de permissão
            'Modulo'                => 'Financeiro', // Modulo Referente
            'SubModulo'             => 'Relatorio',   // Submodulo Referente
            'Metodo'                => 'Grafico_Relatorio',  // Metodos referentes separados por virgula
        ),
        
        // Financas
        Array(
            'Nome'                  => __('Financeiro (Finanças) -  Listagem'),
            'Desc'                  => '',
            'Chave'                 => 'Financeiro_Financa_Financas',
            'End'                   => 'Financeiro/Financa/Financas', // Endereco da url de permissão
            'Modulo'                => 'Financeiro', // Modulo Referente
            'SubModulo'             => 'Financa',   // Submodulo Referente
            'Metodo'                => 'Financas',  // Metodos referentes separados por virgula
            'Permissao_Func'        => Array(// Permissoes NEcessarias
                'Financeiro_Financa' => true
            ),
        ),
        Array(
            'Nome'                  => __('Financeiro (Finanças) - Add'),
            'Desc'                  => '',
            'Chave'                 => 'Financeiro_Financa_Financas_Add', // CHave unica nunca repete, chave primaria
            'End'                   => 'Financeiro/Financa/Financas_Add', // Endereco da url de permissão
            'Modulo'                => 'Financeiro', // Modulo Referente
            'SubModulo'             => 'Financa',   // Submodulo Referente
            'Metodo'                => 'Financas_Add,Financas_Add2',  // Metodos referentes separados por virgula
            'Permissao_Func'        => Array(// Permissoes NEcessarias
                'Financeiro_Financa' => true
            ),
        ),
        Array(
            'Nome'                  => __('Financeiro (Finanças) - Editar'),
            'Desc'                  => '',
            'Chave'                 => 'Financeiro_Financa_Financas_Edit', // CHave unica nunca repete, chave primaria
            'End'                   => 'Financeiro/Financa/Financas_Edit', // Endereco da url de permissão
            'Modulo'                => 'Financeiro', // Modulo Referente
            'SubModulo'             => 'Financa',// Submodulo Referente
            'Metodo'                => 'Financas_Edit,Financas_Edit2',  // Metodos referentes separados por virgula
            'Permissao_Func'        => Array(// Permissoes NEcessarias
                'Financeiro_Financa' => true
            ),
        ),
        Array(
            'Nome'                  => __('Financeiro (Finanças) - Deletar'),
            'Desc'                  => '',
            'Chave'                 => 'Financeiro_Financa_Financas_Del', // CHave unica nunca repete, chave primaria
            'End'                   => 'Financeiro/Financa/Financas_Del', // Endereco da url de permissão
            'Modulo'                => 'Financeiro', // Modulo Referente
            'SubModulo'             => 'Financa',   // Submodulo Referente
            'Metodo'                => 'Financas_Del',  // Metodos referentes separados por virgula
            'Permissao_Func'        => Array(// Permissoes NEcessarias
                'Financeiro_Financa' => true
            ),
        ),
        
        
        
        // Pagamento de Usuario
        Array(
            'Nome'                  => __('Financeiro de Usuários (Contas a Receber) - Listagem'),
            'Desc'                  => '',
            'Chave'                 => 'Financeiro_Usuario_Receber',
            'End'                   => 'Financeiro/Usuario/Receber', // Endereco da url de permissão
            'Modulo'                => 'Financeiro', // Modulo Referente
            'SubModulo'             => 'Usuario',   // Submodulo Referente
            'Metodo'                => 'Receber',  // Metodos referentes separados por virgula
            'Permissao_Func'        => Array(// Permissoes NEcessarias
                'Financeiro_User_Saldo' => true
            ),
        ),
        Array(
            'Nome'                  => __('Financeiro de Usuários (Contas Recebidas) - Listagem'),
            'Desc'                  => '',
            'Chave'                 => 'Financeiro_Usuario_Recebido',
            'End'                   => 'Financeiro/Usuario/Recebido', // Endereco da url de permissão
            'Modulo'                => 'Financeiro', // Modulo Referente
            'SubModulo'             => 'Usuario',   // Submodulo Referente
            'Metodo'                => 'Recebido',  // Metodos referentes separados por virgula
            'Permissao_Func'        => Array(// Permissoes NEcessarias
                'Financeiro_User_Saldo' => true
            ),
        ),
        Array(
            'Nome'                  => __('Financeiro de Usuários (Contas a Pagar) - Listagem'),
            'Desc'                  => '',
            'Chave'                 => 'Financeiro_Usuario_Pagar',
            'End'                   => 'Financeiro/Usuario/Pagar', // Endereco da url de permissão
            'Modulo'                => 'Financeiro', // Modulo Referente
            'SubModulo'             => 'Usuario',   // Submodulo Referente
            'Metodo'                => 'Pagar',  // Metodos referentes separados por virgula
            'Permissao_Func'        => Array(// Permissoes NEcessarias
                'Financeiro_User_Saldo' => true
            ),
        ),
        Array(
            'Nome'                  => __('Financeiro de Usuários (Contas Pagas) - Listagem'),
            'Desc'                  => '',
            'Chave'                 => 'Financeiro_Usuario_Pago',
            'End'                   => 'Financeiro/Usuario/Pago', // Endereco da url de permissão
            'Modulo'                => 'Financeiro', // Modulo Referente
            'SubModulo'             => 'Usuario',   // Submodulo Referente
            'Metodo'                => 'Pago',  // Metodos referentes separados por virgula
            'Permissao_Func'        => Array(// Permissoes NEcessarias
                'Financeiro_User_Saldo' => true
            ),
        ),
        
        // Pagar Receber
        Array(
            'Nome'                  => __('Financeiro de Usuários (Contas a Receber/a Pagar) - Declarar Pago/Pagar'),
            'Desc'                  => '',
            'Chave'                 => 'Financeiro_Usuario_Financeiros_Pagar',
            'End'                   => 'Financeiro/Usuario/Financeiros_Pagar', // Endereco da url de permissão
            'Modulo'                => 'Financeiro', // Modulo Referente
            'SubModulo'             => 'Usuario',   // Submodulo Referente
            'Metodo'                => 'Financeiros_Pagar',  // Metodos referentes separados por virgula
            'Permissao_Func'        => Array(// Permissoes NEcessarias
                'Financeiro_User_Saldo' => true
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
$configFunctional = function () {
    return Array(
        'Financeiro_Financa'  => Array(
            'Nome'                  => 'Usuarios -> Financas',
            'Desc'                  => __('Se tem Cadastro de Financas'),
            'chave'                 => 'Financeiro_Financa',
            'Valor'                 => false,
        ),
        'Financeiro_User_Saldo'  => Array(
            'Nome'                  => 'Usuarios -> Saldo',
            'Desc'                  => __('Se usuarios terão saldo próprio dentro do sistema'),
            'chave'                 => 'Financeiro_User_Saldo',
            'Valor'                 => false,
        ),
        'Financeiro_User_Planos'  => Array(
            'Nome'                  => 'Usuarios -> Planos',
            'Desc'                  => __('Se usuarios terão acesso a diferentes planos dentro do sistema'),
            'chave'                 => 'Financeiro_User_Planos',
            'Valor'                 => false,
        )
    );
};
/**
 * Configurações que podem ser Alteradas por Admin ou outros usuarios do Sistema (Parametros Opcionais: Mascara e Max
 * @return type
 * 
 * @author Ricardo Sierra <web@ricardosierra.com.br>
 */
$configPublic = function () {
    return Array(
        /*'{chave}'  => Array(
            'Nome'                  => 'Nome',
            'Desc'                  => __('Descricao'),
            'Chave'                 => '{chave}',
            'Valor'                 => 'valor_padrao'
        )*/
    );
};

