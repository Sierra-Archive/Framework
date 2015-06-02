<?php
$config_Modulo = function (){
    return Array(
        'Nome'                      =>  'usuario_veiculo_aluguel',
        'Descrição'                 =>  '',
        'System_Require'            =>  '3.0.0',
        'Version'                   =>  '3.0.1',
        'Dependencias'              =>  false,
    );
};
$config_Menu = function (){
    return Array(
        'Alugueis'=>Array(
            'Nome'                  => 'Alugueis',
            'Link'                  => '#',
            'Gravidade'             => 5,
            'Img'                   => 'menusuperior/alugueis-locar.png',
            'Icon'                  => '',
            'Filhos'                => Array('Veiculos'=>Array(
                'Nome'                  => 'Meus Aluguéis',
                'Link'                  => 'usuario_veiculo_aluguel/Listar/Main',
                'Gravidade'             => 80,
                'Img'                   => 'menusuperior/alugueis-locar.png',
                'Icon'                  => 'truck',
                'Filhos'                => false,
            ),'Veiculos'=>Array(
                'Nome'                  => 'Veiculos',
                'Link'                  => 'usuario_veiculo/Listar/Main',
                'Gravidade'             => 10,
                'Img'                   => 'menusuperior/alugueis-locar.png',
                'Icon'                  => 'road',
                'Filhos'                => false,
            ),),
        ),
    );
};
$config_Permissoes = function (){
    return Array(
        Array(
            'Nome'                  => 'Veiculo (Alugueis) - Visualizar',
            'Desc'                  => '',
            'Chave'                 => 'usuario_veiculo_aluguel_Listar',
            'End'                   => 'usuario_veiculo_aluguel/Listar', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'usuario_veiculo_aluguel', // Modulo Referente
            'SubModulo'             => 'Listar',   // Submodulo Referente
            'Metodo'                => '*',  // Metodos referentes separados por virgula
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
    return Array();
};
?>
