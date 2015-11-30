<?php
$configModule = function () {
    return Array(
        'Nome'                      =>  'comercio_venda',
        'Descrição'                 =>  '',
        'System_Require'            =>  '3.1.0',
        'Version'                   =>  '0.2.1',
        'Dependencias'              =>  false,
    );
};
$configMenu = function () {
    return Array(
        'Vendas' => Array(
            'Nome'                  => __('Vendas'),
            'Link'                  => '#',
            'Gravidade'             => 200,
            'Img'                   => 'turboadmin/m-dashboard.png',
            'Icon'                  => 'barcode',
            'Filhos'                => Array(__('Mesas')=>Array(
                'Nome'                  => __('Mesas'),
                'Link'                  => 'comercio_venda/Carrinho/Mesas',
                'Gravidade'             => 10,
                'Img'                   => 'turboadmin/m-dashboard.png',
                'Icon'                  => 'truck',
                'Permissao_Func'        => Array(// Permissoes NEcessarias
                    'comercio_venda_mesa' => true
                ),
                'Filhos'                => false,
            ),'Caixa'=>Array(
                'Nome'                  => __('Caixa'),
                'Link'                  => 'comercio_venda/Carrinho/Carrinhos',
                'Gravidade'             => 8,
                'Img'                   => 'turboadmin/m-dashboard.png',
                'Icon'                  => 'shopping-cart',
                'Filhos'                => false,
            ),'Cardápio'=>Array(
                'Nome'                  => __('Cardápio'),
                'Link'                  => 'comercio_venda/Composicao/Composicoes',
                'Gravidade'             => 6,
                'Img'                   => 'turboadmin/m-dashboard.png',
                'Icon'                  => 'leaf',
                'Filhos'                => false,
            ),),
        ),
        /*'Relatório'=>Array(
            'Filhos'                => Array(__('Processos')=>Array(
                'Nome'                  => __('Processos'),
                'Link'                  => 'comercio_venda/Relatorio/Main',
                'Gravidade'             => 70,
                'Img'                   => 'menusuperior/varas.png',
                'Icon'                  => '',
                'Filhos'                => false,
            ),),
        ),*/
    );
};
$config_Permissoes = function () {
    return Array(
        // MESAS
        Array(
            'Nome'                  => __('Comercio Vendas (Mesas) - Listagem'),
            'Desc'                  => '',
            'Chave'                 => 'comercio_venda_Carrinho_Mesas',
            'End'                   => 'comercio_venda/Carrinho/Mesas',
            'Modulo'                => 'comercio_venda', // Modulo Referente
            'SubModulo'             => 'Carrinho',   // Submodulo Referente
            'Metodo'                => 'Mesas',  // Metodos referentes separados por virgula // Endereco da url de permissão
            'Permissao_Func'        => Array(// Permissoes NEcessarias
                'comercio_venda_mesa' => true
            )
        ),
        Array(
            'Nome'                  => __('Comercio Vendas (Mesas) - Adicionar'),
            'Desc'                  => '',
            'Chave'                 => 'comercio_venda_Carrinho_Mesas_Add',
            'End'                   => 'comercio_venda/Carrinho/Mesas_Add',
            'Modulo'                => 'comercio_venda', // Modulo Referente
            'SubModulo'             => 'Carrinho',   // Submodulo Referente
            'Metodo'                => 'Mesas_Add,Mesas_Add2',  // Metodos referentes separados por virgula // Endereco da url de permissão
            'Permissao_Func'        => Array(// Permissoes NEcessarias
                'comercio_venda_mesa' => true
            )
        ),
        Array(
            'Nome'                  => __('Comercio Vendas (Mesas) - Editar'),
            'Desc'                  => '',
            'Chave'                 => 'comercio_venda_Carrinho_Mesas_Edit',
            'End'                   => 'comercio_venda/Carrinho/Mesas_Edit',
            'Modulo'                => 'comercio_venda', // Modulo Referente
            'SubModulo'             => 'Carrinho',   // Submodulo Referente
            'Metodo'                => 'Mesas_Edit,Mesas_Edit2',  // Metodos referentes separados por virgula // Endereco da url de permissão
            'Permissao_Func'        => Array(// Permissoes NEcessarias
                'comercio_venda_mesa' => true
            )
        ),
        Array(
            'Nome'                  => __('Comercio Vendas (Mesas) - Deletar'),
            'Desc'                  => '',
            'Chave'                 => 'comercio_venda_Carrinho_Mesas_Del',
            'End'                   => 'comercio_venda/Carrinho/Mesas_Del',
            'Modulo'                => 'comercio_venda', // Modulo Referente
            'SubModulo'             => 'Carrinho',   // Submodulo Referente
            'Metodo'                => 'Mesas_Del',  // Metodos referentes separados por virgula // Endereco da url de permissão
            'Permissao_Func'        => Array(// Permissoes NEcessarias
                'comercio_venda_mesa' => true
            )
        ),
        
        
        // CARRINHOS
        Array(
            'Nome'                  => __('Comercio Vendas (Caixa) - Listagem'),
            'Desc'                  => '',
            'Chave'                 => 'comercio_venda_Carrinho_Carrinhos',
            'End'                   => 'comercio_venda/Carrinho/Carrinhos',
            'Modulo'                => 'comercio_venda', // Modulo Referente
            'SubModulo'             => 'Carrinho',   // Submodulo Referente
            'Metodo'                => 'Carrinhos',  // Metodos referentes separados por virgula // Endereco da url de permissão
        ),
        Array(
            'Nome'                  => __('Comercio Vendas (Caixa) - Adicionar'),
            'Desc'                  => '',
            'Chave'                 => 'comercio_venda_Carrinho_Carrinhos_Add',
            'End'                   => 'comercio_venda/Carrinho/Carrinhos_Add',
            'Modulo'                => 'comercio_venda', // Modulo Referente
            'SubModulo'             => 'Carrinho',   // Submodulo Referente
            'Metodo'                => 'Carrinhos_Add,Carrinhos_Add2',  // Metodos referentes separados por virgula // Endereco da url de permissão
        ),
        Array(
            'Nome'                  => __('Comercio Vendas (Caixa) - Editar'),
            'Desc'                  => '',
            'Chave'                 => 'comercio_venda_Carrinho_Carrinhos_Edit',
            'End'                   => 'comercio_venda/Carrinho/Carrinhos_Edit',
            'Modulo'                => 'comercio_venda', // Modulo Referente
            'SubModulo'             => 'Carrinho',   // Submodulo Referente
            'Metodo'                => 'Carrinhos_Edit,Carrinhos_Edit2',  // Metodos referentes separados por virgula // Endereco da url de permissão
        ),
        Array(
            'Nome'                  => __('Comercio Vendas (Caixa) - Deletar'),
            'Desc'                  => '',
            'Chave'                 => 'comercio_venda_Carrinho_Carrinhos_Del',
            'End'                   => 'comercio_venda/Carrinho/Carrinhos_Del',
            'Modulo'                => 'comercio_venda', // Modulo Referente
            'SubModulo'             => 'Carrinho',   // Submodulo Referente
            'Metodo'                => 'Carrinhos_Del',  // Metodos referentes separados por virgula // Endereco da url de permissão
        ),
        Array(
            'Nome'                  => __('Comercio Vendas (Caixa) - Pagamento Rapido'),
            'Desc'                  => '',
            'Chave'                 => 'comercio_venda_Carrinho_StatusCarrinhos',
            'End'                   => 'comercio_venda/Carrinho/StatusCarrinhos',
            'Modulo'                => 'comercio_venda', // Modulo Referente
            'SubModulo'             => 'Carrinho',   // Submodulo Referente
            'Metodo'                => 'StatusCarrinhos',  // Metodos referentes separados por virgula // Endereco da url de permissão
        ),
        
        
        // Cardápio
        Array(
            'Nome'                  => __('Comercio Vendas (Cardápio) - Listagem'),
            'Desc'                  => '',
            'Chave'                 => 'comercio_venda_Composicao_Composicoes',
            'End'                   => 'comercio_venda/Composicao/Composicoes',
            'Modulo'                => 'comercio_venda', // Modulo Referente
            'SubModulo'             => 'Composicao',   // Submodulo Referente
            'Metodo'                => 'Composicoes',  // Metodos referentes separados por virgula // Endereco da url de permissão
        ),
        Array(
            'Nome'                  => __('Comercio Vendas (Cardápio) - Adicionar'),
            'Desc'                  => '',
            'Chave'                 => 'comercio_venda_Composicao_Composicoes_Add',
            'End'                   => 'comercio_venda/Composicao/Composicoes_Add',
            'Modulo'                => 'comercio_venda', // Modulo Referente
            'SubModulo'             => 'Composicao',   // Submodulo Referente
            'Metodo'                => 'Composicoes_Add,Composicoes_Add2',  // Metodos referentes separados por virgula // Endereco da url de permissão
        ),
        Array(
            'Nome'                  => __('Comercio Vendas (Cardápio) - Editar'),
            'Desc'                  => '',
            'Chave'                 => 'comercio_venda_Composicao_Composicoes_Edit',
            'End'                   => 'comercio_venda/Composicao/Composicoes_Edit',
            'Modulo'                => 'comercio_venda', // Modulo Referente
            'SubModulo'             => 'Composicao',   // Submodulo Referente
            'Metodo'                => 'Composicoes_Edit,Composicoes_Edit2',  // Metodos referentes separados por virgula // Endereco da url de permissão
        ),
        Array(
            'Nome'                  => __('Comercio Vendas (Cardápio) - Deletar'),
            'Desc'                  => '',
            'Chave'                 => 'comercio_venda_Composicao_Composicoes_Del',
            'End'                   => 'comercio_venda/Composicao/Composicoes_Del',
            'Modulo'                => 'comercio_venda', // Modulo Referente
            'SubModulo'             => 'Composicao',   // Submodulo Referente
            'Metodo'                => 'Composicoes_Del',  // Metodos referentes separados por virgula // Endereco da url de permissão
        ),
        /*Array(
            'Nome'                  => __('Visualizar Relatórios'),
            'Desc'                  => '',
            'Chave'                 => 'comercio_venda_Relatorio',
            'End'                   => 'comercio_venda/Relatorio',
            'Modulo'                => 'comercio_venda', // Modulo Referente
            'SubModulo'             => 'Relatorio',   // Submodulo Referente
            'Metodo'                => '*',  // Metodos referentes separados por virgula
        )*/
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
        'comercio_venda_mesa'  => Array(
            'Nome'                  => __('Se Possui Sistema de Mesas?'),
            'Desc'                  => __('Se possue Mesas'),
            'chave'                 => 'comercio_venda_mesa',
            'Valor'                 => false
        ),
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
?>
