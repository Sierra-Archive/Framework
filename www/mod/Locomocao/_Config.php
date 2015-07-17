<?php
$config_Modulo = function (){
    return Array(
        'Nome'                      =>  'Locomocao',
        'Descrição'                 =>  'Módulo Criado para o Calculo de Locomocao assim como cadastro de motoboys e entrega por emcomenda.',
        'System_Require'            =>  '3.1.0',
        'Version'                   =>  '3.1.1',
        'Dependencias'              =>  false,
    );
};
$config_Menu = function (){
    return Array(
        'Entregas' => Array(
            'Nome'                  => __('Entregas'),
            'Link'                  => '#',
            'Gravidade'             => 6,
            'Img'                   => 'turboadmin/m-dashboard.png',
            'Icon'                  => 'truck',
            'Filhos'                => Array('Todas as Entregas'=>Array(
                'Nome'                  => __('Todas as Entregas'),
                'Link'                  => 'Locomocao/Entrega/Entregas',
                'Gravidade'             => 5,
                'Img'                   => 'turboadmin/m-dashboard.png',
                'Icon'                  => 'truck',
                'Filhos'                => false,
            ))
        )
    );
};
$config_Permissoes = function (){
    return Array(
        
        // Entrega
        Array(
            'Nome'                  => __('Locomoção (Entrega) - Listagem'),
            'Desc'                  => '',
            'Chave'                 => 'Locomocao_Entrega_Entregas',
            'End'                   => 'Locomocao/Entrega/Entregas', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Locomocao', // Modulo Referente
            'SubModulo'             => 'Entrega',   // Submodulo Referente
            'Metodo'                => 'Entregas'  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => __('Locomoção (Entrega) - Add'),
            'Desc'                  => '',
            'Chave'                 => 'Locomocao_Entrega_Entregas_Add', // CHave unica nunca repete, chave primaria
            'End'                   => 'Locomocao/Entrega/Entregas_Add', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Locomocao', // Modulo Referente
            'SubModulo'             => 'Entrega',   // Submodulo Referente
            'Metodo'                => 'Entregas_Add,Entregas_Add2'  // Metodos referentes separados por virgula
        ), 
        Array(
            'Nome'                  => __('Locomoção (Entrega) - Add'),
            'Desc'                  => '',
            'Chave'                 => 'Locomocao_Entrega_Entregas_Add', // CHave unica nunca repete, chave primaria
            'End'                   => 'Locomocao/Entrega/Entregas_Add', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Locomocao', // Modulo Referente
            'SubModulo'             => 'Entrega',   // Submodulo Referente
            'Metodo'                => 'Entregas_Add,Entregas_Add2'  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => __('Locomoção (Entrega) - Editar'),
            'Desc'                  => '',
            'Chave'                 => 'Locomocao_Entrega_Entregas_Edit', // CHave unica nunca repete, chave primaria
            'End'                   => 'Locomocao/Entrega/Entregas_Edit', // Endereco que deve conter a url para permitir acesso // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Locomocao', // Modulo Referente // Modulo Referente
            'SubModulo'             => 'Entrega',   // Submodulo Referente   // Submodulo Referente
            'Metodo'                => 'Entregas_Edit,Entregas_Edit2'  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => __('Locomoção (Entrega) - Deletar'),
            'Desc'                  => '',
            'Chave'                 => 'Locomocao_Entrega_Entregas_Del', // CHave unica nunca repete, chave primaria
            'End'                   => 'Locomocao/Entrega/Entregas_Del', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'Locomocao', // Modulo Referente
            'SubModulo'             => 'Entrega',   // Submodulo Referente
            'Metodo'                => 'Entregas_Del'  // Metodos referentes separados por virgula
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
        /*'Locomocao_Avancado'  => Array(
            'Nome'                  => 'Locomocao -> Avancado',
            'Desc'                  => __('Se Carrega ou nao Permissao em Avancado e se aparece no menu'),
            'chave'                 => 'Locomocao_Avancado',
            'Valor'                 => true,  // false, true, ou array com os grupos que pode
        ),*/
    );
};
/**
 * Configurações que podem ser Alteradas por Admin ou outros usuarios do Locomocao (Parametros Opcionais: Mascara e Max
 * @return type
 * 
 * @author Ricardo Sierra <web@ricardosierra.com.br>
 */
$config_Publico = function (){
    return Array(
        'Locomocao_Entrega_Kmminbase'  => Array(
            'Nome'                  => __('Km Min Ret. Base'),
            'Desc'                  => __('Km Min Ret. Base'),
            'Chave'                 => 'Locomocao_Entrega_Kmminbase',
            'Valor'                 => '12',
            'Mascara'               => 'Numero',
            'Max'                   => '1000'
        ),
        'Locomocao_Entrega_Kmminponto'  => Array(
            'Nome'                  => __('Km Min Ponto'),
            'Desc'                  => __('Km Min Ponto'),
            'Chave'                 => 'Locomocao_Entrega_Kmminponto',
            'Valor'                 => '12',
            'Mascara'               => 'Numero',
            'Max'                   => '1000'
        ),
        'Locomocao_Entrega_MinMin'  => Array(
            'Nome'                  => __('Minutos Minimos'),
            'Desc'                  => __('Minutos Minimos'),
            'Chave'                 => 'Locomocao_Entrega_MinMin',
            'Valor'                 => '60',
            'Mascara'               => 'Numero',
            'Max'                   => '1000'
        ),
        'Locomocao_Entrega_Kmmintotal'  => Array(
            'Nome'                  => __('Km Min Total'),
            'Desc'                  => __('Km Min Total'),
            'Chave'                 => 'Locomocao_Entrega_Kmmintotal',
            'Valor'                 => '36',
            'Mascara'               => 'Numero',
            'Max'                   => '1000'
        ),
        'Locomocao_Entrega_Preco49'  => Array(
            'Nome'                  => __('Preço por Km (Até 49)'),
            'Desc'                  => __('Preço por Km (Até 49)'),
            'Chave'                 => 'Locomocao_Entrega_Preco49',
            'Valor'                 => '0.8',
            'Mascara'               => 'Real',
            'Max'                   => '1000'
        ),
        'Locomocao_Entrega_Preco89'  => Array(
            'Nome'                  => __('Preço por Km (Até 89)'),
            'Desc'                  => __('Preço por Km (Até 89)'),
            'Chave'                 => 'Locomocao_Entrega_Preco89',
            'Valor'                 => '0.8',
            'Mascara'               => 'Real',
            'Max'                   => '1000'
        ),
        'Locomocao_Entrega_Preco169'  => Array(
            'Nome'                  => __('Preço por Km (Até 169)'),
            'Desc'                  => __('Preço por Km (Até 169)'),
            'Chave'                 => 'Locomocao_Entrega_Preco169',
            'Valor'                 => '0.85',
            'Mascara'               => 'Real',
            'Max'                   => '1000'
        ),
        'Locomocao_Entrega_Preco170'  => Array(
            'Nome'                  => __('Preço por Km (+170)'),
            'Desc'                  => __('Preço por Km (+170)'),
            'Chave'                 => 'Locomocao_Entrega_Preco170',
            'Valor'                 => '1.25',
            'Mascara'               => 'Real',
            'Max'                   => '1000'
        )
    );
};
?>
