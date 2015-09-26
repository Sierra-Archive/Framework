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
    define('SISTEMA_LINGUAGEM_PADRAO',          'pt_BR');

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
* media/ `Destinado aos arquivos de upload e do sistema`
* i18n/ `Arquivos de Internacionalização`
* templates/ `Temas do Framework`
* templates/nome_do_template/ `Temas (xN)`
* templates/nome_do_template/ config/
* templates/nome_do_template/ * config.php
* templates/nome_do_template/ css/
* templates/nome_do_template/ img/
* templates/nome_do_template/ elemento_botao.php
* templates/nome_do_template/ elemento_miniwidget.php
* templates/nome_do_template/ page_login.php
* templates/nome_do_template/ template.php
* templates/nome_do_template/ template_abas.php
* templates/nome_do_template/ template_bloco.php
* templates/nome_do_template/ template_form.php
* templates/nome_do_template/ template_tabela.php
* templates/nome_do_template/ widget_menu.php
* templates/nome_do_template/ widget_usuario.php
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
* static/ `Plugins html e js usados pelo framework`
* index.php
* .htaccess


Versionamento
-----------------
Versão X.Y.Z

* Z -> Altera sempre que um bug for Corrigido
* Y -> Altera sempre que uma nova funcionalidade for implementada
* X -> Altera sempre que o código deixar de ser compativel com o código anterior

Manutenção
-----------------
Versão X.Y.Z

* Bugs -> Para Corrigir um Bug é necessário primeiro criar um teste unitário que falhe e que após ser corrigido o bug, começará a passar. E só então o bug deve ser corrigido.