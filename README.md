Framework
=========

Instalação
-------

Para usar deve criar uma pasta chamada localhost ou o nome do dominio que esta
hospedado, os arquivos de configuração devem ficar dentro dela.

`config.php`
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


`config_modulos.php`
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


Estrutura
-----------------

* App/ `Classes Principais do Framework`
* Cache/ `Destinada para arquivos de cache`
* Classes/ `Classes Genéricas que podem ser usadas`
* DAO/ `Arquivos destinado as tabelas do banco de dados`
* Ini/ `Arquivos de Configuração`
* * dominio.com/
* Interface/
* Temp/ `usado para criação de imagens`
* arq/ `Destinado aos arquivos de upload e do sistema`
* lang/
* layoult/ `Temas do Framework`
* * nome_do_layoult/ `Temas (xN)`
* * * config/
* * * * config.php
* * * css/
* * * img/
* * * elemento_botao.php
* * * elemento_miniwidget.php
* * * page_login.php
* * * template.php
* * * template_abas.php
* * * template_bloco.php
* * * template_form.php
* * * template_tabela.php
* * * widget_menu.php
* * * widget_usuario.php
* libs/ `Bibliotecas que podem ser usadas`
* mod/ `Modulos do Framework (xN)`
* * nome_do_modulo/
* * * _Config.php
* * * _Principal.Class.php
* * * {nome_do_modulo}_Controle.php
* * * {nome_do_modulo}_Modelo.php
* * * {nome_do_modulo}_Visual.php
* * * {nome_do_modulo}_{nome_do_submodulo}C.php
* * * {nome_do_modulo}_{nome_do_submodulo}M.php
* * * {nome_do_modulo}_{nome_do_submodulo}V.php
* web/ `Plugins html e js usados pelo framework`
* index.php
* .htaccess