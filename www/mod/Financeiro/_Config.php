<?php
$config_Modulo = function (){
    return Array(
        'Nome'                      =>  'Financeiro',
        'Descrição'                 =>  'Permite o controle de um banco '.
                                        'interno do sistema capaz de trocar dinheiro entre os usuarios e uma '.
                                        'Administração que permite inserir dinheiro aos usuarios, assim como uma opção de saque.',
        'System_Require'            =>  '3.0.0',
        'Version'                   =>  '3.0.1',
        'Dependencias'              =>  false,
    );
};
$config_Menu = function (){
    return Array(
        'Relatório' => Array(
            'Filhos'                => Array('Financeiro'=>Array(
                'Nome'                  => 'Financeiro',
                'Link'                  => 'Financeiro/Relatorio/Relatorio',
                'Gravidade'             => 3,
                'Img'                   => 'money',
                'Icon'                  => 'money',
                'Filhos'                => false,
            ),),
        ),
        'Gráfico' => Array(
            'Filhos'                => Array('Gráfico'=>Array(
                'Nome'                  => 'Financeiro',
                'Link'                  => 'Financeiro/Relatorio/Grafico_Relatorio',
                'Gravidade'             => 2,
                'Img'                   => 'money',
                'Icon'                  => 'money',
                'Filhos'                => false,
            ),),
        ),
        'Financeiro' => Array(
            'Nome'                  => 'Financeiro',
            'Link'                  => '#',
            'Gravidade'             => 20,
            'Img'                   => 'money',
            'Icon'                  => 'money',
            'Filhos'                => Array('Formas de Pagamento'=>Array(
                'Nome'                  => 'Formas de Pagamento',
                'Link'                  => 'Financeiro/Pagamento/Formas',
                'Gravidade'             => 2,
                'Img'                   => 'money',
                'Icon'                  => 'money',
                'Filhos'                => false,
            ),'Condições de Pagamento'=>Array(
                'Nome'                  => 'Condições de Pagamento',
                'Link'                  => 'Financeiro/Pagamento/Condicoes',
                'Gravidade'             => 1,
                'Img'                   => 'money',
                'Icon'                  => 'money',
                'Filhos'                => false,
            ),'Contas à Pagar'=>Array(
                'Nome'                  => 'Contas à Pagar',
                'Link'                  => 'Financeiro/Pagamento/Pagar',
                'Gravidade'             => 10,
                'Img'                   => 'money',
                'Icon'                  => 'money',
                'Filhos'                => false,
            ),'Contas Pagas'=>Array(
                'Nome'                  => 'Contas Pagas',
                'Link'                  => 'Financeiro/Pagamento/Pago',
                'Gravidade'             => 9,
                'Img'                   => 'money',
                'Icon'                  => 'money',
                'Filhos'                => false,
            ),'Contas à Receber'=>Array(
                'Nome'                  => 'Contas à Receber',
                'Link'                  => 'Financeiro/Pagamento/Receber',
                'Gravidade'             => 8,
                'Img'                   => 'money',
                'Icon'                  => 'money',
                'Filhos'                => false,
            ),'Contas Recebidas'=>Array(
                'Nome'                  => 'Contas Recebidas',
                'Link'                  => 'Financeiro/Pagamento/Recebido',
                'Gravidade'             => 7,
                'Img'                   => 'money',
                'Icon'                  => 'money',
                'Filhos'                => false,
            ),'Finanças'=>Array(
                'Nome'                  => 'Finanças',
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
                'Nome'                  => 'Minhas Contas à Pagar',
                'Link'                  => 'Financeiro/Usuario/Pagar',
                'Gravidade'             => 20,
                'Img'                   => 'money',
                'Icon'                  => 'money',
                'Permissao_Func'        => Array(// Permissoes NEcessarias
                    'Financeiro_User_Saldo' => true
                ),
                'Filhos'                => false,
            ),'Minhas Contas Pagas'=>Array(
                'Nome'                  => 'Minhas Contas Pagas',
                'Link'                  => 'Financeiro/Usuario/Pago',
                'Gravidade'             => 19,
                'Img'                   => 'money',
                'Icon'                  => 'money',
                'Permissao_Func'        => Array(// Permissoes NEcessarias
                    'Financeiro_User_Saldo' => true
                ),
                'Filhos'                => false,
            ),'Minhas Contas à Receber'=>Array(
                'Nome'                  => 'Minhas Contas à Receber',
                'Link'                  => 'Financeiro/Usuario/Receber',
                'Gravidade'             => 18,
                'Img'                   => 'money',
                'Icon'                  => 'money',
                'Permissao_Func'        => Array(// Permissoes NEcessarias
                    'Financeiro_User_Saldo' => true
                ),
                'Filhos'                => false,
            ),'Minhas Contas Recebidas'=>Array(
                'Nome'                  => 'Minhas Contas Recebidas',
                'Link'                  => 'Financeiro/Usuario/Recebido',
                'Gravidade'             => 17,
                'Img'                   => 'money',
                'Icon'                  => 'money',
                'Permissao_Func'        => Array(// Permissoes NEcessarias
                    'Financeiro_User_Saldo' => true
                ),
                'Filhos'                => false,
            )),
        ),
    );
};
$config_Permissoes = function (){
    return Array(
        /*Array(
            'Nome'                  => 'Visualizar Financeiro',
            'Desc'                  => 'Financeiro De cada Usuario, Tambem se tiver em Funcional',
            'Chave'                 => 'Financeiro_Listar',
            'End'                   => 'Financeiro/Listar', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Financeiro', // Modulo Referente
            'SubModulo'             => 'Listar',   // Submodulo Referente
            'Metodo'                => '*',  // Metodos referentes separados por virgula
        ),*/
        
        // Condições de Pagamento
        Array(
            'Nome'                  => 'Financeiro (Condições de Pagamento) - Listagem',
            'Desc'                  => '',
            'Chave'                 => 'Financeiro_Pagamento_Condicoes',
            'End'                   => 'Financeiro/Pagamento/Condicoes', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Financeiro', // Modulo Referente
            'SubModulo'             => 'Pagamento',   // Submodulo Referente
            'Metodo'                => 'Condicoes',  // Metodos referentes separados por virgula // Endereco que deve conter a url para permitir acesso
        ),
        Array(
            'Nome'                  => 'Financeiro (Condições de Pagamento) - Add',
            'Desc'                  => '',
            'Chave'                 => 'Financeiro_Pagamento_Condicoes_Add', // CHave unica nunca repete, chave primaria
            'End'                   => 'Financeiro/Pagamento/Condicoes_Add', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Financeiro', // Modulo Referente
            'SubModulo'             => 'Pagamento',   // Submodulo Referente
            'Metodo'                => 'Condicoes_Add,Condicoes_Add2',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => 'Financeiro (Condições de Pagamento) - Editar',
            'Desc'                  => '',
            'Chave'                 => 'Financeiro_Pagamento_Condicoes_Edit', // CHave unica nunca repete, chave primaria
            'End'                   => 'Financeiro/Pagamento/Condicoes_Edit', // Endereco que deve conter a url para permitir acesso // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Financeiro', // Modulo Referente // Modulo Referente
            'SubModulo'             => 'Pagamento',   // Submodulo Referente   // Submodulo Referente
            'Metodo'                => 'Condicoes_Edit,Condicoes_Edit2',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => 'Financeiro (Condições de Pagamento) - Deletar',
            'Desc'                  => '',
            'Chave'                 => 'Financeiro_Pagamento_Condicoes_Del', // CHave unica nunca repete, chave primaria
            'End'                   => 'Financeiro/Pagamento/Condicoes_Del', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Financeiro', // Modulo Referente
            'SubModulo'             => 'Pagamento',   // Submodulo Referente
            'Metodo'                => 'Condicoes_Del',  // Metodos referentes separados por virgula
        ),
        
        
        // Formas de Pagamento
        Array(
            'Nome'                  => 'Financeiro (Formas de Pagamento) - Listagem',
            'Desc'                  => '',
            'Chave'                 => 'Financeiro_Pagamento_Formas',
            'End'                   => 'Financeiro/Pagamento/Formas', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Financeiro', // Modulo Referente
            'SubModulo'             => 'Pagamento',   // Submodulo Referente
            'Metodo'                => 'Formas',  // Metodos referentes separados por virgula // Endereco que deve conter a url para permitir acesso
        ),
        Array(
            'Nome'                  => 'Financeiro (Formas de Pagamento) - Add',
            'Desc'                  => '',
            'Chave'                 => 'FFinanceiro_Pagamento_Formas_Add', // CHave unica nunca repete, chave primaria
            'End'                   => 'Financeiro/Pagamento/Formas_Add', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Financeiro', // Modulo Referente
            'SubModulo'             => 'Pagamento',   // Submodulo Referente
            'Metodo'                => 'Formas_Add,Formas_Add2',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => 'Financeiro (Formas de Pagamento) - Editar',
            'Desc'                  => '',
            'Chave'                 => 'Financeiro_Pagamento_Formas_Edit', // CHave unica nunca repete, chave primaria
            'End'                   => 'Financeiro/Pagamento/Formas_Edit', // Endereco que deve conter a url para permitir acesso // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Financeiro', // Modulo Referente // Modulo Referente
            'SubModulo'             => 'Pagamento',   // Submodulo Referente   // Submodulo Referente
            'Metodo'                => 'Formas_Edit,Formas_Edit2',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => 'Financeiro (Formas de Pagamento) - Deletar',
            'Desc'                  => '',
            'Chave'                 => 'Financeiro_Pagamento_Formas_Del', // CHave unica nunca repete, chave primaria
            'End'                   => 'Financeiro/Pagamento/Formas_Del', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Financeiro', // Modulo Referente
            'SubModulo'             => 'Pagamento',   // Submodulo Referente
            'Metodo'                => 'Formas_Del',  // Metodos referentes separados por virgula
        ),
        
        
        
        // COntas a Receber e Recebida
        Array(
            'Nome'                  => 'Financeiro (Contas a Receber) - Listagem',
            'Desc'                  => '',
            'Chave'                 => 'Financeiro_Pagamento_Receber',
            'End'                   => 'Financeiro/Pagamento/Receber', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Financeiro', // Modulo Referente
            'SubModulo'             => 'Pagamento',   // Submodulo Referente
            'Metodo'                => 'Receber',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => 'Financeiro (Contas Recebidas) - Listagem',
            'Desc'                  => '',
            'Chave'                 => 'Financeiro_Pagamento_Recebido',
            'End'                   => 'Financeiro/Pagamento/Recebido', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Financeiro', // Modulo Referente
            'SubModulo'             => 'Pagamento',   // Submodulo Referente
            'Metodo'                => 'Recebido',  // Metodos referentes separados por virgula
        ),
        
        // Contas a Pagar e Pagas
        Array(
            'Nome'                  => 'Financeiro (Contas a Pagar) - Listagem',
            'Desc'                  => '',
            'Chave'                 => 'Financeiro_Pagamento_Pagar',
            'End'                   => 'Financeiro/Pagamento/Pagar', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Financeiro', // Modulo Referente
            'SubModulo'             => 'Pagamento',   // Submodulo Referente
            'Metodo'                => 'Pagar',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => 'Financeiro (Contas Pagas) - Listagem',
            'Desc'                  => '',
            'Chave'                 => 'Financeiro_Pagamento_Pago',
            'End'                   => 'Financeiro/Pagamento/Pago', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Financeiro', // Modulo Referente
            'SubModulo'             => 'Pagamento',   // Submodulo Referente
            'Metodo'                => 'Pago',  // Metodos referentes separados por virgula
        ),
        
        // Pagar Receber
        Array(
            'Nome'                  => 'Financeiro (Contas a Receber/a Pagar) - Declarar Pago',
            'Desc'                  => '',
            'Chave'                 => 'Financeiro_Pagamento_Financeiros_Pagar',
            'End'                   => 'Financeiro/Pagamento/Financeiros_Pagar', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Financeiro', // Modulo Referente
            'SubModulo'             => 'Pagamento',   // Submodulo Referente
            'Metodo'                => 'Financeiros_Pagar',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => 'Financeiro (Contas a Receber/a Pagar) - Alterar Vencimento',
            'Desc'                  => '',
            'Chave'                 => 'Financeiro_Pagamento_Financeiros_VencimentoEdit',
            'End'                   => 'Financeiro/Pagamento/Financeiros_VencimentoEdit', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Financeiro', // Modulo Referente
            'SubModulo'             => 'Pagamento',   // Submodulo Referente
            'Metodo'                => 'Financeiros_VencimentoEdit',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => 'Financeiro (Contas Recebidas/Pagas) - Desfazer Pagamento',
            'Desc'                  => '',
            'Chave'                 => 'Financeiro_Pagamento_Financeiros_NaoPagar',
            'End'                   => 'Financeiro/Pagamento/Financeiros_NaoPagar', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Financeiro', // Modulo Referente
            'SubModulo'             => 'Pagamento',   // Submodulo Referente
            'Metodo'                => 'Financeiros_NaoPagar',  // Metodos referentes separados por virgula
        ),
        
        // Relatorios
        Array(
            'Nome'                  => 'Financeiro (Relatório) -  Visualizar',
            'Desc'                  => '',
            'Chave'                 => 'Financeiro_Relatorio_Relatorio',
            'End'                   => 'Financeiro/Relatorio/Relatorio', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Financeiro', // Modulo Referente
            'SubModulo'             => 'Relatorio',   // Submodulo Referente
            'Metodo'                => 'Relatorio',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => 'Financeiro (Gráfico) -  Visualizar',
            'Desc'                  => '',
            'Chave'                 => 'Financeiro_Relatorio_Grafico_Relatorio',
            'End'                   => 'Financeiro/Relatorio/Grafico_Relatorio', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Financeiro', // Modulo Referente
            'SubModulo'             => 'Relatorio',   // Submodulo Referente
            'Metodo'                => 'Grafico_Relatorio',  // Metodos referentes separados por virgula
        ),
        
        // Financas
        Array(
            'Nome'                  => 'Financeiro (Finanças) -  Listagem',
            'Desc'                  => '',
            'Chave'                 => 'Financeiro_Financa_Financas',
            'End'                   => 'Financeiro/Financa/Financas', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Financeiro', // Modulo Referente
            'SubModulo'             => 'Financa',   // Submodulo Referente
            'Metodo'                => 'Financas',  // Metodos referentes separados por virgula
            'Permissao_Func'        => Array(// Permissoes NEcessarias
                'Financeiro_Financa' => true
            ),
        ),
        Array(
            'Nome'                  => 'Financeiro (Finanças) - Add',
            'Desc'                  => '',
            'Chave'                 => 'Financeiro_Financa_Financas_Add', // CHave unica nunca repete, chave primaria
            'End'                   => 'Financeiro/Financa/Financas_Add', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Financeiro', // Modulo Referente
            'SubModulo'             => 'Financa',   // Submodulo Referente
            'Metodo'                => 'Financas_Add,Financas_Add2',  // Metodos referentes separados por virgula
            'Permissao_Func'        => Array(// Permissoes NEcessarias
                'Financeiro_Financa' => true
            ),
        ),
        Array(
            'Nome'                  => 'Financeiro (Finanças) - Editar',
            'Desc'                  => '',
            'Chave'                 => 'Financeiro_Financa_Financas_Edit', // CHave unica nunca repete, chave primaria
            'End'                   => 'Financeiro/Financa/Financas_Edit', // Endereco que deve conter a url para permitir acesso // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Financeiro', // Modulo Referente // Modulo Referente
            'SubModulo'             => 'Financa',   // Submodulo Referente   // Submodulo Referente
            'Metodo'                => 'Financas_Edit,Financas_Edit2',  // Metodos referentes separados por virgula
            'Permissao_Func'        => Array(// Permissoes NEcessarias
                'Financeiro_Financa' => true
            ),
        ),
        Array(
            'Nome'                  => 'Financeiro (Finanças) - Deletar',
            'Desc'                  => '',
            'Chave'                 => 'Financeiro_Financa_Financas_Del', // CHave unica nunca repete, chave primaria
            'End'                   => 'Financeiro/Financa/Financas_Del', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Financeiro', // Modulo Referente
            'SubModulo'             => 'Financa',   // Submodulo Referente
            'Metodo'                => 'Financas_Del',  // Metodos referentes separados por virgula
            'Permissao_Func'        => Array(// Permissoes NEcessarias
                'Financeiro_Financa' => true
            ),
        ),
        
        
        
        // Pagamento de Usuario
        Array(
            'Nome'                  => 'Financeiro de Usuários (Contas a Receber) - Listagem',
            'Desc'                  => '',
            'Chave'                 => 'Financeiro_Usuario_Receber',
            'End'                   => 'Financeiro/Usuario/Receber', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Financeiro', // Modulo Referente
            'SubModulo'             => 'Usuario',   // Submodulo Referente
            'Metodo'                => 'Receber',  // Metodos referentes separados por virgula
            'Permissao_Func'        => Array(// Permissoes NEcessarias
                'Financeiro_User_Saldo' => true
            ),
        ),
        Array(
            'Nome'                  => 'Financeiro de Usuários (Contas Recebidas) - Listagem',
            'Desc'                  => '',
            'Chave'                 => 'Financeiro_Usuario_Recebido',
            'End'                   => 'Financeiro/Usuario/Recebido', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Financeiro', // Modulo Referente
            'SubModulo'             => 'Usuario',   // Submodulo Referente
            'Metodo'                => 'Recebido',  // Metodos referentes separados por virgula
            'Permissao_Func'        => Array(// Permissoes NEcessarias
                'Financeiro_User_Saldo' => true
            ),
        ),
        Array(
            'Nome'                  => 'Financeiro de Usuários (Contas a Pagar) - Listagem',
            'Desc'                  => '',
            'Chave'                 => 'Financeiro_Usuario_Pagar',
            'End'                   => 'Financeiro/Usuario/Pagar', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Financeiro', // Modulo Referente
            'SubModulo'             => 'Usuario',   // Submodulo Referente
            'Metodo'                => 'Pagar',  // Metodos referentes separados por virgula
            'Permissao_Func'        => Array(// Permissoes NEcessarias
                'Financeiro_User_Saldo' => true
            ),
        ),
        Array(
            'Nome'                  => 'Financeiro de Usuários (Contas Pagas) - Listagem',
            'Desc'                  => '',
            'Chave'                 => 'Financeiro_Usuario_Pago',
            'End'                   => 'Financeiro/Usuario/Pago', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Financeiro', // Modulo Referente
            'SubModulo'             => 'Usuario',   // Submodulo Referente
            'Metodo'                => 'Pago',  // Metodos referentes separados por virgula
            'Permissao_Func'        => Array(// Permissoes NEcessarias
                'Financeiro_User_Saldo' => true
            ),
        ),
        
        // Pagar Receber
        Array(
            'Nome'                  => 'Financeiro de Usuários (Contas a Receber/a Pagar) - Declarar Pago/Pagar',
            'Desc'                  => '',
            'Chave'                 => 'Financeiro_Usuario_Financeiros_Pagar',
            'End'                   => 'Financeiro/Usuario/Financeiros_Pagar', // Endereco que deve conter a url para permitir acesso
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
$config_Funcional = function (){
    return Array(
        'Financeiro_Financa'  => Array(
            'Nome'                  => 'Usuarios -> Financas',
            'Desc'                  => 'Se tem Cadastro de Financas',
            'chave'                 => 'Financeiro_Financa',
            'Valor'                 => false,
        ),
        'Financeiro_User_Saldo'  => Array(
            'Nome'                  => 'Usuarios -> Saldo',
            'Desc'                  => 'Se usuarios terão saldo próprio dentro do sistema',
            'chave'                 => 'Financeiro_User_Saldo',
            'Valor'                 => false,
        ),
        'Financeiro_User_Planos'  => Array(
            'Nome'                  => 'Usuarios -> Planos',
            'Desc'                  => 'Se usuarios terão acesso a diferentes planos dentro do sistema',
            'chave'                 => 'Financeiro_User_Planos',
            'Valor'                 => false,
        )
    );
};
?>
