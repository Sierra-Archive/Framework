Framework
=========

Para usar deve criar uma pasta chamada localhost ou o nome do dominio que esta
hospedado, os arquivos de configuração devem ficar dentro dela.

config.php {
    <?php
    define('SIS_SERVER',        'servidor');// Seu servidor do bando de dados
    define('SIS_USUARIO',        'usuario');// Nome de usuario do banco de dados
    define('SIS_SENHA',        'senha_aqui');// Senha do banco de dados
    define('SIS_BANCO',        'BANCO_DADOS_NOME');

    // Principais
    define('SISTEMA_DEBUG',         true);
    define('SRV_NAME_SQL',          'NOME_DO_PROJETO'); // PODE SER USADO O MESMO BANCO DE DADOS PARA VARIOS SISTEMAS, 
                                                        // ESSE NOME É USADO PARA NÂO HAVER CONFLITO ENTRE OS SISTEMAS
    define('SISTEMA_LINGUAGEM',          'ptBR');

    // CONFIGURACOES PHP
    define('SOBRE_DIREITOS',        'sierratecnologia');
    define('SOBRE_SLOGAN',          'sierratecnologia');
    define('SOBRE_COMPANY',         'www.sierratecnologia.com.br');
    define('SISTEMA_URL',           'http://localhost/');
    define('SISTEMA_DIR',           'Framework/');
    define('SISTEMA_NOME',          'sierratecnologia');

    define('SISTEMA_END',           'sierratecnologia.com.br');
    define('SISTEMA_TELEFONE',      '(21) 0000-0000');
    define('SISTEMA_EMAIL',         'contato@sierratecnologia.com.br');

    // Configuracoes Tecnicas
    define('CFG_TEC_IDADMINDEUS'        ,       1);
    define('CFG_TEC_IDADMIN'            ,       2);
    define('CFG_TEC_IDCLIENTE'          ,       3);
    define('CFG_TEC_IDFUNCIONARIO'      ,       4);
    define('CFG_TEC_CAT_ID_ADMIN'       ,       1);
    define('CFG_TEC_CAT_ID_CLIENTES'    ,       2);
    define('CFG_TEC_CAT_ID_FUNCIONARIOS',       3);


    // Configuracao de Layoult
    define('TEMA_PADRAO', 'metrolab');
    ?>
}

config_modulos.php {
    <?php
    // Modulos
    function config_modulos(){ 
        return Array(
            'biblioteca'                => 'biblioteca',
            'categoria'                 => 'categoria',
            'comercio'                  => 'comercio',
            'comercio_servicos'         => 'comercio_servicos',
            'Financeiro'                => 'Financeiro',
            'locais'                    => 'locais',
            [...] outros modulos [...]
        );
    }
    ?>
}