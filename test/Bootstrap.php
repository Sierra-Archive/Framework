<?php
/*
//$this->assertArrayHasKey('foo', array('bar' => 'baz'));
 * 
 */
error_reporting(-1);

/**
 * Sierra Framework's, Bolado, Boladissimo...
 * 
 * Ricardo Rebello Sierra <web@ricardosierra.com.br>
 * Alterado
 */
// Cookies de sessão só devem ser acessados via HTTP
ini_set('session.cookie_httponly', 1);
// Muda Timezone para a Brasileira
ini_set('date.timezone', 'America/Sao_Paulo');
// COnexoes limite infinito
ini_set('mysqli.max_links', -1);
// Podendo Usar Memória Infinita
ini_set('memory_limit', -1);
//Upload 10 GB
ini_set('post_max_size',10485760000); 
//Upload 10 GB
ini_set('upload_max_filesize',10485760000);
// Input Time para Infinito
ini_set('max_input_time',-1);
// Tempo Maximo de Execução para Infinito
ini_set('max_execution_time', 0);
// Tipo de Linguagem
header('Content-Type: text/html; charset=UTF-8');
// Cache
/*header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");*/

// Zipa Arquivo
if (isset($_SERVER['HTTP_ACCEPT_ENCODING']) && substr_count($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip')) {
    header('Content-Encoding: gzip');
    ob_start("ob_gzhandler");
} else {
    ob_start();
}
 
// Tenta Executar o Framework
try{ 
    define('TEMPO_COMECO', microtime(true));
    define('TEMPO_IMPRIMIR', false);
    define('DS',DIRECTORY_SEPARATOR);
    define('US', '/'); // Divisor de URL
    define('ROOT_PADRAO'    , str_replace('test'.DS, 'www'.DS, realpath(dirname(__FILE__)). DS));
    define('APP_PATH', ROOT_PADRAO.'App'.DS);
    define("SIS_PHPVERSION" , phpversion());
    define("APP_DATA"       , date("Y-m-d"));
    define("APP_HORA"       , date("Y-m-d H:i:s"));
    define("APP_DATA_BR"    , date("d/m/Y"));
    define("APP_HORA_BR"    , date("d/m/Y H:i:s"));

    include_once('AutoLoader.php');
    // Register the directory to your include files
    AutoLoader::registerDirectory('../www');
}
// Se der MERDA, Dispara Erro
catch(Exception $e) {
    if (SISTEMA_DEBUG===true) {
        echo  'Mensagem: '.$e->getMessage().'<br>Codigo: '.$e->getCode().'<br>Arquivo: '.$e->getFile().'<br>Linha: '.$e->getLine();
        echo  '<br>Previus: '.$e->getPrevious().'<br>Traço: '.$e->getTraceAsString(); exit;
    } else {
        // Chama Erro
        if ($e->getCode()!=404 && $e->getCode()!=403) {
            Erro_Email($e->getCode(), $e->getMessage(), $e->getFile(), $e->getLine(), $e->getPrevious(), $e->getTraceAsString());
        }
        // Redireciona
        if (defined('SISTEMA_SUB') && SISTEMA_SUB!='erro' && defined('URL_PATH') && $e->getCode()!=2828)\Framework\App\Sistema_Funcoes::Erro($e->getCode());
        else _Sistema_erroControle::Erro_Puro($e->getCode());
    }
}
ob_end_flush();