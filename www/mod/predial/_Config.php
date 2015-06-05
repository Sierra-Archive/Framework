<?php
$config_Modulo = function (){
    return Array(
        'Nome'                      =>  'predial',
        'Descrição'                 =>  '',
        'System_Require'            =>  '3.1.0',
        'Version'                   =>  '3.1.1',
        'Dependencias'              =>  false,
    );
};
$config_Menu = function (){
    return Array(
        'Predial' => Array(
            'Nome'                  => __('Predial'),
            'Link'                  => '#',
            'Gravidade'             => 400,
            'Img'                   => 'turboadmin/m-dashboard.png',
            'Icon'                  => 'building',
            'Filhos'                => Array('Blocos'=>Array(
                'Nome'                  => __('Blocos'),
                'Link'                  => 'predial/Bloco/Blocos',
                'Gravidade'             => 90,
                'Img'                   => '',
                'Icon'                  => 'building',
                'Filhos'                => false,
            ),'Apartamentos'=>Array(
                'Nome'                  => __('Apartamentos'),
                'Link'                  => 'predial/Apart/Aparts',
                'Gravidade'             => 80,
                'Img'                   => '',
                'Icon'                  => 'building',
                'Filhos'                => false,
            ),'Veiculos'=>Array(
                'Nome'                  => __('Veiculos'),
                'Link'                  => 'predial/Veiculo/Veiculos',
                'Gravidade'             => 70,
                'Img'                   => '',
                'Icon'                  => 'plane',
                'Filhos'                => false,
            ),'Animais'=>Array(
                'Nome'                  => __('Animais'),
                'Link'                  => 'predial/Animal/Animais',
                'Gravidade'             => 60,
                'Img'                   => '',
                'Icon'                  => 'bug',
                'Filhos'                => false,
            ),'Correios'=>Array(
                'Nome'                  => __('Correios'),
                'Link'                  => 'predial/Correio/Correios',
                'Gravidade'             => 50,
                'Img'                   => '',
                'Icon'                  => 'envelope-alt',
                'Filhos'                => false,
            ),'Advertências'=>Array(
                'Nome'                  => __('Advertências'),
                'Link'                  => 'predial/Advertencia/Advertencias',
                'Gravidade'             => 40,
                'Img'                   => '',
                'Icon'                  => 'book',
                'Filhos'                => false,
            ),'Advertências'=>Array(
                'Nome'                  => __('Locais de Reserva'),
                'Link'                  => 'predial/Salao/Saloes',
                'Gravidade'             => 40,
                'Img'                   => '',
                'Icon'                  => 'book',
                'Filhos'                => false,
            ),'Informativos'=>Array(
                'Nome'                  => __('Informativos'),
                'Link'                  => 'predial/Informativo/Informativos',
                'Gravidade'             => 30,
                'Img'                   => '',
                'Icon'                  => 'book',
                'Filhos'                => false,
            ),),
        ),
    );
};
$config_Permissoes = function (){
    return Array(
        // BLOCOS
        Array(
            'Nome'                  => __('Predial (Blocos) - Listagem'),
            'Desc'                  => '',
            'Chave'                 => 'predial_Bloco_Blocos',
            'End'                   => 'predial/Bloco/Blocos',
            'Modulo'                => 'predial', // Modulo Referente
            'SubModulo'             => 'Bloco',   // Submodulo Referente
            'Metodo'                => 'Blocos',  // Metodos referentes separados por virgula// Endereco que deve conter a url para permitir acesso
        ),
        Array(
            'Nome'                  => __('Predial (Blocos) - Add'),
            'Desc'                  => '',
            'Chave'                 => 'predial_Bloco_Blocos_Add', // CHave unica nunca repete, chave primaria
            'End'                   => 'predial/Bloco/Blocos_Add', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'predial', // Modulo Referente
            'SubModulo'             => 'Bloco',   // Submodulo Referente
            'Metodo'                => 'Blocos_Add,Blocos_Add2',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => __('Predial (Blocos) - Editar'),
            'Desc'                  => '',
            'Chave'                 => 'predial_Bloco_Blocos_Edit', // CHave unica nunca repete, chave primaria
            'End'                   => 'predial/Bloco/Blocos_Edit', // Endereco que deve conter a url para permitir acesso // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'predial', // Modulo Referente // Modulo Referente
            'SubModulo'             => 'Bloco',   // Submodulo Referente   // Submodulo Referente
            'Metodo'                => 'Blocos_Edit,Blocos_Edit2',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => __('Predial (Blocos) - Deletar'),
            'Desc'                  => '',
            'Chave'                 => 'predial_Bloco_Blocos_Del', // CHave unica nunca repete, chave primaria
            'End'                   => 'predial/Bloco/Blocos_Del', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'predial', // Modulo Referente
            'SubModulo'             => 'Bloco',   // Submodulo Referente
            'Metodo'                => 'Blocos_Del',  // Metodos referentes separados por virgula
        ),
        
        // APARTAMENTOS
        Array(
            'Nome'                  => __('Predial (Apartamentos) - Listagem'),
            'Desc'                  => '',
            'Chave'                 => 'predial_Apart_Aparts',
            'End'                   => 'predial/Apart/Aparts', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'predial', // Modulo Referente
            'SubModulo'             => 'Apart',   // Submodulo Referente
            'Metodo'                => 'Aparts',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => __('Predial (Apartamentos) - Add'),
            'Desc'                  => '',
            'Chave'                 => 'predial_Apart_Aparts_Add', // CHave unica nunca repete, chave primaria
            'End'                   => 'predial/Apart/Aparts_Add', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'predial', // Modulo Referente
            'SubModulo'             => 'Apart',   // Submodulo Referente
            'Metodo'                => 'Aparts_Add,Aparts_Add2',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => __('Predial (Apartamentos) - Editar'),
            'Desc'                  => '',
            'Chave'                 => 'predial_Apart_Aparts_Edit', // CHave unica nunca repete, chave primaria
            'End'                   => 'predial/Apart/Aparts_Edit', // Endereco que deve conter a url para permitir acesso // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'predial', // Modulo Referente // Modulo Referente
            'SubModulo'             => 'Apart',   // Submodulo Referente   // Submodulo Referente
            'Metodo'                => 'Aparts_Edit,Aparts_Edit2',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => __('Predial (Apartamentos) - Deletar'),
            'Desc'                  => '',
            'Chave'                 => 'predial_Apart_Aparts_Del', // CHave unica nunca repete, chave primaria
            'End'                   => 'predial/Apart/Aparts_Del', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'predial', // Modulo Referente
            'SubModulo'             => 'Apart',   // Submodulo Referente
            'Metodo'                => 'Aparts_Del',  // Metodos referentes separados por virgula
        ),
        
        
        // ADVERTENCIA
        Array(
            'Nome'                  => __('Predial (Advertências) - Listagem'),
            'Desc'                  => '',
            'Chave'                 => 'predial_Advertencia_Advertencia',
            'End'                   => 'predial/Advertencia/Advertencias', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'predial', // Modulo Referente
            'SubModulo'             => 'Advertencia',   // Submodulo Referente
            'Metodo'                => 'Advertencia',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => __('Predial (Advertências) - Add'),
            'Desc'                  => '',
            'Chave'                 => 'predial_Advertencia_Advertencias_Add', // CHave unica nunca repete, chave primaria
            'End'                   => 'predial/Advertencia/Advertencias_Add', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'predial', // Modulo Referente
            'SubModulo'             => 'Advertencia',   // Submodulo Referente
            'Metodo'                => 'Advertencias_Add,Advertencias_Add2',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => __('Predial (Advertências) - Editar'),
            'Desc'                  => '',
            'Chave'                 => 'predial_Advertencia_Advertencias_Edit', // CHave unica nunca repete, chave primaria
            'End'                   => 'predial/Advertencia/Advertencias_Edit', // Endereco que deve conter a url para permitir acesso // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'predial', // Modulo Referente // Modulo Referente
            'SubModulo'             => 'Advertencia',   // Submodulo Referente   // Submodulo Referente
            'Metodo'                => 'Advertencias_Edit,Advertencias_Edit2',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => __('Predial (Advertências) - Deletar'),
            'Desc'                  => '',
            'Chave'                 => 'predial_Advertencia_Advertencias_Del', // CHave unica nunca repete, chave primaria
            'End'                   => 'predial/Advertencia/Advertencias_Del', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'predial', // Modulo Referente
            'SubModulo'             => 'Advertencia',   // Submodulo Referente
            'Metodo'                => 'Advertencias_Del',  // Metodos referentes separados por virgula
        ),
        
        
        // ANIMAL
        Array(
            'Nome'                  => __('Predial (Animais) - Listagem'),
            'Desc'                  => '',
            'Chave'                 => 'predial_Animal_Animais',
            'End'                   => 'predial/Animal/Animais', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'predial', // Modulo Referente
            'SubModulo'             => 'Animal',   // Submodulo Referente
            'Metodo'                => 'Animais',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => __('Predial (Animais) - Add'),
            'Desc'                  => '',
            'Chave'                 => 'predial_Animal_Animais_Add', // CHave unica nunca repete, chave primaria
            'End'                   => 'predial/Animal/Animais_Add', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'predial', // Modulo Referente
            'SubModulo'             => 'Animal',   // Submodulo Referente
            'Metodo'                => 'Animais_Add,Animais_Add2',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => __('Predial (Animais) - Editar'),
            'Desc'                  => '',
            'Chave'                 => 'predial_Animal_Animais_Edit', // CHave unica nunca repete, chave primaria
            'End'                   => 'predial/Animal/Animais_Edit', // Endereco que deve conter a url para permitir acesso // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'predial', // Modulo Referente // Modulo Referente
            'SubModulo'             => 'Animal',   // Submodulo Referente   // Submodulo Referente
            'Metodo'                => 'Animais_Edit,Animais_Edit2',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => __('Predial (Animais) - Deletar'),
            'Desc'                  => '',
            'Chave'                 => 'predial_Animal_Animais_Del', // CHave unica nunca repete, chave primaria
            'End'                   => 'predial/Animal/Animais_Del', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'predial', // Modulo Referente
            'SubModulo'             => 'Animal',   // Submodulo Referente
            'Metodo'                => 'Animais_Del',  // Metodos referentes separados por virgula
        ),
        
        
        // CORREIO
        Array(
            'Nome'                  => __('Predial (Correios) - Listagem'),
            'Desc'                  => '',
            'Chave'                 => 'predial_Correio_Correios',
            'End'                   => 'predial/Correio/Correios', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'predial', // Modulo Referente
            'SubModulo'             => 'Correio',   // Submodulo Referente
            'Metodo'                => 'Correios',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => __('Predial (Correios) - Add'),
            'Desc'                  => '',
            'Chave'                 => 'predial_Correio_Correios_Add', // CHave unica nunca repete, chave primaria
            'End'                   => 'predial/Correio/Correios_Add', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'predial', // Modulo Referente
            'SubModulo'             => 'Correio',   // Submodulo Referente
            'Metodo'                => 'Correios_Add,Correios_Add2',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => __('Predial (Correios) - Editar'),
            'Desc'                  => '',
            'Chave'                 => 'predial_Correio_Correios_Edit', // CHave unica nunca repete, chave primaria
            'End'                   => 'predial/Correio/Correios_Edit', // Endereco que deve conter a url para permitir acesso // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'predial', // Modulo Referente // Modulo Referente
            'SubModulo'             => 'Correio',   // Submodulo Referente   // Submodulo Referente
            'Metodo'                => 'Correios_Edit,Correios_Edit2',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => __('Predial (Correios) - Deletar'),
            'Desc'                  => '',
            'Chave'                 => 'predial_Correio_Correios_Del', // CHave unica nunca repete, chave primaria
            'End'                   => 'predial/Correio/Correios_Del', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'predial', // Modulo Referente
            'SubModulo'             => 'Correio',   // Submodulo Referente
            'Metodo'                => 'Correios_Del',  // Metodos referentes separados por virgula
        ),
        
        
        // INFORMATIVO
        Array(
            'Nome'                  => __('Predial (Informativos) - Listagem'),
            'Desc'                  => '',
            'Chave'                 => 'predial_Informativo_Informativos',
            'End'                   => 'predial/Informativo/Informativos', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'predial', // Modulo Referente
            'SubModulo'             => 'Informativo',   // Submodulo Referente
            'Metodo'                => 'Informativo',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => __('Predial (Informativos) - Add'),
            'Desc'                  => '',
            'Chave'                 => 'predial_Informativo_Informativos_Add', // CHave unica nunca repete, chave primaria
            'End'                   => 'predial/Informativo/Informativos_Add', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'predial', // Modulo Referente
            'SubModulo'             => 'Informativo',   // Submodulo Referente
            'Metodo'                => 'Informativos_Add,Informativos_Add2',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => __('Predial (Informativos) - Editar'),
            'Desc'                  => '',
            'Chave'                 => 'predial_Informativo_Informativos_Edit', // CHave unica nunca repete, chave primaria
            'End'                   => 'predial/Informativo/Informativos_Edit', // Endereco que deve conter a url para permitir acesso // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'predial', // Modulo Referente // Modulo Referente
            'SubModulo'             => 'Informativo',   // Submodulo Referente   // Submodulo Referente
            'Metodo'                => 'Informativos_Edit,Informativos_Edit2',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => __('Predial (Informativos) - Deletar'),
            'Desc'                  => '',
            'Chave'                 => 'predial_Informativo_Informativos_Del', // CHave unica nunca repete, chave primaria
            'End'                   => 'predial/Informativo/Informativos_Del', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'predial', // Modulo Referente
            'SubModulo'             => 'Informativo',   // Submodulo Referente
            'Metodo'                => 'Informativos_Del',  // Metodos referentes separados por virgula
        ),
        
        
        // SALAO
        Array(
            'Nome'                  => __('Predial (Salões) - Listagem'),
            'Desc'                  => '',
            'Chave'                 => 'predial_Salao_Saloes',
            'End'                   => 'predial/Salao/Saloes', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'predial', // Modulo Referente
            'SubModulo'             => 'Salao',   // Submodulo Referente
            'Metodo'                => 'Saloes',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => __('Predial (Salões) - Add'),
            'Desc'                  => '',
            'Chave'                 => 'predial_Salao_Saloes_Add', // CHave unica nunca repete, chave primaria
            'End'                   => 'predial/Salao/Saloes_Add', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'predial', // Modulo Referente
            'SubModulo'             => 'Salao',   // Submodulo Referente
            'Metodo'                => 'Saloes_Add,Saloes_Add2',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => __('Predial (Salões) - Editar'),
            'Desc'                  => '',
            'Chave'                 => 'predial_Salao_Saloes_Edit', // CHave unica nunca repete, chave primaria
            'End'                   => 'predial/Salao/Saloes_Edit', // Endereco que deve conter a url para permitir acesso // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'predial', // Modulo Referente // Modulo Referente
            'SubModulo'             => 'Salao',   // Submodulo Referente   // Submodulo Referente
            'Metodo'                => 'Saloes_Edit,Saloes_Edit2',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => __('Predial (Salões) - Deletar'),
            'Desc'                  => '',
            'Chave'                 => 'predial_Salao_Saloes_Del', // CHave unica nunca repete, chave primaria
            'End'                   => 'predial/Salao/Saloes_Del', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'predial', // Modulo Referente
            'SubModulo'             => 'Salao',   // Submodulo Referente
            'Metodo'                => 'Saloes_Del',  // Metodos referentes separados por virgula
        ),
        
        
        // VEICULO
        Array(
            'Nome'                  => __('Predial (Veiculos) - Listagem'),
            'Desc'                  => '',
            'Chave'                 => 'predial_Veiculo_Veiculos',
            'End'                   => 'predial/Veiculo/Veiculos', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'predial', // Modulo Referente
            'SubModulo'             => 'Veiculo',   // Submodulo Referente
            'Metodo'                => 'Veiculos',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => __('Predial (Veiculos) - Add'),
            'Desc'                  => '',
            'Chave'                 => 'predial_Veiculo_Veiculos_Add', // CHave unica nunca repete, chave primaria
            'End'                   => 'predial/Veiculo/Veiculos_Add', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'predial', // Modulo Referente
            'SubModulo'             => 'Veiculo',   // Submodulo Referente
            'Metodo'                => 'Veiculos_Add,Veiculos_Add2',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => __('Predial (Veiculos) - Editar'),
            'Desc'                  => '',
            'Chave'                 => 'predial_Veiculo_Veiculos_Edit', // CHave unica nunca repete, chave primaria
            'End'                   => 'predial/Veiculo/Veiculos_Edit', // Endereco que deve conter a url para permitir acesso // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'predial', // Modulo Referente // Modulo Referente
            'SubModulo'             => 'Veiculo',   // Submodulo Referente   // Submodulo Referente
            'Metodo'                => 'Veiculos_Edit,Veiculos_Edit2',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => __('Predial (Veiculos) - Deletar'),
            'Desc'                  => '',
            'Chave'                 => 'predial_Veiculo_Veiculos_Del', // CHave unica nunca repete, chave primaria
            'End'                   => 'predial/Veiculo/Veiculos_Del', // Endereco que deve conter a url para permitir acesso
            'Modulo'                => 'predial', // Modulo Referente
            'SubModulo'             => 'Veiculo',   // Submodulo Referente
            'Metodo'                => 'Veiculos_Del',  // Metodos referentes separados por virgula
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
