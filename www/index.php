<?php
/*
$julio = '12312312318371287318732';
define('JULIO', '12312312318371287318732');
function var_global(){
    GLOBAL $julio;
    echo $julio;
}
function var_constante(){
    echo JULIO;
}

$timecomeco = microtime(true);
$i = 0;
for(;$i<10000;++$i){
    var_global();
}
var_dump('GLOBAL',number_format(microtime(true)-$timecomeco, 10));

$timecomeco = microtime(true);
$i = 0;
for(;$i<10000;++$i){
    var_constante();
}
var_dump('CONSTANTE',number_format(microtime(true)-$timecomeco, 10));

//facedetection();
exit;




/*
// Fuder tudo com Variavies nao inicializadas, afim de nao deixar ter perda de performace
function newErrorHandler($error, $message,$_1,$_2)
{
    if($error == 8)
    {
        trigger_error($message.'<br>Arquivo: '.$_1.'<br>Linha: '.$_2, E_USER_ERROR);
    }

    return false;
}
set_error_handler("newErrorHandler");
ini_set('memory_limit','512M');
include("App/Tempo.php");
include("Classes/FaceDetector/FaceDetector.php");
$tempo = new \Framework\App\Tempo('Total');
$detector = new FaceDetector();
$detector->scan("../PHP-FaceDetector/img/3.jpg");
$faces = $detector->getFaces();
foreach($faces as $face)
{
    echo "Face found at x: {$face['x']}, y: {$face['y']}, width: {$face['width']}, height: {$face['height']}<br />\n"; 
}
$tempo->Fechar();
Tempo::Imprimir();

exit;
*/
/**
 * Sierra Framework's, Bolado, Boladissimo...
 * 
 * Ricardo Rebello Sierra <web@ricardosierra.com.br>
 * Alterado
 */
// Cookies de sessão só devem ser acessados via HTTP
ini_set('session.cookie_httponly', 1);
ini_set('date.timezone', 'America/Sao_Paulo');
// COnexoes limite infinito
ini_set('mysqli.max_links', -1);

ini_set('max_execution_time', 300);
// Tipo de Linguagem
header('Content-Type: text/html; charset=UTF-8');
// Cache
/*header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");*/

// Zipa Arquivo
if (isset($_SERVER['HTTP_ACCEPT_ENCODING']) && substr_count($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip')){
    header('Content-Encoding: gzip');
    ob_start("ob_gzhandler");
}else{
    ob_start();
}
 
// Tenta Executar o Framework
try{ 
    // Inicia CONSTANTES DO SISTEMA
    define('TEMPO_COMECO', microtime(true));
    define('TEMPO_IMPRIMIR', false);
    define('DS', DIRECTORY_SEPARATOR);
    define('US', '/'); // Divisor de URL
    define('ROOT_PADRAO'    , realpath(dirname(__FILE__)). DS);
    define('APP_PATH', ROOT_PADRAO.'App'.DS);
    define("SIS_PHPVERSION" , phpversion());
    define("APP_DATA"       , date("Y-m-d"));
    define("APP_HORA"       , date("Y-m-d H:i:s"));
    define("APP_DATA_BR"    , date("d/m/Y"));
    define("APP_HORA_BR"    , date("d/m/Y H:i:s"));

    // Chama arquivo Autoload
    require_once APP_PATH . 'AutoLoad.php';
    \Framework\App\Boot::Iniciar();
    \Framework\App\Boot::Desligar();
}
// Se der MERDA, Dispara Erro
catch(Exception $e){
    if(SISTEMA_DEBUG===true){
        echo  'Mensagem: '.$e->getMessage().'<br>Codigo: '.$e->getCode().'<br>Arquivo: '.$e->getFile().'<br>Linha: '.$e->getLine();
        echo  '<br>Previus: '.$e->getPrevious().'<br>Traço: '.$e->getTraceAsString(); exit;
    }else{
        // Chama Erro
        if($e->getCode()!=404){
            Erro_Email($e->getCode(), $e->getMessage(), $e->getFile(), $e->getLine(), $e->getPrevious(), $e->getTraceAsString());
        }
        // Redireciona
        if(defined('SISTEMA_SUB') && SISTEMA_SUB!='erro' && defined('URL_PATH') && $e->getCode()!=2828)\Framework\App\Sistema_Funcoes::Erro($e->getCode());
        else _Sistema_erroControle::Erro_Puro($e->getCode());
    }
}
ob_end_flush();
?>
