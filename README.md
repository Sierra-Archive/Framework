Framework
=========

Framework desenvolvido para Sistemas de Gestão

"O que me cita, me excita!"

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
* Ini/dominio.com/
* Interface/ `Interface das Classes Principais do Framework`
* Temp/ `usado para criação de imagens`
* arq/ `Destinado aos arquivos de upload e do sistema`
* lang/
* layoult/ `Temas do Framework`
* layoult/nome_do_layoult/ `Temas (xN)`
* layoult/nome_do_layoult/ config/
* layoult/nome_do_layoult/ * config.php
* layoult/nome_do_layoult/ css/
* layoult/nome_do_layoult/ img/
* layoult/nome_do_layoult/ elemento_botao.php
* layoult/nome_do_layoult/ elemento_miniwidget.php
* layoult/nome_do_layoult/ page_login.php
* layoult/nome_do_layoult/ template.php
* layoult/nome_do_layoult/ template_abas.php
* layoult/nome_do_layoult/ template_bloco.php
* layoult/nome_do_layoult/ template_form.php
* layoult/nome_do_layoult/ template_tabela.php
* layoult/nome_do_layoult/ widget_menu.php
* layoult/nome_do_layoult/ widget_usuario.php
* libs/ `Bibliotecas que podem ser usadas`
* mod/ `Modulos do Framework (xN)`
* mod/nome_do_modulo/
* mod/nome_do_modulo/_Config.php
* mod/nome_do_modulo/_Principal.Class.php
* mod/nome_do_modulo/{nome_do_modulo}_Controle.php
* mod/nome_do_modulo/{nome_do_modulo}_Modelo.php
* mod/nome_do_modulo/{nome_do_modulo}_Visual.php
* mod/nome_do_modulo/{nome_do_modulo}_{nome_do_submodulo}C.php
* mod/nome_do_modulo/{nome_do_modulo}_{nome_do_submodulo}M.php
* mod/nome_do_modulo/{nome_do_modulo}_{nome_do_submodulo}V.php
* web/ `Plugins html e js usados pelo framework`
* index.php
* .htaccess
