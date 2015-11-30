<?php
$configModule = function () {
    return Array(
        'Nome'                      =>  'Musica',
        'Descrição'                 =>  '',
        'System_Require'            =>  '3.1.0',
        'Version'                   =>  '3.1.1',
        'Dependencias'              =>  false,
    );
};
$configMenu = function () {
    return Array(
        'Midia' => Array(
            'Nome'                  => __('Midia'),
            'Link'                  => '#',
            'Gravidade'             => 80,
            'Img'                   => '',
            'Icon'                  => 'building',
            'Filhos'                => Array(__('Artistas')=>Array(
                'Nome'                  => __('Artistas'),
                'Link'                  => 'Musica/Artista/Artistas',
                'Gravidade'             => 90,
                'Img'                   => '',
                'Icon'                  => 'group',
                'Filhos'                => false,
            ),'Albuns'=>Array(
                'Nome'                  => __('Albuns'),
                'Link'                  => 'Musica/Album/Albuns',
                'Gravidade'             => 80,
                'Img'                   => '',
                'Icon'                  => 'hdd',
                'Filhos'                => false,
            ),'Musicas'=>Array(
                'Nome'                  => __('Musicas'),
                'Link'                  => 'Musica/Musica/Musicas',
                'Gravidade'             => 70,
                'Img'                   => '',
                'Icon'                  => 'music',
                'Filhos'                => false,
            ),'Videos'=>Array(
                'Nome'                  => __('Videos'),
                'Link'                  => 'Musica/Video/Videos',
                'Gravidade'             => 60,
                'Img'                   => '',
                'Icon'                  => 'facetime-video',
                'Filhos'                => false,
            ),),
        ),
    );
};
$config_Permissoes = function () {
    return Array(
        Array(
            'Nome'                  => __('Midia (Artistas) - Listagem'),
            'Desc'                  => '',
            'Chave'                 => 'Musica_Artista_Artistas',
            'End'                   => 'Musica/Artista/Artistas', // Endereco da url de permissão
            'Modulo'                => 'Musica', // Modulo Referente
            'SubModulo'             => 'Artista',// Submodulo Referente
            'Metodo'                => 'Artistas',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => __('Midia (Artistas) - Add'),
            'Desc'                  => '',
            'Chave'                 => 'Musica_Artista_Artistas_Add', // CHave unica nunca repete, chave primaria
            'End'                   => 'Musica/Artista/Artistas_Add', // Endereco da url de permissão
            'Modulo'                => 'Musica', // Modulo Referente
            'SubModulo'             => 'Artista',   // Submodulo Referente
            'Metodo'                => 'Artistas_Add,Artistas_Add2',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => __('Midia (Artistas) - Editar'),
            'Desc'                  => '',
            'Chave'                 => 'Musica_Artista_Artistas_Edit', // CHave unica nunca repete, chave primaria
            'End'                   => 'Musica/Artista/Artistas_Edit', // Endereco da url de permissão
            'Modulo'                => 'Musica', // Modulo Referente
            'SubModulo'             => 'Artista',// Submodulo Referente
            'Metodo'                => 'Artistas_Edit,Artistas_Edit2',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => __('Midia (Artistas) - Deletar'),
            'Desc'                  => '',
            'Chave'                 => 'Musica_Artista_Artistas_Del', // CHave unica nunca repete, chave primaria
            'End'                   => 'Musica/Artista/Artistas_Del', // Endereco da url de permissão
            'Modulo'                => 'Musica', // Modulo Referente
            'SubModulo'             => 'Artista',   // Submodulo Referente
            'Metodo'                => 'Artistas_Del',  // Metodos referentes separados por virgula
        ),
        
        Array(
            'Nome'                  => __('Midia (Albuns) - Listagem'),
            'Desc'                  => '',
            'Chave'                 => 'Musica_Album_Albuns',
            'End'                   => 'Musica/Album/Albuns', // Endereco da url de permissão
            'Modulo'                => 'Musica', // Modulo Referente
            'SubModulo'             => 'Album',// Submodulo Referente
            'Metodo'                => 'Albuns',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => __('Midia (Albuns) - Add'),
            'Desc'                  => '',
            'Chave'                 => 'Musica_Album_Albuns_Add', // CHave unica nunca repete, chave primaria
            'End'                   => 'Musica/Album/Albuns_Add', // Endereco da url de permissão
            'Modulo'                => 'Musica', // Modulo Referente
            'SubModulo'             => 'Album',   // Submodulo Referente
            'Metodo'                => 'Albuns_Add,Albuns_Add2',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => __('Midia (Albuns) - Editar'),
            'Desc'                  => '',
            'Chave'                 => 'Musica_Album_Albuns_Edit', // CHave unica nunca repete, chave primaria
            'End'                   => 'Musica/Album/Albuns_Edit', // Endereco da url de permissão
            'Modulo'                => 'Musica', // Modulo Referente
            'SubModulo'             => 'Album',// Submodulo Referente
            'Metodo'                => 'Albuns_Edit,Albuns_Edit2',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => __('Midia (Albuns) - Deletar'),
            'Desc'                  => '',
            'Chave'                 => 'Musica_Album_Albuns_Del', // CHave unica nunca repete, chave primaria
            'End'                   => 'Musica/Album/Albuns_Del', // Endereco da url de permissão
            'Modulo'                => 'Musica', // Modulo Referente
            'SubModulo'             => 'Album',   // Submodulo Referente
            'Metodo'                => 'Albuns_Del',  // Metodos referentes separados por virgula
        ),
        
        Array(
            'Nome'                  => __('Midia (Musicas) - Listagem'),
            'Desc'                  => '',
            'Chave'                 => 'Musica_Musica_Musicas',
            'End'                   => 'Musica/Musica/Musicas', // Endereco da url de permissão
            'Modulo'                => 'Musica', // Modulo Referente
            'SubModulo'             => 'Musica',// Submodulo Referente
            'Metodo'                => 'Musicas',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => __('Midia (Musicas) - Add'),
            'Desc'                  => '',
            'Chave'                 => 'Musica_Musica_Musicas_Add', // CHave unica nunca repete, chave primaria
            'End'                   => 'Musica/Musica/Musicas_Add', // Endereco da url de permissão
            'Modulo'                => 'Musica', // Modulo Referente
            'SubModulo'             => 'Musica',   // Submodulo Referente
            'Metodo'                => 'Musicas_Add,Musicas_Add2',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => __('Midia (Musicas) - Editar'),
            'Desc'                  => '',
            'Chave'                 => 'Musica_Musica_Musicas_Edit', // CHave unica nunca repete, chave primaria
            'End'                   => 'Musica/Musica/Musicas_Edit', // Endereco da url de permissão
            'Modulo'                => 'Musica', // Modulo Referente
            'SubModulo'             => 'Musica',// Submodulo Referente
            'Metodo'                => 'Musicas_Edit,Musicas_Edit2',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => __('Midia (Musicas) - Deletar'),
            'Desc'                  => '',
            'Chave'                 => 'Musica_Musica_Musicas_Del', // CHave unica nunca repete, chave primaria
            'End'                   => 'Musica/Musica/Musicas_Del', // Endereco da url de permissão
            'Modulo'                => 'Musica', // Modulo Referente
            'SubModulo'             => 'Musica',   // Submodulo Referente
            'Metodo'                => 'Musicas_Del',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => __('Midia (Video) - Listagem'),
            'Desc'                  => '',
            'Chave'                 => 'Musica_Video_Videos',
            'End'                   => 'Musica/Video/Videos', // Endereco da url de permissão
            'Modulo'                => 'Musica', // Modulo Referente
            'SubModulo'             => 'Video',// Submodulo Referente
            'Metodo'                => 'Videos_Edit,Videos_Edit2',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => __('Midia (Video) - Add'),
            'Desc'                  => '',
            'Chave'                 => 'Musica_Video_Videos_Add', // CHave unica nunca repete, chave primaria
            'End'                   => 'Musica/Video/Videos_Add', // Endereco da url de permissão
            'Modulo'                => 'Musica', // Modulo Referente
            'SubModulo'             => 'Video',   // Submodulo Referente
            'Metodo'                => 'Videos_Add,Videos_Add2',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => __('Midia (Video) - Editar'),
            'Desc'                  => '',
            'Chave'                 => 'Musica_Video_Videos_Edit', // CHave unica nunca repete, chave primaria
            'End'                   => 'Musica/Video/Videos_Edit', // Endereco da url de permissão
            'Modulo'                => 'Musica', // Modulo Referente
            'SubModulo'             => 'Video',// Submodulo Referente
            'Metodo'                => 'Videos_Edit,Videos_Edit2',  // Metodos referentes separados por virgula
        ),
        Array(
            'Nome'                  => __('Midia (Video) - Deletar'),
            'Desc'                  => '',
            'Chave'                 => 'Musica_Video_Videos_Del', // CHave unica nunca repete, chave primaria
            'End'                   => 'Musica/Video/Videos_Del', // Endereco da url de permissão
            'Modulo'                => 'Musica', // Modulo Referente
            'SubModulo'             => 'Video',   // Submodulo Referente
            'Metodo'                => 'Videos_Del',  // Metodos referentes separados por virgula
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
    return Array();
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
